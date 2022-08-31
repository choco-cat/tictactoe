<?php
namespace model;
use classes\Model;

class RegistrationModel extends Model
{
    public function checkUserData($data)
    {
        $this->checkUserLogin($data['login']);
        $this->checkUserPassword($data['password'], $data['password_confirm']);
        return count($this->errors) === 0;
    }

    public function addUserData($data)
    {
        $salt = $data['login'];
        $hash = sha1($salt . $data['password'] );
        $data['password'] = $hash;
        $this->db->fetch('INSERT into `users` VALUES (null, "' . $data['login'] . '","' . $data['password'] . '", 1)');
    }

    private function checkUserLogin($login)
    {
        $user_data = $this->db->fetch('SELECT login FROM `users` WHERE login = "' . $login . '"');
        if (count($user_data) > 0) {
            $this->errors[] = 'Такой логин уже используется! ';
        }
        if (strlen($login) < 3) {
            $this->errors[] .= 'Длина логина должна быть не менее 3 символов';
        }
    }

    private function checkUserPassword($password, $passwordConfirm)
    {
        if ($password !== $passwordConfirm) {
            $this->errors[] .= 'Не совпадают поля Пароль и Подтверждение пароля. ';
        }
        if (strlen($password) < 3) {
            $this->errors[] .= 'Длина пароля должна быть не менее 3 символов';
        }
    }
}
