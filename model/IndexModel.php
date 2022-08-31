<?php
namespace model;
use classes\Model;

class IndexModel extends Model
{
    public function getUserLevel($login)
    {
        $userRow = $this->db->fetch('SELECT level FROM `users` WHERE login="' . $login . '"');
        if (!count($userRow)) {
            return false;
        }
        return $userRow[0]['level'];
    }
}
