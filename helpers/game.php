<?php
$data = $_POST;
if (!$data['board']) {
    return;
}
const SYMBOL_BOT = '0';
const BOARD_SIZE = 3;
$board = $data['board'];
$message = checkGameOverUser($board);
if ($message) {
    echo json_encode(array('message' => $message));
    exit();
}
$step = nextStep($board);
$step['symb'] = SYMBOL_BOT;

$board[$step['row']][$step['col']] = '0';
$message = checkGameOverBot($board);

echo json_encode(array('step' => $step, 'message' => $message));

function checkGameOverUser($board)
{
    $message = '';
    if (checkDiagonal($board, 'X') || checkLine($board, 'X')) {
        $message = 'Congratulations! You won the game!';
    }
    return $message;
}

function checkGameOverBot($board)
{
    $message = '';
    if (checkDiagonal($board, '0') || checkLine($board, '0')) {
        $message = 'You lost the game!';
    }
    return $message;
}

function nextStep($board)
{
    foreach ($board as $indexRow => $row) {
        foreach ($row as $indexColumn => $cell) {
            if ($cell === '') {
                if (checkLine($board, SYMBOL_BOT, $indexRow, $indexColumn)) {
                    return array(
                        'row' => $indexRow,
                        'col' => $indexColumn
                    );
                }
            }
        }
    }

    if ($board[1][1] === '') {
        return array(
            'row' => 1,
            'col' => 1
        );
    }
    for ($rowIndex = 0; $rowIndex < BOARD_SIZE - 1; $rowIndex += 2) {
        for ($colIndex = 0; $colIndex < BOARD_SIZE - 1; $colIndex += 2) {
            if ($board[$rowIndex][$colIndex] === '') {
                return array(
                    'row' => $rowIndex,
                    'col' => $colIndex
                );
                break;
            }
        }
    }
    foreach ($board as $indexRow => $row) {
        foreach ($row as $indexColumn => $cell) {
            if ($cell === '') {
                return array(
                    'row' => $indexRow,
                    'col' => $indexColumn
                );
                break;
            }
        }
    }
    return array();
}

function checkLine($board, $symb)
{
    for ($row = 0; $row < BOARD_SIZE; $row++) {
        $cols = true;
        $rows = true;
        for ($col = 0; $col < BOARD_SIZE; $col++) {
            $cols = $cols && ($board[$row][$col] === $symb);
            $rows = $rows && ($board[$col][$row] === $symb);
        }
        return $cols || $rows;
    }
    return false;
}

function checkDiagonal($board, $symb)
{
    $rightDiagonal = true;
    $leftDiagonal = true;
    for ($i = 0; $i < BOARD_SIZE; $i++) {
        $rightDiagonal = $rightDiagonal && ($board[$i][$i] === $symb);
        $leftDiagonal = $leftDiagonal && $board[BOARD_SIZE - $i - 1][$i] === $symb;
    }
    return $rightDiagonal || $leftDiagonal;
}
