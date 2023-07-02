<?php

namespace App\Controllers\Users;

use \Core\View;
use \App\Models\Users\User;
use \App\Auth;

class Overview extends \Core\Controller
{
    public function indexAction()
    {   
        if (Auth::isLoggedIn()) {
            if (!User::checkForPayment($this->route_params['id'])) {
                static::redirect('/logs');
            } else {
                View::render('Users/overview.php', $data = [
                    'title' => 'Overview',
                    'token' => $this->route_params['id']
                ]); 
            }
        } else {
            static::redirect('/login');
        }
    }
}