<?php

namespace Project;

use Project\Controller\IndexController;
use Project\Utilities\Tools;

session_start();

define('ROOT_PATH', getcwd());

require ROOT_PATH . '/vendor/autoload.php';

$route = 'index';

if (Tools::getValue('route') !== false) {
    $route = Tools::getValue('route') ;
}
$configuration = new Configuration();
$routing = new Routing($configuration);

try {
    $routing->startRoute($route);
} catch(\InvalidArgumentException $error) {
    $indexController = new IndexController($configuration);
    $indexController->errorPageAction();
}
