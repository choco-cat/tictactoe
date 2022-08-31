<?php
use classes\Gamer;

define('BASE_PATH', dirname(realpath(__FILE__)) . '/');
include(BASE_PATH . './../autoload.php');

$data = $_POST;
if (!$data['board']) {
    return;
}
$board = $data['board'];
$gamer = new Gamer($board);

$response = $gamer->checkGameOverUser();
if ($response['message']) {
    echo json_encode($response);
    exit();
}

$gamer->nextStep();

$response = $gamer->checkGameOverBot();

echo json_encode($response);
