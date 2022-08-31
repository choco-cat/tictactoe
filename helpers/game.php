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

$message = $gamer->checkGameOverUser();
if ($message) {
    echo json_encode(array('message' => $message));
    exit();
}
$step = $gamer->nextStep();

$message = $gamer->checkGameOverBot($step);

echo json_encode(array('step' => $step, 'message' => $message));
