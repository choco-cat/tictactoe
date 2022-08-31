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

/* registration.html */
class __TwigTemplate_eb7d7f6d51a09445954f362b8cc92de9948a8c3f340c658215dc1b862c951588 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'main' => [$this, 'block_main'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        $this->loadTemplate("header.html", "registration.html", 1)->display($context);
        // line 2
        $this->displayBlock('main', $context, $blocks);
        // line 24
        $this->loadTemplate("footer.html", "registration.html", 24)->display($context);
    }

    // line 2
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "<p>Registration Page</p>
<form id=\"registration-form\" method=\"post\">
    <label>
        Login:
        <input type=\"text\" name=\"login\" id=\"login\">
        ";
        // line 8
        if ((($__internal_compile_0 = ($context["errors"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0["login"] ?? null) : null)) {
            // line 9
            echo "        ";
            echo twig_escape_filter($this->env, (($__internal_compile_1 = ($context["errors"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1["login"] ?? null) : null), "html", null, true);
            echo "
        ";
        }
        // line 11
        echo "    </label>
    <label>
        Password:
        <input type=\"password\" name=\"password\" id=\"password\">
    </label>
    <label>
        Confirm password:
        <input type=\"password\" name=\"password_confirm\">
    </label>
    <input type=\"button\" id=\"submit\" value=\"send\">
</form>

";
    }

    public function getTemplateName()
    {
        return "registration.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 11,  59 => 9,  57 => 8,  50 => 3,  46 => 2,  42 => 24,  40 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "registration.html", "C:\\OSPanel2\\domains\\tictactoe\\view\\registration.html");
    }
}
