<?php

namespace classes;

class Gamer
{
    const BOARD_SIZE = 3;
    public $board = array();

    public function __construct($board)
    {
        $this->board = $board;
    }

    public function nextStep()
    {
        foreach ($this->board as $indexRow => $row) {
            foreach ($row as $indexColumn => $cell) {
                if ($cell === '') {
                    if ($this->checkLine($this->board, SYMBOL_BOT, $indexRow, $indexColumn)) {
                        return array(
                            'row' => $indexRow,
                            'col' => $indexColumn
                        );
                    }
                }
            }
        }

        if ($this->board[1][1] === '') {
            return array(
                'row' => 1,
                'col' => 1
            );
        }
        for ($rowIndex = 0; $rowIndex < self::BOARD_SIZE - 1; $rowIndex += 2) {
            for ($colIndex = 0; $colIndex < self::BOARD_SIZE - 1; $colIndex += 2) {
                if ($this->board[$rowIndex][$colIndex] === '') {
                    return array(
                        'row' => $rowIndex,
                        'col' => $colIndex
                    );
                    break;
                }
            }
        }
        foreach ($this->board as $indexRow => $row) {
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
        return array(
            'row' =>'',
            'col' => ''
        );
    }

    public function checkGameOverUser()
    {
        $message = '';
        if ($this->checkDiagonal('X') || $this->checkLine('X')) {
            $message = 'Congratulations! You won the game!';
        }
        return $message;
    }

    public function checkGameOverBot($step)
    {
        $this->board[$step['row']][$step['col']] = '0';
        $message = '';
        if ($this->checkDiagonal('0') || $this->checkLine('0')) {
            $message = 'You lost the game!';
        }
        return $message;
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
