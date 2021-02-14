<?php

namespace api\controllers;

use api\models\UsersApi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

require_once 'api/models/UsersApi.php';

class UsersController extends UsersApi
{
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
     * @throws GuzzleException
     */
    public function actionAuth($login = 'test', $password = 12345)
    {
//        $response = $this->client->request('GET', '/auth', [
//            'query' => [
//                'login' => $login,
//                'password' => $password
//            ],
//            'headers' => [
//                'Access-Control-Allow-Origin' => '*',
//                'Access-Control-Allow-Methods' => '*',
//                'Content-Type' => 'application/json'
//            ]
//        ]);
//        $this->client->request('GET', '/auth', ['auth' => ['login', 'password']]);

        if ($this->method === 'GET') {
            if ($this->auth_service->checkAuth($login, $password)) {
                return $this->responseAuth(200);
            }

            throw new RuntimeException('Неверный логин или пароль', 401);
        }

        throw new RuntimeException('Отсутствуют входящие параметры');
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
     * @return false|int|string
     */
    public function actionGetUser($username = 'ivanov')
    {
//        $response = $this->client->request('POST', '/get-user', [
//            'query' => [
//                'token' => $token,
//                'username' => $username,
//            ],
//            'json' => [
//                'status' => 'OK',
//                'active' => '1',
//                'blocked' => false,
//                'created_at' => 1587457590,
//                'id' => 23,
//                'name' => 'Ivanov Ivan',
//                'permissions' => [
//                    'id' => 1,
//                    'permission' => 'comment'
//                ]
//            ]
//        ]);

        // token должен быть первым параметром после /get-user/
        // $token = array_shift($this->request_uri);

        if ($this->method === 'GET') {
            if ($token) {
                if ($this->auth_service->checkToken($token)) {
                    return $this->responseGetUser($username);
                }
            }
        }

        throw new RuntimeException('Отсутствуют входящие параметры');
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
    public function actionUserUpdate($data)
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

        throw new RuntimeException('Отсутствуют входящие параметры');
    }
}