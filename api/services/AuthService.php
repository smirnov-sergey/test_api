<?php

namespace api\services;

use Exception;
use RuntimeException;

/**
 * Class AuthService
 * @package api\services
 * @deprecated
 */
class AuthService
{
    private const LOGIN = 'test';
    private const PASSWORD = 12345;
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
     * @param $token
     * @return bool
     */
    public function checkToken($token): bool
    {
        try {
            if ($token === self::TOKEN) {
                return true;
            }

            throw new RuntimeException('Invalid token', 401);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return self::TOKEN;
    }
}