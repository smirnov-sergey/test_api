<?php

namespace controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

require_once 'Controller.php';

class SiteController extends Controller
{
    public function actionIndex()
    {
        return 'actionIndex';
    }

    public function actionAuth()
    {
        /**
         * тест Guzzle -> 'http://httpbin.org'. Успешно
         */
//        $client = new Client(['base_uri' => 'http://httpbin.org']);
//        $response = $client->request('GET');
//        var_dump($response);

        $response = $this->client->request('GET', '/auth', [
            'query' => [
                'login' => 'ivan',
                'password' => '12345'
            ],
            'headers' => [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => '*',
                'Content-Type' => 'application/json'
            ]
        ]);
        var_dump($response->getBody());

        return 'actionAuth';
    }

    public function actionGetUser()
    {
//        $response = $this->client->request('POST', '/get-user', [
//            'query' => [
//                  'username' => ivan,
//                  'token' => dsfd79843r32d1d3dx23d32d,
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

        return 'actionGetUser';
    }

    public function actionUpdateUser()
    {
        return 'actionUpdateUser';
    }

    public function actionError()
    {
        return 'Page not found';
    }
}