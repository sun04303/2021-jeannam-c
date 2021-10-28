<?php
    function view($page, $list = [], $list1 = []) {
        require VIEW."/header.php";
        require VIEW."/$page.php";
        require VIEW."/footer.php";
        exit;
    }

    function go($msg, $url) {
        echo "<script>";
        echo "alert('$msg');";
        echo "location.href = '{$url}';";
        echo "</script>";
        exit;
    }

    function back($msg) {
        echo "<script>";
        echo "alert('$msg');";
        echo "history.back()";
        echo "</script>";
        exit;
    }