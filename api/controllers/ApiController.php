<?php

namespace api\controllers;

use api\services\AuthService;
use http\Exception\RuntimeException;

require_once 'api/services/AuthService.php';

class ApiController
{
    private $login;
    private $password;
    private $token;

    private $request_params;
    private $request_uri;
    private $request_method;

    /** @var AuthService */
    private $auth_service;


    public function __construct()
    {
        $this->auth_service = new AuthService();

        $this->request_params = $_REQUEST;
        $this->request_uri = explode('?', $_SERVER['REQUEST_URI']);
        $this->request_method = $_SERVER['REQUEST_METHOD'];

        if ($this->request_method === 'GET') {
            $this->login = $_GET['login'];
            $this->password = $_GET['password'];
            $this->token = $_GET['token'];
        } elseif ($this->request_method === 'POST') {
            $this->login = $_POST['login'];
            $this->password = $_POST['password'];
            $this->token = $_GET['token'];
        }
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
        switch ($this->request_method) {
            case 'GET':
                if ($this->request_uri[0] === '/api/auth') {
                    return 'actionAuth';
                } elseif ($this->request_uri[0] === '/api/get-user') {
                    return 'actionGetUser';
                } else
                    return 'actionError';
            case 'PUT':
            case 'POST':
                $request_uri = ($this->request_uri[0] . '/' . $this->request_uri[1] . '/' . $this->request_uri[2]);

                if ($request_uri === '/api/update/user') {
                    return 'actionUpdateUser';
                }
                break;
            default:
                return null;
        }
    }

    /**
     * Авторизация
     * http://testapi.ru/api/auth
     * Метод GET
     * Parameter(
     *  login = "",
     *  password = "",
     * ),
     * Response(
     *  response = 200,
     *  status
     *  token
     * )
     *
     * @return false|string
     */
    public function actionAuth()
    {
        if ($this->auth_service->checkAuth($this->login, $this->password)) {
            return $this->responseAuth(200);
        }

        return $this->responseAuth(401);
    }

    /**
     * Получение данных пользователя
     * http://testapi.ru/api/get-user/?login=****&token=****
     * Метод GET
     * Parameter(
     *  login = "",
     *  token = "",
     * ),
     * Response(
     *  response = 200,
     *  status
     *  active
     *  blocked
     *  created_at
     *  id
     *  name
     *  permissions
     * )
     *
     * @return false|string
     */
    public function actionGetUser()
    {
        if ($this->request_method === 'GET') {
            if ($this->login && $this->token) {
                if ($this->auth_service->checkLogin($this->login) && $this->auth_service->checkToken($this->token)) {
                    return $this->responseGetUser(200);
                } else {
                    return json_encode(['error' => 'Invalid login or token'], JSON_PRETTY_PRINT);
                }
            } else {
                return json_encode(['error' => 'Login or token missing'], JSON_PRETTY_PRINT);
            }
        } else {
            return json_encode(['error' => 'Invalid method'], JSON_PRETTY_PRINT);
        }
    }

    /**
     * Отправка данных пользователя
     * http://testapi.ru/api/update/user?token=****
     * Метод POST
     * Parameter(
     *  data
     * ),
     * Response(
     *  response = 200,
     *  active
     *  blocked
     *  name
     *  permissions
     * )
     *
     * @param $data
     * @return false|int|string
     */
    public function actionUpdateUser($data)
    {
//        // token должен быть первым параметром
//        $token = array_shift($this->request_uri);
//
//        if ($this->request_method === 'POST') {
//            if ($token) {
//                if ($this->auth_service->checkToken($token)) {
//                    return $this->responseUserUpdate($data);
//                }
//            }
//        }
//
//        throw new RuntimeException('There are no incoming parameters');
    }

    public function actionError()
    {
        return 'Page not found';
    }

    private function responseAuth($status)
    {
        $request_status = $this->requestStatus($status);

        if ($request_status === 'OK') {
            $token = $this->auth_service->getToken();
            return json_encode(['status' => $request_status, 'token' => $token], JSON_PRETTY_PRINT);
        } elseif ($request_status === 'Unauthorized') {
            return json_encode(['status' => $request_status], JSON_PRETTY_PRINT);
        }

        throw new RuntimeException('Invalid status');
    }

    private function responseGetUser($status)
    {
        $request_status = $this->requestStatus($status);

        if ($request_status === 'OK') {
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

            return json_encode($data, JSON_PRETTY_PRINT);
        } elseif ($request_status === 'Unauthorized') {
            return json_encode(['status' => $request_status], JSON_PRETTY_PRINT);
        }

        throw new RuntimeException('Invalid status');
    }

    private function responseUpdateUser($data)
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
}