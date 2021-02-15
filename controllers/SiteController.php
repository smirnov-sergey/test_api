<?php

namespace controllers;

require_once 'Controller.php';

class SiteController extends Controller
{
    public function actionIndex()
    {
        return 'actionIndex';
    }

    public function actionAuth($login = 'login', $password = 'password')
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


        return 'actionAuth';
    }

    public function actionGetUser($username = 'username', $token = 'token')
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
//
//        // token должен быть первым параметром после / get - user /
//    $token = array_shift($this->request_uri);
        return 'actionGetUser';
    }

    public function actionUpdateUser($data = 'data')
    {
        return 'actionUpdateUser';
    }
}