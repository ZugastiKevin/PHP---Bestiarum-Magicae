<?php
    include('./session.php');
    deleteToken($_SESSION['currentUser']['id']);