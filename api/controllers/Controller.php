<?php

namespace api\controllers;

use api\services\AuthService;
use RuntimeException;

require_once 'api/services/AuthService.php';

/**
 * Class Controller
 * @package api\controllers
 * @deprecated
 */
abstract class Controller
{
    public $request_uri = '';
    public $request_params = [];

    protected $method = '';
    protected $action = '';

    /** @var AuthService */
    protected $auth_service;


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

    abstract protected function actionAuth();

    abstract protected function actionGetUser($username, $token);

    abstract protected function actionUpdateUser($data);
}