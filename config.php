<?php

define('BASE_PATH', dirname(realpath(__FILE__)) . '/');
include(BASE_PATH . 'autoload.php');
define('DATABASE_HOST', 'localhost');
define('DATABASE_NAME', "tictactoe");
define('DATABASE_USER', "root");
define('DATABASE_PASSWORD', "root");

const VIEW_PATH = BASE_PATH . 'view/';
require_once './vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(VIEW_PATH);
$twig = new \Twig\Environment($loader, [
    'cache' => './cache',
]);