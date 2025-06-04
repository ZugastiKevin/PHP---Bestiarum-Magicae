<?php
    
?>

<header>
    <nav id="container">
        <a href="http://localhost:8080/codex/index.php"><img src="./../assets/img/logo/bestiarum-magicae.png" alt="logo du site"></a>
        <?php
            if (isset($_SESSION["currentUser"])) {
                echo '<h1>Bonjour, ' . $_SESSION["currentUser"]['nom'] . '</h1>';
            }
        ?>
        <ul class="nav-list">
            <?php
                if (isset($_SESSION["currentUser"])) {
                    echo '<li><a href="/codex/page/create_spell.php">Ajouter un sort dans le codex</a></li>';
                    echo '<li><a href="/codex/page/create_monster.php">Ajouter un monstre dans le bestiaire</a></li>';
                    echo '<li><a href="/codex/function/logout.php">Se deconnecter</a></li>';
                } else {
                    echo '<li><a href="/codex/page/create_user.php">Cree un compte</a></li>';
                    echo '<li><a href="/codex/page/login.php">Se connecter</a></li>';
                }
            ?>
        </ul>
    </nav>
</header>