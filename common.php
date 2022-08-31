<?php
define('BASE_PATH', dirname(realpath(__FILE__)) . '/');
include(BASE_PATH . 'configDB.php');
include(BASE_PATH . 'autoload.php');
define('VIEW_PATH', BASE_PATH . 'view/');
require_once './vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(VIEW_PATH);
$twig = new \Twig\Environment($loader, [
    'cache' => './cache',
]);