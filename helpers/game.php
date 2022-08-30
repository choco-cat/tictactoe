<?php
use classes\Gamer;

const SYMBOL_BOT = '0';
define('BASE_PATH', dirname(realpath(__FILE__)) . '/');
include (BASE_PATH . 'autoload.php');

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
$step['symb'] = SYMBOL_BOT;

$message = $gamer->checkGameOverBot($step);

echo json_encode(array('step' => $step, 'message' => $message));
