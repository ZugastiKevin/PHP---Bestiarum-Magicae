<?php
    include('/var/www/html/codex/function/session.php');
    if ($title == 'Bestiarum Magicae') {
        $linkStyle = 'assets/css/style.css';
    } else {
        $linkStyle = './../assets/css/style.css';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= $linkStyle ?>">
    <script src='/var/www/html/codex/assets/scripts/hover_nav.js'></script>
</head>
</html>