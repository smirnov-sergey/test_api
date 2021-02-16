<?php

namespace controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

require_once 'Controller.php';

class SiteController extends Controller
{
    public function actionIndex()
    {
//        $client = new Client(['base_uri' => 'http://localhost/api', ['timeout' => 2]]);
//        $client = new Client(['base_uri' => 'http://localhost/api']);
//        $client = new Client();
//        $response = $client->get('http://localhost/api/auth');
//        $request = new Request('GET', 'http://localhost/api/auth');
//        $response = $client->send($request, ['timeout' => 2]);
//
//        var_dump($response->getBody());
//        die();
//        $response = $client->request('GET', '/auth', [
//            'query' => [
//                'login' => 'ivan',
//                'password' => '12345'
//            ],
//            'headers' => [
//                'Access-Control-Allow-Origin' => '*',
//                'Access-Control-Allow-Methods' => '*',
//                'Content-Type' => 'application/json'
//            ]
//        ]);
//
//        $response->getBody();
//        var_dump($response);
//        die();

        return 'actionIndex';
    }

    public function actionAuth()
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

    public function actionGetUser()
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

    public function actionUpdateUser()
    {
        return 'actionUpdateUser';
    }

    public function actionError()
    {
        return 'Page not found';
    }
}