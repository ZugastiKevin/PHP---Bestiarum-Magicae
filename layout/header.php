<?php
    if ($title == 'Bestiarum Magicae') {
        $linkLogo = 'assets/img/logo/bestiarum-magicae.png';
        $linkBurger = 'assets/img/burger.png';
    } else {
        $linkLogo = './../assets/img/logo/bestiarum-magicae.png';
        $linkBurger = './../assets/img/burger.png';
    }
?>

<header>
    <nav id="container">
        <div class="logo-container">
            <a href="http://localhost:8080/codex/index.php"><img src="<?= $linkLogo ?>" alt="logo du site"></a>
        </div>
        <div class="nav-body">
            <?php
                if (isset($_SESSION["currentUser"])) {
                    echo '<div class="navigation-welcome">';
                        echo '<div class="welcome">';
                            echo '<h1>Bonjour, <span>' . $_SESSION["currentUser"]['name'] . '</span></h1>';
                        echo '</div>';
                        echo '<ul class="list-navigation">';
                            echo '<li class="li-logout"><a href="/codex/function/logout.php"><span class="logout">Se deconnecter</span></a></li>';
                        echo '</ul>';
                    echo '</div>';
                    echo '<div class="navigation-down">';
                        echo '<ul class="list-navigation">';
                            echo '<li><a href="/codex/pages/create_spell.php"><span class="spell">Ajouter un sort dans le codex</span></a></li>';
                            echo '<li><a href="/codex/pages/create_creature.php"><span class="bestiary">Ajouter un monstre dans le bestiaire</span></a></li>';
                        echo '</ul>';
                    echo '</div>';
                    echo '<div class="dropdown">';
                        echo '<div class="burger-container">';
                            echo '<img src="'.$linkBurger.'" alt="menu burger">';
                        echo '</div>';
                        echo '<ul class="dropdown-content">';
                            echo '<li><a href="/codex/pages/create_spell.php"><span>Ajouter un sort dans le codex</span></a></li>';
                            echo '<li><a href="/codex/pages/create_monster.php"><span>Ajouter un monstre dans le bestiaire</span></a></li>';
                            echo '<li><a href="/codex/function/logout.php"><span class="logout">Se deconnecter</span></a></li>';
                        echo '</ul>';
                    echo '</div>';
                } else {
                    echo '<ul class="list-navigation">';
                        echo '<li class="li-login"><a href="/codex/pages/login.php"><span class="login">Ouvrir un passage vers l’Ordre</span></a></li>';
                        echo '<li class="li-enrolement"><a href="/codex/pages/create_user.php"><span class="enrolement">Enrôlement</span></a></li>';
                    echo '</ul>';
                    echo '<div class="dropdown">';
                        echo '<div class="burger-container">';
                            echo '<img src="'.$linkBurger.'" alt="menu burger">';
                        echo '</div>';
                        echo '<ul class="dropdown-content">';
                            echo '<li class="li-login"><a href="/codex/pages/login.php"><span class="login">Ouvrir un passage vers l’Ordre</span></a></li>';
                            echo '<li class="li-enrolement"><a href="/codex/pages/create_user.php"><span class="enrolement">Enrôlement</span></a></li>';
                        echo '</ul>';
                    echo '</div>';
                }
            ?>
        </div>
    </nav>
</header>