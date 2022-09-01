<?php

namespace controller;

use classes\Controller;
use model\RegistrationModel;

/**
 * Registration Controller
 */

class Registration extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->set_filename('registration');
        $template_data = array(
            'page_title' => 'Регистрация'
        );

        $this->view->render($template_data);
    }

    public function sendData()
    {
        if (@$_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {

            echo 'Страница недоступна!';
        }
        $registration_model = new RegistrationModel();
        $user_data = $_POST;
        if ($user_data) {
            if ($registration_model->checkUserData($user_data)) {
                $registration_model->addUserData($user_data);
            }
            echo json_encode($registration_model);
            exit();
        }
    }
}
