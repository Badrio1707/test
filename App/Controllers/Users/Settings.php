<?php

namespace App\Controllers\Users;

use \Core\View;
use \App\Models\Users\User;
use \App\Auth;

class Settings extends \Core\Controller 
{
    public function settingsAction()
    {
        if (Auth::isLoggedIn()) {
            $data = User::checkSession($_SESSION['username']);
            if ($data) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    static::redirect('/settings');
                } else {
                    View::render('Users/settings.php', [
                        'title' => 'Settings'
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