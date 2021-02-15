<?php

namespace controllers;

use GuzzleHttp\Client;
use RuntimeException;

abstract class Controller
{
    protected $request_uri = [];
    protected $request_params = [];

    protected $method = '';
    protected $action = '';

    /** @var Client */
    protected $client;


    public function __construct()
    {
//        $this->client = new Client(['base_uri' => 'http://testapi.ru']);
        $this->client = new Client(['base_uri' => 'http://httpbin.org']);

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
            throw new RuntimeException('Route not found', 405);
        }
    }

    private function getAction()
    {
        $method = $this->method;

        switch ($method) {
            case 'GET':
                if ($this->request_uri[0] === 'index') {
                    return 'actionIndex';
                } elseif ($this->request_uri[0] === 'auth') {
                    return 'actionAuth';
                } elseif ($this->request_uri[0] === 'get-user') {
                    return 'actionGetUser';
                } else
                    throw new RuntimeException('GET Route not found', 405);
            case 'PUT':
            case 'POST':
                if (($this->request_uri[0] . '/' . $this->request_uri[1]) === 'user/update') {
                    return 'actionUpdateUser';
                }
                break;
            default:
                return null;
        }
    }

    abstract protected function actionIndex();

    abstract protected function actionAuth($login, $password);

    abstract protected function actionGetUser($username, $token);

    abstract protected function actionUpdateUser($data);
}