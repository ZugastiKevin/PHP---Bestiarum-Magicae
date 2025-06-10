<?php
    include('/var/www/html/codex/function/call_bdd.php');
    if ($_GET['type'] == 'creature') {
        $idCreature = htmlspecialchars($_GET['id']);
        $requestSelectBestiary = $bdd->prepare(
            'SELECT one.user_id AS user_id, one.name_creature AS name_creature, one.describ_creature AS describ_creature, one,img_creature AS img_creature, e.type_name AS type_name
            FROM bestiary one
            JOIN bestiary_type e ON one.bestiary_type_id = e.id
            WHERE id = :id
        ');
        $requestSelectBestiary->execute(['id'=>(int)$idCreature]);
        $data = $requestSelectBestiary->fetch();
        $title = $data['name_creature'];
        $defaultSpellPath = './../assets/img/creatures/'.$data['type_name'].'/'.$data['img_creature'];
    } else {
        $idSpell = htmlspecialchars($_GET['id']);
        $title = 'Magicaes';
        $requestSelectSpell = $bdd->prepare(
            'SELECT one.spell_name AS spell_name, one.img_spell AS img_spell, e.name_element AS name_element
            FROM spells one
            JOIN elements_type e ON one.element_type_id = e.id
            WHERE id = :id
        ');
        $requestSelectSpell->execute(['id'=>(int)$idSpell]);
        $data = $requestSelectSpell->fetch();
        $title = $data['spell_name'];
        $defaultSpellPath = './../assets/img/sorts/'.$data['name_element'].'/'.$data['img_spell'];
    }
    include('/var/www/html/codex/function/head.php');
?>

<body>
    <?php include('/var/www/html/codex/layout/header.php'); ?>
    <main id="read">
        <?php
            if (isset($_SESSION['currentUser'])) {
                echo '<div class="book-open">';
                    echo '<div class="book-open-container">';
                        echo '<div class="codex-container">';
                            echo '<div class="codex">';
                                echo '<div class="container-title">';
                                    if ($_GET['type'] == 'creature') {
                                        echo '<h2>'.$data['name_creature'].'</h2>';
                                    } else {
                                        echo '<h2>'.$data['spell_name'].'</h2>';
                                    }
                                echo '</div>';
                                echo '<ul class="spacing">';
                                    if ($_GET['type'] == 'creature') {
                                        echo '<img href="'.$defaultSpellPath.'" alt="Une image de sort">';
                                    } else {
                                        echo '<img href="'.$defaultSpellPath.'" alt="Une image de sort">';
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