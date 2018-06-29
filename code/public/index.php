<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

session_start();

//if ('identification' == $_GET['page'] and isset($_SESSION['identifie'])
//    && true === $_SESSION['identifie']) {
//    header('Location: index.php');
//    require dirname(__FILE__) . '/../include/connexion.php';
//}

//charger une config applicative
$config = require dirname(dirname(__FILE__)) . '/config/di.global.php';

//kernel applicatif
$application = \App\Application::createFromConfig($config);
echo $application->run()->getBody();