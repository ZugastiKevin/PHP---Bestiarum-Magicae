<?php
    $title = 'Bestiarum Magicae';
    include('./function/head.php');
    include('/var/www/html/codex/function/call_bdd.php');

    $requestSelectSpell = $bdd->prepare(
        'SELECT *
        FROM spells
        ORDER BY id DESC
        LIMIT 6
    ');
    $requestSelectSpell->execute([]);

    $requestSelectBestiary = $bdd->prepare(
        'SELECT *
        FROM bestiary
        ORDER BY id DESC
        LIMIT 6
    ');
    $requestSelectBestiary->execute([]);
?>

<body>
    <?php include('./layout/header.php'); ?>
    <main>
        <?php
            if (isset($_SESSION['currentUser'])) {
                echo '<div class="book-open">';
                    echo '<div class="book-open-container">';
                        echo '<div class="codex-container">';
                            echo '<div class="codex">';
                                echo '<div class="codex-spell">';
                                    echo '<ul>';
                                        while ($spell = $requestSelectSpell->fetch()) {
                                            echo '<li><a href="./read_all.php?id='.$spell['id'].'">'.$spell['spell_name'].'</a></li>';
                                        }
                                    echo '</ul>';
                                echo '</div>';
                                echo '<div class="codex-cta">';
                                    echo '<a href="./pages/codexs.php">Invoquez le codex Magicae</a>';
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="codex">';
                                echo '<div class="codex-bestiary">';
                                    echo '<ul>';
                                        while ($bestiary = $requestSelectBestiary->fetch()) {
                                            echo '<li><a href="./read_all.php?id='.$bestiary['id'].'">'.$bestiary['name_creature'].'</a></li>';
                                        }
                                    echo '</ul>';
                                echo '</div>';
                                echo '<div class="codex-cta">';
                                    echo '<a href="./pages/bestiarums.php">Invoquez le codex Bestiarum</a>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="book-close">';
                    echo '<div class="book-close-container">';
                        echo '<img src="./assets/img/book-closed.png" alt="un livre fermer">';
                        echo '<p class="reveal"></p>';
                    echo '</div>';
                echo '</div>';
            }
        ?>
    </main>
    <?php include('/var/www/html/codex/function/scripts.php'); ?>
</body>