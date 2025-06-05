<?php
    if ($title == 'Bestiarum Magicae') {
        $linkLogo = 'assets/img/logo/bestiarum-magicae.png';
    } else {
        $linkLogo = './../assets/img/logo/bestiarum-magicae.png';
    }
?>

<header>
    <nav id="container">
        <div class="logo-container">
            <a href="http://localhost:8080/codex/index.php"><img src="<?= $linkLogo ?>" alt="logo du site"></a>
        </div>
        <?php
            if (isset($_SESSION["currentUser"])) {
                echo '<h1>Bonjour, ' . $_SESSION["currentUser"]['name'] . '</h1>';
            }
        ?>
        <ul class="nav-list">
            <?php
                if (isset($_SESSION["currentUser"])) {
                    echo '<li><a href="/codex/pages/create_spell.php">Ajouter un sort dans le codex</a></li>';
                    echo '<li><a href="/codex/pages/create_monster.php">Ajouter un monstre dans le bestiaire</a></li>';
                    echo '<li><a href="/codex/function/logout.php">Se deconnecter</a></li>';
                } else {
                    echo '<li><a href="/codex/pages/create_user.php">Cree un compte</a></li>';
                    echo '<li><a href="/codex/pages/login.php">Se connecter</a></li>';
                }
            ?>
        </ul>
    </nav>
</header>