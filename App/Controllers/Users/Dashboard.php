<?php

namespace App\Controllers\Users;

use \Core\View;
use \App\Models\Users\User;
use \App\Auth;

class Dashboard extends \Core\Controller 
{
    public function dashboardAction()
    {
        if (Auth::isLoggedIn()) {
            $data = User::checkSession($_SESSION['username']);
            if ($data) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    static::redirect('/dashboard');
                } else {
                    $count = User::getUserCount();
                    $request = User::getRequestCount($_SESSION['username']);
                    $log = User::getLogCount($_SESSION['username']);
                    View::render('Users/dashboard.php', [
                        'title' => 'Dashboard',
                        'count' => $count,
                        'request' => $request,
                        'log' => $log
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