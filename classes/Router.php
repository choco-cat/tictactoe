<?php
namespace classes;
use controller\Index;
use controller\Login;
use controller\Registration;

class Router
{
    function __construct()
    {
        $url = $_GET['url'] ?? 'index';
        $url = rtrim($url, '/');
        $urlParts = explode('/', $url);
        $baseUrl = $urlParts[0];
        $params = $urlParts[1] ?? null;

        switch ($baseUrl) {
            case 'login':
                $controller = new Login();
                break;
            case 'registration':
                $controller = new Registration();
                break;
            case 'index':
            default:
                $controller = new Index();
                break;
        }

        switch ($params) {
            case null:
                $controller->index();
                break;
            case 'send':
                $controller->sendData();
                break;
            case 'logout':
                $controller->logout();
                break;
        }
    }
}
