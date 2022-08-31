<?php
namespace classes;
/**
 * Main View Loader
 */
class View
{
    public $twig;
    public $template;

    function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader(VIEW_PATH);
        $this->twig = new \Twig\Environment($loader, [
            'cache' => './cache',
        ]);
    }

    public function set_filename($template) {
        $this->template = $this->twig->load($template . '.html');
    }

    public function render($args = []) {
        print $this->template->render($args);
    }
}
