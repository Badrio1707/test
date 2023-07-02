<?php

namespace App;

class Auth
{
    public static function createSession($data)
    {
        session_regenerate_id(true);

        $_SESSION['username'] = $data['username'];
        $_SESSION['user_id'] = uniqid();
    }

    public static function destroySession()
    {
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);

        header('location: /login');
        exit;
    }

    public static function isLoggedIn()
    {
        if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }
}