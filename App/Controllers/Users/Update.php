<?php

namespace App\Controllers\Users;

use \Core\View;
use \App\Models\Users\User;
use \App\Auth;

class Update extends \Core\Controller 
{
    public function passwordAction()
    {
        if (Auth::isLoggedIn()) {
            $data = User::checkSession($_SESSION['username']);
            if ($data) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password']) && isset($_POST['new_password']) && isset($_POST['confirm_new_password'])) {
                    $data = [
                        'password' => $_POST['password'],
                        'new_password' => $_POST['new_password'],
                        'confirm_new_password' => $_POST['confirm_new_password'],
                    ];
    
                    $errors = [
                        'password' => '',
                        'new_password' => '',
                        'confirm_new_password' => '',
                    ];
    
                    if (empty($data['password'])) {
                        $errors['password'] = 'empty_password';
                    } else {
                        $check = User::checkPassword($_SESSION['username'], $data['password']); 
    
                        if (!$check) {
                            $errors['password'] = 'invalid_password';
                        }
                    }
    
                    if (empty($data['new_password'])) {
                        $errors['new_password'] = 'empty_password';
                    } else if (strlen($data['new_password']) < 6) {
                        $errors['new_password'] = 'to_short';
                    }
    
                    if (empty($data['confirm_new_password'])) {
                        $errors['confirm_new_password'] = 'empty_password';
                    } else if ($data['confirm_new_password'] !== $data['new_password']) {
                        $errors['confirm_new_password'] = 'not_same';
                    }
    
                    if (empty($errors['password']) && empty($errors['new_password']) && empty($errors['confirm_new_password'])) {
                        $check = User::updatePassword($_SESSION['username'], $data['new_password']);
                        
                        if ($check) {
                            echo json_encode(['success' => 'true']);
                        } else {
                            echo json_encode(['fail' => 'request_failed']);
                        }
                    } else {
                        echo json_encode($errors);    
                    }          
                } else {
                    static::redirect('/login');
                }
            } else {
                Auth::destroySession();
            }
        } else {
            static::redirect('/login');
        }
    }

    public function redirectAction()
    {
        if (Auth::isLoggedIn()) {
            $data = User::checkSession($_SESSION['username']);
            if ($data) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['redirect'])) {
                    $data = ['redirect' => $_POST['redirect']];
                    $error = ['redirect' => ''];
    
                    if (empty($data['redirect'])) {
                        $error['redirect'] = 'empty_redirect';
                    } else if (!filter_var($data['redirect'], FILTER_VALIDATE_URL)) {
                        $error['redirect'] = 'invalid_redirect';
                    }
    
                    if (empty($error['redirect'])) {
                        $check = User::updateRedirect($data['redirect']);
                        
                        if ($check) {
                            echo json_encode(['success' => 'true']);
                        } else {
                            echo json_encode(['fail' => 'request_failed']);
                        }
                    } else {
                        echo json_encode($error);    
                    } 
                } else {
                    static::redirect('/login');
                }
            } else {
                Auth::destroySession();
            }
        } else {
            static::redirect('/login');
        }
    }
}