<?php
namespace classes;
use PDO;

include('./../configDB.php');

class Gamer
{
    const BOARD_SIZE = 3;
    const SYMBOL_BOT = '0';
    const SYMBOL_USER = 'X';
    public $board = array();
    public $db;
    public $step = array('symb' => self::SYMBOL_BOT);
    public function __construct($board)
    {
        $this->board = $board;
        $this->db = new Db(DATABASE_HOST, DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);
        $this->db->setFetchMode(PDO::FETCH_ASSOC);
        session_start();
    }

    public function nextStep()
    {
        if ($this->board[1][1] === '') {
            $this->step['row'] = 1;
            $this->step['col'] = 1;
            return $this->step;
        }
        for ($rowIndex = 0; $rowIndex < self::BOARD_SIZE - 1; $rowIndex += 2) {
            for ($colIndex = 0; $colIndex < self::BOARD_SIZE - 1; $colIndex += 2) {
                if ($this->board[$rowIndex][$colIndex] === '') {
                    $this->step['row'] = $rowIndex;
                    $this->step['col'] = $colIndex;
                    return $this->step;
                }
            }
        }
        foreach ($this->board as $rowIndex => $row) {
            foreach ($row as $colIndex => $cell) {
                if ($cell === '') {
                    $this->step['row'] = $rowIndex;
                    $this->step['col'] = $colIndex;
                    return $this->step;
                }
            }
        }
        $this->step['row'] = '';
        $this->step['col'] = '';
        return $this->step;
    }

    public function checkGameOverUser()
    {
        $message = '';
        if ($this->checkDiagonal(self::SYMBOL_USER) || $this->checkLine(self::SYMBOL_USER)) {
            $this->updateUserLevel(1);
            $message = 'Поздравляем! Вы победили!!!';
        }
        return $message;
    }

    public function checkGameOverBot($step)
    {
        $this->board[$step['row']][$step['col']] = self::SYMBOL_BOT;
        $message = '';
        if ($this->checkDiagonal(self::SYMBOL_BOT) || $this->checkLine(self::SYMBOL_BOT)) {
            $this->updateUserLevel(-1);
            $message = 'Вы проиграли :(';
        }
        return $message;
    }

    private function updateUserLevel($ball)
    {
        $login = $_SESSION['login'] ?? false;
        if ($login) {
           $this->db->fetch('UPDATE `users` SET level = level + '
               . $ball . ' WHERE login = "'. $login
               . '" AND level + ' . $ball . ' >= 1');
        }
    }

    private function checkLine($symb)
    {
        for ($col = 0; $col < self::BOARD_SIZE; $col++) {
            $cols = true;
            $rows = true;
            for ($row = 0; $row < self::BOARD_SIZE; $row++) {
                $cols = $cols && ($this->board[$col][$row] === $symb);
                $rows = $rows && ($this->board[$row][$col] === $symb);
            }
            if ($cols || $rows) return true;
        }
        return false;
    }

    private function checkDiagonal($symb)
    {
        $rightDiagonal = true;
        $leftDiagonal = true;
        for ($i = 0; $i < self::BOARD_SIZE; $i++) {
            $rightDiagonal = $rightDiagonal && ($this->board[$i][$i] === $symb);
            $leftDiagonal = $leftDiagonal && $this->board[self::BOARD_SIZE - $i - 1][$i] === $symb;
        }
        return $rightDiagonal || $leftDiagonal;
    }
}
