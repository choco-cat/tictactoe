<?php
namespace classes;

class Controller
{
    public $view;

    function __construct()
    {
        $this->view = new View();
    }
}
