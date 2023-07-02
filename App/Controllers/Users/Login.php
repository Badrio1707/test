<?php

namespace App\Controllers\Users;

use \Core\View;
use \App\Models\Users\User;
use \App\Auth;

class Login extends \Core\Controller 
{
    public function loginAction()
    {
        if (!Auth::isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
                $data = [
                    'username' => $_POST['username'],
                    'password' => $_POST['password']
                ];
    
                $errors = [
                    'username' => '',
                    'password' => ''
                ];
    
                if (empty($data['username'])) {
                    $errors['username'] = 'empty_username';
                } else {
                    $check = User::checkUsername($data['username']);
                    
                    if (!$check) {
                        $errors['username'] = 'invalid_username';
                    }
                }
    
                if (empty($data['password'])) {
                    $errors['password'] = 'empty_password';
                }
    
                if (empty($errors['username']) && empty($errors['password'])) {
                    $check = User::checkPassword($data['username'], $data['password']);
    
                    if (!$check) {
                        $errors['password'] = 'invalid_password';
                        echo json_encode($errors);
                    } else {
                        Auth::createSession($check);
                        echo json_encode(['success' => 'true']);
                    }
                } else {
                    echo json_encode($errors);
                }
            } else {
                View::render('Users/login.php', [
                    'title' => 'Login'
                ]);
            }
        } else {
            static::redirect('/dashboard');
        }
    }

    public function setOnlineAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_SESSION['pay'])) {
            User::updateTime($_POST['id']);
        } else {
            static::redirect('https://www.google.nl');
        }
    }

    public function destroyAction()
    {
        if (Auth::isLoggedIn()) {
            Auth::destroySession();
        } else {
            static::redirect('/login');
        }
    }
}