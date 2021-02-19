<?php

namespace controllers;

require_once 'Controller.php';

class SiteController extends Controller
{
    public function actionAuth()
    {
        $response = $this->client->request('GET', '/api/auth', [
            'query' => [
                'login' => 'user',
                'password' => '12345'
            ]
        ]);

        if ($response->getBody()) {
            return $response->getBody();
        }

        return 'No response body';
    }

    public function actionGetUser()
    {
        $response = $this->client->request('GET', '/api/get-user', [
            'query' => [
                'login' => 'user',
                'token' => 'dsfd79843r32d1d3dx23d32d',
            ]
        ]);

        if ($response->getBody()) {
            return $response->getBody();
        }

        return 'No response body';
    }

    public function actionUpdateUser()
    {
        $response = $this->client->request('POST', '/api/update/user', [
            'query' => [
                'login' => 'user',
                'token' => 'dsfd79843r32d1d3dx23d32d',
                'data' => [
                    'status' => 'OK',
                    'active' => '1',
                    'blocked' => true,
                    'name' => 'Petr Petrovich',
                    'permissions' => [
                        'id' => 1,
                        'permission' => 'comment'
                    ]
                ]
            ],
        ]);

        if ($response->getBody()) {
            return $response->getBody();
        }

        return 'actionUpdateUser';
    }

    public function actionError(): string
    {
        return 'Page not found';
    }
}