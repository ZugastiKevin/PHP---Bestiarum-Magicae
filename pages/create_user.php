<?php
    $title = 'Enregistrement dans les archives de l’Ordre';
    include('/var/www/html/codex/function/call_bdd.php');
    include('/var/www/html/codex/function/head.php');

    $requestSelectElement = $bdd->prepare(
        'SELECT id, name_element 
        FROM elements_type
    ');
    $requestSelectElement->execute(array());
    
    if (isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["elements"])) {
        $name = trim(htmlspecialchars($_POST["name"]));
        $encryption = password_hash(trim(htmlspecialchars($_POST["password"])), PASSWORD_ARGON2I);
        $elementIds = $_POST['elements'];

        $requestExistUser = $bdd->prepare(
            'SELECT user_name
            FROM users
            WHERE user_name = :user_name
        ');
        $requestExistUser->execute([
            'user_name' => $name,
        ]);
        $resultExist = $requestExistUser->fetch();

        if (!$resultExist) {
            $requestCreate = $bdd->prepare(
                'INSERT INTO users(user_name,user_role,pass) 
                VALUES (:user_name,:user_role,:pass)
            ');
            $requestCreate->execute([
                'user_name'=>$name,
                'user_role'=>0,
                'pass'=>$encryption
            ]);
            $requestSelectUser = $bdd->prepare(
                "SELECT id, user_name, user_role
                FROM users
                WHERE user_name = :user_name
            ");
            $requestSelectUser->execute(['user_name'=>$name]);
            $data = $requestSelectUser->fetch();
            $requestLinkMtM = $bdd->prepare(
                'INSERT INTO usersElements(user_id, element_type_id) 
                VALUES (:user_id, :element_type_id)
            ');
            foreach ($elementIds as $elementId) {
                $requestLinkMtM->execute([
                    'user_id' => $data['id'],
                    'element_type_id' => $elementId
                ]);
            }
            if (isset($_SESSION["currentUser"]['role']) === 100) {
                header('location:http://localhost:8080/codex/index.php');
            }
            setSession($data['id'], $data['user_name'], $elementIds, $data['user_role']);
            header('location:http://localhost:8080/codex/index.php');
        } else {
            echo $_SESSION['error']['exist'];
        }
    }
?>

<body>
    <?php include('/var/www/html/codex/layout/header.php'); ?>
    <main>
        <form action="create_user.php" method="post">
            <label for="name">Entrez votre nom vrai, tel qu’il sera inscrit dans les archives de l’Ordre.</label>
            <input type="text" name="name" required>
            <label for="password">Crée le sceau secret qui garde votre arcane personnelle.</label>
            <input type="password" name="password" required>
            <label for="elements">Choisissez la voie magique que vous maîtrisez parmi les arts mystiques ci-dessous.</label>
            <select name="elements[]" multiple required>
                <?php
                    while ($elements = $requestSelectElement->fetch()) {
                        echo '<option value="'.$elements['id'].'">'.$elements['name_element'].'</option>';
                    }
                ?>
            </select>
            <input type="submit" value="Rejoindre les archives de l’Ordre">
        </form>
    </main>
</body>