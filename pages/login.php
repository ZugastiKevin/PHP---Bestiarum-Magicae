<?php
    $title = 'Frappez, et l’Ordre jugera si vous êtes digne.';
    include('/var/www/html/codex/function/call_bdd.php');
    include('/var/www/html/codex/function/head.php');

    if (!empty($_POST['name']) && !empty($_POST['password'])) {
        $name = trim(htmlspecialchars($_POST["name"]));
        $requestPrepareUser = $bdd->prepare(
            "SELECT id, user_name, pass, user_role
            FROM users
            WHERE user_name = :user_name
        ");
        $requestPrepareUser->execute(['user_name'=>$name]);
        $data = $requestPrepareUser->fetch();
        $encryption = trim(htmlspecialchars($_POST["password"]));
        if (password_verify($encryption, $data['pass'])) {
            if (isset($_POST['remember-me']) == true) {
                createSessionUserWithRemember($data['id'], $data['user_name'], $data['user_role']);
                header("location:http://localhost:8080/codex/index.php");
            } else {
                setSession($data['id'], $data['user_name'], $data['user_role']);
                header("location:http://localhost:8080/codex/index.php");
            }
        } else {
            header("location:http://localhost:8080/codex/pages/login.php?error=3");
        }
    }
    if (isset($_GET["error"])) {
        if ($_GET["error"] == 3) {
            echo "Pseudo or Password incorrect";
        }
    }
?>

<body>
    <?php include('/var/www/html/codex/layout/header.php'); ?>
    <main>
        <div class="parchemin">
            <div class="container-title">
                <h2><?= $title ?></h2>
            </div>
            <form class="form" action="login.php" method="post">
                <label for="name">Inscris ton nom tel qu’il fut gravé dans les archives de l’Ordre :</label>
                <input type="text" name="name" required>
                <label for="password">Murmure le sceau secret qui te lie à l’Ordre :</label>
                <input type="password" name="password" required>
                <label for="remember-me">
                    Que le grimoire te reconnaisse lors de ton prochain passage ?
                    <input type="checkbox" name="remember-me" value="true">
                </label>
                <input type="submit" value="Accéder aux Arcanes">
            </form>
        </div>
    </main>
    <?php include('/var/www/html/codex/function/scripts.php'); ?>
</body>