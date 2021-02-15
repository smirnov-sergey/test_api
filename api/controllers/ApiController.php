<?php

namespace api\controllers;

use RuntimeException;

require_once 'api/controllers/Controller.php';

class ApiController extends Controller
{
    public function actionIndex()
    {
        return 'ApiIndex';
    }

    /**
     * Авторизация
     * http://testapi.ru/auth
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
     * @param $login
     * @param $password
     * @return false|int|string
     */
    public function actionAuth($login, $password)
    {
        if ($this->method === 'GET') {
            if ($this->auth_service->checkAuth($login, $password)) {
                return $this->responseAuth(200);
            }

            throw new RuntimeException('Invalid login or password', 401);
        }

        throw new RuntimeException('There are no incoming parameters');

    }

    /**
     * Получение данных пользователя
     * http://testapi.ru/get-user/?token=
     * Метод GET
     * Parameter(
     *  username = "",
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
     * @param $username
     * @param $token
     * @return false|int|string
     */
    public function actionGetUser($username, $token)
    {
        if ($this->method === 'GET') {
            if ($token) {
                if ($this->auth_service->checkToken($token)) {
                    return $this->responseGetUser($username);
                }
            }
        }

        throw new RuntimeException('There are no incoming parameters');
    }

    /**
     * Отправка данных пользователя
     * http://testapi.ru/user/update?token=
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
        // token должен быть первым параметром
        $token = array_shift($this->request_uri);

        if ($this->method === 'POST') {
            if ($token) {
                if ($this->auth_service->checkToken($token)) {
                    return $this->responseUserUpdate($data);
                }
            }
        }

        throw new RuntimeException('There are no incoming parameters');
    }
}