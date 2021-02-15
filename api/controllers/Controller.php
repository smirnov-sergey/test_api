<?php

namespace api\controllers;

use api\services\AuthService;
use RuntimeException;

require_once 'api/services/AuthService.php';

abstract class Controller
{
    public $request_uri = [];
    public $request_params = [];

    protected $method = '';
    protected $action = '';

    /** @var AuthService */
    protected $auth_service;


    public function __construct()
    {
        $this->auth_service = new AuthService;
        $this->request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->request_params = $_REQUEST;

        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function run()
    {
        $this->action = $this->getAction();

        // Если метод определен в дочернем классе API
        if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            throw new RuntimeException('Invalid Method', 405);
        }
    }

    private function getAction()
    {
        $method = $this->method;

        switch ($method) {
            case 'GET':
                if ($this->request_uri[0] === 'auth') {
                    return 'actionAuth';
                } elseif ($this->request_uri[0] === 'get-user') {
                    return 'actionGetUser';
                } else
                    return null;
                break;
            case 'PUT':
            case 'POST':
                if (($this->request_uri[0] . '/' . $this->request_uri[1]) === 'user/update') {
                    return 'actionUserUpdate';
                }
                break;
            default:
                return null;
        }
    }

    private function requestStatus($code): string
    {
        $status = [
            200 => 'OK',
            401 => 'Unauthorized',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ];

        return ($status[$code]) ?: $status[500];
    }


    protected function response($status = 500)
    {
        if ($this->requestStatus($status) === 200) {
            return json_encode(['status' => $status]);
        }

        throw new RuntimeException('Invalid status');
    }

    protected function responseAuth($status)
    {
        if ($this->requestStatus($status) === 200) {
            $token = $this->auth_service->getToken();

            return json_encode(['status' => $status, 'token' => $token]);
        }

        throw new RuntimeException('Invalid status');
    }

    protected function responseGetUser($username)
    {
        if ($username === 'ivanov') {
            $data = [
                'status' => 'OK',
                'active' => '1',
                'blocked' => false,
                'created_at' => 1587457590,
                'id' => 23,
                'name' => 'Ivanov Ivan',
                'permissions' => [
                    'id' => 1,
                    'permission' => 'comment'
                ]
            ];

            return json_encode($data);
        }

        throw new RuntimeException('User is not found');
    }

    protected function responseUserUpdate($data)
    {
        if ($data) {
            $data = [
                'status' => 'OK',
                'active' => '1',
                'blocked' => true,
                'name' => 'Petr Petrovich',
                'permissions' => [
                    'id' => 1,
                    'permission' => 'comment'
                ]
            ];

            return json_encode($data);
        }

        throw new RuntimeException('No data available');
    }

    abstract protected function actionAuth($login, $password);

    abstract protected function actionGetUser($username, $token);

    abstract protected function actionUpdateUser($data);
}