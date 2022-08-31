<?php
namespace controller;

use model\IndexModel;
use classes\Controller;

/**
 * Index Controller
 */
class Index extends Controller
{
    private $auth;

    function __construct()
    {
        parent::__construct();
        $this->auth = true;
    }

    public function index()
    {
        $this->startSession();
        $this->view->set_filename('index');
        $template_data = array(
            'page_title' => 'Игра',
        );
        if ($this->auth) {
            $indexModel = new IndexModel();
            $template_data += array(
                'auth' => $this->auth,
                'login' => $_SESSION['login'] ?? false,
                'level' => $indexModel->getUserLevel($_SESSION['login']),
            );
        }
        $this->view->render($template_data);
    }

    private function startSession()
    {
        if (session_id() == "") {
            session_start();
        }

        if (!isset($_SESSION['login'])) {
            $this->auth = false;
        }

        if (isset($_SESSION['expires_by'])) {
            $expires_by = intval($_SESSION['expires_by']);
            if (time() < $expires_by) {
                $_SESSION['expires_by'] = time() + intval($_SESSION['expires_timeout']);
            } else {
                unset($_SESSION['login']);
                unset($_SESSION['expires_by']);
                unset($_SESSION['expires_timeout']);
                $this->auth = false;
            }
        }
    }
}
