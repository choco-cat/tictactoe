<?php
namespace model;
use classes\Model;

class LoginModel extends Model
{
    public function checkLogin($data)
    {
        $userRow = $this->db->fetch('SELECT login, password FROM `users` WHERE login="' . $data['login'] . '"');
        if (!count($userRow)) {
            $this->errors['login'] = 'Логин не существует!';
            return false;
        }
        $salt = $data['login'];
        $hash = sha1($salt . $data['password']);
        if ($hash !== $userRow[0]['password']) {
            $this->errors[] = 'Неверный пароль!';
            return false;
        }
        return true;
    }
}
