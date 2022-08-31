<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* header.html */
class __TwigTemplate_33263e3ea4e172e4b96b2886c69799d7a5a8307b8df1dc951b4edeefcdcb5f98 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
<html>
<head>
    <link href=\"./assets/css/main.css\" rel=\"stylesheet\">
</head>
<body>
<nav>
    <ul>
        <li><a href=\"./\">Главная</a></li>
        ";
        // line 10
        if ( !($context["auth"] ?? null)) {
            // line 11
            echo "        <li><a href=\"./registration\">Регистрация</a></li>
        <li><a href=\"./login\">Авторизация</a></li>
        ";
        } else {
            // line 14
            echo "        <li><a href=\"./login/logout\">Выйти</a></li>
        ";
        }
        // line 16
        echo "    </ul>
</nav>
<main>
<h1>Игра крестики-нолики
</h1>";
    }

    public function getTemplateName()
    {
        return "header.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 16,  55 => 14,  50 => 11,  48 => 10,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "header.html", "C:\\OSPanel2\\domains\\tictactoe\\view\\header.html");
    }
}
