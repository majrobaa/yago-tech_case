<?php
include_once "config.php";
include_once "class/navigate.php";
session_start();

spl_autoload_register(function ($cname) {
    if (is_file(CLASSFOLDER . $cname . ".php")) {
        require_once CLASSFOLDER . $cname . ".php";
    } else {
        $cname = str_replace('\\', '/', $cname);
        if (is_file(CLASSFOLDER . $cname . ".php")) {
            require_once CLASSFOLDER . $cname . ".php";
        }
    }
});