<?php

namespace controllers;

use GuzzleHttp\Client;

abstract class Controller
{
    private $request_uri;
    private $request_params;
    private $method = '';

    /** @var Client */
    protected $client;


    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://testapi.ru']);

        $this->request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->request_params = $_REQUEST;

        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function run()
    {
        $action = $this->getAction();

        if (method_exists($this, $action)) {
            return $this->{$action}();
        } else {
            return 'Route not found';
        }
    }

    private function getAction()
    {
        switch ($this->method) {
            case 'GET':
                if ($this->request_uri[0] === 'auth') {
                    return 'actionAuth';
                } elseif ($this->request_uri[0] === 'get-user') {
                    return 'actionGetUser';
                } else
                    return 'actionError';
            case 'PUT':
            case 'POST':
                if (($this->request_uri[0] . '/' . $this->request_uri[1]) === 'update/user') {
                    return 'actionUpdateUser';
                }
                break;
            default:
                return null;
        }
    }

    abstract protected function actionAuth();

    abstract protected function actionGetUser();

    abstract protected function actionUpdateUser();

    abstract protected function actionError();
}