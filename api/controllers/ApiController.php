<?php

namespace api\controllers;

use RuntimeException;

//require_once 'api/controllers/Controller.php';

class ApiController
{
    private $request_params = [];
    private $request_uri = '';
    private $request_method = '';

    private $action = '';

    private $login = '';
    private $password = '';


    public function __construct()
    {
        $this->request_params = $_REQUEST;
        $this->request_uri = explode('?', $_SERVER['REQUEST_URI']);
        $this->request_method = $_SERVER['REQUEST_METHOD'];

        if ($this->request_method === 'GET') {
            $this->login = $_GET['login'];
            $this->password = $_GET['password'];
        } elseif ($this->request_method === 'POST') {
            $this->login = $_POST['login'];
            $this->password = $_POST['password'];
        }
    }

    public function run()
    {
        $this->action = $this->getAction();

        if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            throw new RuntimeException('Route not found', 405);
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

                if ($request_uri === '/api/user/update') {
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
        if ($this->login == 'ivan' && $this->password == '12345') {
            return json_encode(['status' => 'Ok', 'token' => 'dsfd79843r32d1d3dx23d32d']);
        } elseif ($this->login == 'petr' && $this->password == '222') {
            return json_encode(['status' => 'Ok', 'token' => 'token2']);
        }

        return json_encode(['error' => 'Invalid login or password']);

//        if ($this->auth_service->checkAuth($login, $password)) {
//            return $this->responseAuth(200);
//        }
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
            if ($_GET['login'] && $_GET['token']) {
                if ($_GET['login'] == 'ivan'
                    && $_GET['token'] == 'dsfd79843r32d1d3dx23d32d'
                ) {
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
                } else {
                    return json_encode(['error' => 'Invalid login or token']);
                }
            } else {
                return json_encode(['error' => 'Login or token missing']);
            }
        } else {
            return json_encode(['error' => 'Invalid method']);
        }
    }

    /**
     * Отправка данных пользователя
     * http://testapi.ru/api/user/update?token=****
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
}