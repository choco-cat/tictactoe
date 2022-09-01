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
    private $db;
    private $level = 1;
    private $message = '';
    public $step = array('symb' => self::SYMBOL_BOT);

    public function __construct($board)
    {
        $this->board = $board;
        $this->db = new Db(DATABASE_HOST, DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);
        $this->db->setFetchMode(PDO::FETCH_ASSOC);
        session_start();
    }

    private function setStep($rowIndex, $colIndex)
    {
        $this->step['row'] = $rowIndex;
        $this->step['col'] = $colIndex;
    }

    public function nextStep()
    {
        // Выиграть в один ход
        for ($rowIndex = 0; $rowIndex < self::BOARD_SIZE; $rowIndex++) {
            for ($colIndex = 0; $colIndex < self::BOARD_SIZE; $colIndex++) {
                if ($this->board[$rowIndex][$colIndex] === '') {
                    $cloneBoard = $this->board;
                    $cloneBoard[$rowIndex][$colIndex] = self::SYMBOL_BOT;
                    if ($this->checkLine(self::SYMBOL_BOT,  $cloneBoard)
                        || $this->checkDiagonal(self::SYMBOL_BOT,  $cloneBoard)) {
                        $this->setStep($rowIndex, $colIndex);
                        return $this->step;
                    }
                }
            }
        }
        // Помешать игроку выиграть в один ход
        for ($rowIndex = 0; $rowIndex < self::BOARD_SIZE; $rowIndex++) {
            for ($colIndex = 0; $colIndex < self::BOARD_SIZE; $colIndex++) {
                if ($this->board[$rowIndex][$colIndex] === '') {
                    $cloneBoard = $this->board;
                    $cloneBoard[$rowIndex][$colIndex] = self::SYMBOL_USER;
                    if ($this->checkLine(self::SYMBOL_USER,  $cloneBoard)
                        || $this->checkDiagonal(self::SYMBOL_USER,  $cloneBoard)) {
                        $this->setStep($rowIndex, $colIndex);
                        return $this->step;
                     }
                }
            }
        }
        if ($this->board[1][1] === '') {
            $this->step['row'] = 1;
            $this->step['col'] = 1;
            return $this->step;
        }
        for ($rowIndex = 0; $rowIndex < self::BOARD_SIZE - 1; $rowIndex += 2) {
            for ($colIndex = 0; $colIndex < self::BOARD_SIZE - 1; $colIndex += 2) {
                if ($this->board[$rowIndex][$colIndex] === '') {
                    $this->setStep($rowIndex, $colIndex);
                    return $this->step;
                }
            }
        }
        foreach ($this->board as $rowIndex => $row) {
            foreach ($row as $colIndex => $cell) {
                if ($cell === '') {
                    $this->setStep($rowIndex, $colIndex);
                    return $this->step;
                }
            }
        }
        return $this->step;
    }

    public function checkGameOverUser()
    {
        $this->message = '';
        if ($this->checkDiagonal(self::SYMBOL_USER, $this->board)
            || $this->checkLine(self::SYMBOL_USER, $this->board)) {
            $this->level = $this->updateUserLevel(1);
            $this->message = 'Поздравляю! Ты победил!!!';
        }
        return array('message' => $this->message, 'level' => $this->level);
    }

    public function checkGameOverBot()
    {
        if (!isset($this->step['row'])) {
            $this->message = 'Мы с тобой равных интеллектуальных возможностей.';
        } else {
            $this->board[$this->step['row']][$this->step['col']] = self::SYMBOL_BOT;
            $this->message = '';
            if ($this->checkDiagonal(self::SYMBOL_BOT, $this->board)
                || $this->checkLine(self::SYMBOL_BOT, $this->board)) {
                $this->level = $this->updateUserLevel(-1);
                $this->message = 'Ты проиграл :(';
            }
        }
        return array('message' => $this->message, 'level' => $this->level, 'step' => $this->step);
    }

    private function updateUserLevel($ball)
    {
        $login = $_SESSION['login'] ?? false;
        if ($login) {
           $this->db->fetch('UPDATE `users` SET level = level + '
               . $ball . ' WHERE login = "'. $login
               . '" AND level + ' . $ball . ' >= 1');
        }
        $level = $this->db->fetch('SELECT level FROM `users`  WHERE login = "' . $login . '"');
        return count($level) ? $level[0]['level'] : 1;
    }

    private function checkLine($symb, $board)
    {
        for ($col = 0; $col < self::BOARD_SIZE; $col++) {
            $cols = true;
            $rows = true;
            for ($row = 0; $row < self::BOARD_SIZE; $row++) {
                $cols = $cols && ($board[$col][$row] === $symb);
                $rows = $rows && ($board[$row][$col] === $symb);
            }
            if ($cols || $rows) return true;
        }
        return false;
    }

    private function checkDiagonal($symb, $board)
    {
        $rightDiagonal = true;
        $leftDiagonal = true;
        for ($i = 0; $i < self::BOARD_SIZE; $i++) {
            $rightDiagonal = $rightDiagonal && ($board[$i][$i] === $symb);
            $leftDiagonal = $leftDiagonal && $board[self::BOARD_SIZE - $i - 1][$i] === $symb;
        }
        return $rightDiagonal || $leftDiagonal;
    }
}
