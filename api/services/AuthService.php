<?php

namespace api\services;

class AuthService
{
    private const LOGIN = 'user';
    private const PASSWORD = '12345';
    private const TOKEN = 'dsfd79843r32d1d3dx23d32d';


    /**
     * @param $login
     * @param $password
     * @return bool
     */
    public function checkAuth($login, $password): bool
    {
        return $login === self::LOGIN && $password === self::PASSWORD;
    }

    /**
     * @param $login
     * @return bool
     */
    public function checkLogin($login): bool
    {
        return $login === self::LOGIN;
    }

    /**
     * @param $token
     * @return bool
     */
    public function checkToken($token): bool
    {
        return $token === self::TOKEN;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return self::TOKEN;
    }
}