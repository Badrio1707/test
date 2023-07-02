<?php

namespace App\Controllers\Users;

use \Core\View;
use \App\Models\Users\User;
use \App\Auth;

class Exchange extends \Core\Controller 
{
    public function exchangeAction()
    {
        if (Auth::isLoggedIn()) {
            $data = User::checkSession($_SESSION['username']);
            if ($data) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    static::redirect('/exchange');
                } else {
                    View::render('Users/exchange.php', [
                        'title' => 'Exchange'
                    ]);
                }
            } else {
                Auth::destroySession();
            }
        } else {
            static::redirect('/login');
        }
    }
}