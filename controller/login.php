<?php
namespace controller;

use model\LoginModel;
use classes\Controller;

/**
 * Index Controller
 */
class Login extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->set_filename('login');
        $template_data = array(
            'page_title' => 'Login Page'
        );
        $this->view->render($template_data);
    }

    public function sendData()
    {
        if (@$_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
            echo 'Page not work!';
        }
        //require('./model/login.php');
        $loginModel = new LoginModel();
        $user_data = $_POST;
        if ($user_data) {
            if ($loginModel->checkLogin($user_data)) {
                $this->auth($user_data);

            } else {
                echo json_encode($loginModel);
            }
            exit();
        }
    }

    public function auth($userData)
    {
        if (session_id() == "") {
            session_start();
        }
        $session_timeout = 600;
        $_SESSION['login'] = $userData['login'];
        $_SESSION['expires_by'] = time() + $session_timeout;
        $_SESSION['expires_timeout'] = $session_timeout;
        echo json_encode('success');
    }
    public function logout()
    {
        session_start();
        $_SESSION = [];
        Header('Location: ./../');
    }
}
