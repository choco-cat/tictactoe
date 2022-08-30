<?php
const SYMBOL_BOT = '0';
require_once('./../classes/Gamer.php');

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
