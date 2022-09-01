<?php
spl_autoload_register(function ($class_name) {
    include dirname(realpath(__FILE__)) . '/' . str_replace('\\', '/', $class_name) . '.php'; 
});
