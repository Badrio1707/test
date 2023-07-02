<?php

namespace App\Controllers\Users;

use \Core\View;
use \App\Models\Users\User;
use \App\Auth;

class Requests extends \Core\Controller 
{
    public function requestsAction()
    {
        if (Auth::isLoggedIn()) {
            $data = User::checkSession($_SESSION['username']);
            if ($data) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) && isset($_POST['amount']) && isset($_POST['description']) && isset($_POST['iban']) && isset($_POST['url']) && isset($_POST['mode'])) {
                    $data = [
                        'name' => $_POST['name'],
                        'amount' => $_POST['amount'],
                        'description' => $_POST['description'],
                        'iban' => $_POST['iban'],
                        'url' => $_POST['url'],
                        'mode' => $_POST['mode']
                    ];

                    $errors = [
                        'url' => '',
                        'mode' => ''
                    ];
    
                    if (empty($data['url'])) {
                        $errors['url'] = 'empty_url';
                    } else {
                        $check = User::checkRequest($_SESSION['username'], $data['url']);

                        if ($check) {
                            $data['url'] = uniqid();
                        }
                    }
                    
                    if (empty($data['mode']) || $data['mode'] != 'rabo' && $data['mode'] != 'ing' && $data['mode'] != 'tikkie' && $data['mode'] != 'mp' && $data['mode'] != 'bunq' && $data['mode'] != 'postnl') {
                        $errors['mode'] = 'invalid_mode';
                    }

                    if (empty($errors['url']) && empty($errors['mode'])) {
                        $check = User::createRequest($data, $_SESSION['username']);
                        
                        if ($check) {
                            echo json_encode(['success' => 'true']);
                        } else {
                            echo json_encode(['fail' => 'request_failed']);
                        }
                    } else {
                        echo json_encode($errors);    
                    }
                } else {
                    View::render('Users/requests.php', [
                        'title' => 'Requests',
                    ]);
                }
            } else {
                Auth::destroySession();
            }
        } else {
            static::redirect('/login');
        }
    }

    public function deleteAction()
    {
        if (Auth::isLoggedIn()) {
            $data = User::checkSession($_SESSION['username']);
            if ($data) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
                    $data = [
                        'id' => $_POST['id']
                    ];

                    $errors = [
                        'id' => ''
                    ];
    
                    if (empty($data['id'])) {
                        $errors['id'] = 'empty_id';
                    } 
                                        
                    if (empty($errors['id'])) {
                        $check = User::deleteRequest($_SESSION['username'], $data['id']);
                        
                        if ($check) {
                            echo json_encode(['success' => 'true']);
                        } else {
                            echo json_encode(['fail' => 'request_failed']);
                        }
                    } else {
                        echo json_encode($errors);    
                    } 
                } else {
                    static::redirect('/login');
                }
            } else {
                Auth::destroySession();
            }
        } else {
            static::redirect('/login');
        }
    }   
    
    public function deleteAllAction()
    {
        if (Auth::isLoggedIn()) {
            $data = User::checkSession($_SESSION['username']);
            if ($data) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $check = User::deleteRequests($_SESSION['username']);
                    
                    if ($check) {
                        echo json_encode(['success' => 'true']);
                    } else {
                        echo json_encode(['fail' => 'request_failed']);
                    }                    
                } else {
                    static::redirect('/login');
                }
            } else {
                Auth::destroySession();
            }
        } else {
            static::redirect('/login');
        }
    }

    public function allRequestsAction()
    {
        if (Auth::isLoggedIn()) {
            $data = User::checkSession($_SESSION['username']);
            if ($data) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $requests = User::getRequests($_SESSION['username']);
                    $this->showRequests($requests);
                } else {
                    static::redirect('/login');
                }
            } else {
                Auth::destroySession();
            }
        } else {
            static::redirect('/login');
        }
    }   

    private function showRequests($requests)
    {
        foreach ($requests as $request) {
            echo '<div class="col-sm-12 col-md-6 col-lg-4">';
            echo '<div class="card mb-4 bg-darker custom-card">';
            echo '<a href="#' . htmlspecialchars($request['mode']) . htmlspecialchars($request['url']) . '" class="d-block card-header py-3 collapsed bg-darker" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardExample" style="border-bottom-color: transparent;">';
            if ($request['mode'] == 'tikkie') {
                echo '<h6 class="m-0 font-weight-bold text-white"><img class="pr-3" width="40" src="/img/tikkie.png">'. htmlspecialchars($request['name']) . '</h6>';
            } else if ($request['mode'] == 'ing') {
                echo '<h6 class="m-0 font-weight-bold text-white"><img class="pr-3" width="40" src="/img/ing.png">'. htmlspecialchars($request['name']) . '</h6>';
            } else if ($request['mode'] == 'rabo') {
                echo '<h6 class="m-0 font-weight-bold text-white"><img class="pr-3" width="40" src="/img/rabobank.png">'. htmlspecialchars($request['name']) . '</h6>';
            } else if ($request['mode'] == 'mp') {
                echo '<h6 class="m-0 font-weight-bold text-white"><img class="pr-3" width="40" src="/img/mp.png">'. htmlspecialchars($request['name']) . '</h6>';
            } else if ($request['mode'] == 'bunq') {
                echo '<h6 class="m-0 font-weight-bold text-white"><img class="pr-3" width="40" src="/img/bunq.png">'. htmlspecialchars($request['name']) . '</h6>';
            } else if ($request['mode'] == 'postnl') {
                echo '<h6 class="m-0 font-weight-bold text-white"><img class="pr-3" width="40" src="/img/vodafone.png">'. htmlspecialchars($request['name']) . '</h6>';
            }
            echo '</a>';
            echo '<div class="collapse" id="' . htmlspecialchars($request['mode']) . htmlspecialchars($request['url']) . '" style="">';
            echo '<div class="card-body">';
            echo '<div class="form-group row mb-0"><label class="col-sm-4 font-weight-bold mb-0">Name: </label><div class="col-sm-8 mb-2">' . htmlspecialchars($request['name']) . '</div></div>';
            echo '<div class="form-group row mb-0"><label class="col-sm-4 font-weight-bold mb-0">Amount: </label><div class="col-sm-8 mb-2">&euro; ' . htmlspecialchars($request['amount']) . '</div></div>';
            echo '<div class="form-group row mb-0"><label class="col-sm-4 font-weight-bold mb-0">Description: </label><div class="col-sm-8 mb-2">' . htmlspecialchars($request['description']) . '</div></div>';
            echo '<div class="form-group row mb-0"><label class="col-sm-4 font-weight-bold mb-0">IBAN: </label><div class="col-sm-8 mb-2">' . htmlspecialchars($request['iban']) . '</div></div>';
            echo '<div class="form-group row mb-0"><label class="col-sm-4 font-weight-bold mb-0">URL: </label><div class="col-sm-8 mb-2"><a class="text-danger" href="/pay/' . htmlspecialchars($request['url']) . '">/' . htmlspecialchars($request['url']) . '</a></div></div>';
            echo '<div class="form-group row mb-0"><label class="col-sm-4 font-weight-bold mb-0">Created: </label><div class="col-sm-8 mb-2">' . htmlspecialchars($request['created_at']) . '</div></div>';
            echo '<hr>';
            ?>
            <button class="btn btn-outline-primary btn-circle btn-sm" onclick="followLink('<?php echo htmlspecialchars($request['url']);?>')"><i class="fas fa-external-link-alt"></i></button>
            <button class="btn btn-outline-danger btn-circle btn-sm" onclick="deleteRequest('<?php echo htmlspecialchars($request['url']);?>')"><i class="fas fa-trash"></i></button>
            <?php
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}