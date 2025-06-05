<?php
    ob_start();
    session_start();
    if (isset($_SESSION['currentUser'])) {
        include('./session.php');
        include('/var/www/html/codex/function/call_bdd.php');
        deleteToken($_SESSION['currentUser']['id'], $bdd);
    } else {
        header('location:http://localhost:8080/codex/index.php');
    }