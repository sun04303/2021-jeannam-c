<?php
    session_start();
    date_default_timezone_set('Asia/Seoul');
    define("ROOT", dirname(__DIR__));
    define("SRC", ROOT.'/src');
    define('VIEW', SRC."./View");

    require SRC.'/autoload.php';
    require SRC.'/helper.php';
    require SRC.'/web.php';