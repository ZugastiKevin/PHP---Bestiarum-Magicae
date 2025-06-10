<?php
    include('/var/www/html/codex/function/call_bdd.php');
    if ($_GET['all'] == 1) {
        $title = 'Bestiarums';
        $requestSelectBestiary = $bdd->prepare(
            'SELECT *
            FROM bestiary
            ORDER BY id DESC
        ');
        $requestSelectBestiary->execute([]);
    } else {
        $title = 'Magicaes';
        $requestSelectSpell = $bdd->prepare(
            'SELECT *
            FROM spells
            ORDER BY id DESC
        ');
        $requestSelectSpell->execute([]);
    }
    include('/var/www/html/codex/function/head.php');
?>

<body>
    <?php include('/var/www/html/codex/layout/header.php'); ?>
    <main id="readAll">
        <?php
            if (isset($_SESSION['currentUser'])) {
                echo '<div class="book-open">';
                    echo '<div class="book-open-container">';
                        echo '<div class="codex-container">';
                            echo '<div class="codex">';
                                echo '<div class="container-title">';
                                    echo '<h2>'.$title.'</h2>';
                                echo '</div>';
                                echo '<ul class="spacing">';
                                    if ($_GET['all'] == 1) {
                                        while ($bestiary = $requestSelectBestiary->fetch()) {
                                            echo '<li><a href="./read.php?type=creature&id='.$bestiary['id'].'">'.$bestiary['name_creature'].'</a></li>';
                                        }
                                    } else {
                                        while ($spell = $requestSelectSpell->fetch()) {
                                            echo '<li><a href="./read.php?type=spell&id='.$spell['id'].'">'.$spell['spell_name'].'</a></li>';
                                        }
                                    }
                                echo '</ul>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            } else {
                header('location:./../index.php');
            }
        ?>
    </main>
    <?php include('/var/www/html/codex/function/scripts.php'); ?>
</body>