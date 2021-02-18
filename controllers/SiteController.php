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
        return 'actionUpdateUser';
    }

    public function actionError()
    {
        return 'Page not found';
    }
}