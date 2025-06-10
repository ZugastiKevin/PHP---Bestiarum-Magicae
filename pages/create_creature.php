<?php
    $title = 'Bestiarum.';
    include('/var/www/html/codex/function/call_bdd.php');
    include('/var/www/html/codex/function/head.php');
    
    if (isset($_SESSION["currentUser"])) {
        $requestSelectbestiarysType = $bdd->prepare(
            'SELECT *
            FROM bestiary_type
        ');
        $requestSelectbestiarysType->execute([]);
        if (isset($_POST['name_creature']) && isset($_POST['describe_creature']) && isset($_POST['type_creature']) && isset($_FILES['creatureFile'])) {
            $nameCreature = trim(strtolower(htmlspecialchars($_POST["name_creature"])));
            $describeCreature = trim(strtolower(htmlspecialchars($_POST["describe_creature"])));
            $typeCreature = htmlspecialchars($_POST['type_creature']);
            $imgCreature = $_FILES['creatureFile'];
            $getExtension = strtolower(pathinfo($imgCreature["name"], PATHINFO_EXTENSION));
            $extensionType = ['png','jpeg','jpg','webp','bmp','svg'];

            $requestExistCreature = $bdd->prepare(
                'SELECT name_creature
                FROM bestiary
                WHERE name_creature = :name_creature
            ');
            $requestExistCreature->execute([
                'name_creature' => $nameCreature,
            ]);
            $resultExist = $requestExistCreature->fetch();

            $requestSelectTypeForDefault = $bdd->prepare(
                'SELECT type_name 
                FROM bestiary_type
                WHERE id = :id
            ');
            $requestSelectTypeForDefault->execute(['id'=>$typeCreature]);
            $creature = $requestSelectTypeForDefault->fetch();

            if (!$resultExist) {
                switch ($_FILES["creatureFile"]['error']) {
                    case 4:
                        $defaultCreature = 'default_creature_'.$creature['type_name'].'.jpg';
                        $requestCreate = $bdd->prepare(
                            'INSERT INTO bestiary(user_id,bestiary_type_id,name_creature,describ_creature,img_creature) 
                            VALUES (:user_id,:bestiary_type_id,:name_creature,:describ_creature,:img_creature)
                        ');
                        $requestCreate->execute([
                            'user_id'=>$_SESSION["currentUser"]['id'],
                            'bestiary_type_id'=>$typeCreature,
                            'name_creature'=>$nameCreature,
                            'describe_creature'=> $describeCreature,
                            'img_creature'=>$defaultCreature
                        ]);
                        header('location:http://localhost:8080/codex/index.php');
                        break;
                    case  0:
                        if(!in_array($getExtension, $extensionType)){
                            echo "Votre croquis de creature ne correspont pas : ".$getExtension." au format valide du bestiarum: png, jpeg, jpg, webp, bmp, svg</p>";
                        } else {
                            $uniqueName = uniqid().'.'.$getExtension;
                            $defaultCreaturePath = './../assets/img/creatures/'.$creature['type_name'].'/'.$uniqueName;
                            move_uploaded_file($_FILES['creatureFile']['tmp_name'], $defaultCreaturePath);
                            $requestUpdateCreature = $bdd->prepare(
                                'INSERT INTO bestiary(user_id,bestiary_type_id,name_creature,describ_creature,img_creature) 
                                VALUES (:user_id,:bestiary_type_id,:name_creature,:describ_creature,:img_creature)
                            ');
                            $requestUpdateCreature->execute([
                                'user_id'=>$_SESSION["currentUser"]['id'],
                                'bestiary_type_id'=>$typeCreature,
                                'name_creature'=>$nameCreature,
                                'describ_creature'=> $describeCreature,
                                'img_creature'=>$uniqueName
                            ]);
                            header('location:http://localhost:8080/codex/index.php');
                        }
                        break;
                }
            } else {
                echo $_SESSION['error']['exist'];
            }
        }
    } else {
        header('location:http://localhost:8080/codex/index.php');
    }
?>

<body>
    <?php include('/var/www/html/codex/layout/header.php'); ?>
    <main>
        <div class="parchemin logged-parchemin">
            <div class="container-title">
                <h2><?= $title ?></h2>
            </div>
            <form class="form" action="create_creature.php" method="post" enctype="multipart/form-data">
                <label for="name_creature">Inscrivez le nom de la créature, tel qu’il résonne dans les murmures anciens :</label>
                <input type="text" name="name_creature" required>
                <label for="describe_creature">Décrivez son essence, ses formes et les mythes qui l’entourent, afin qu’elle soit consignée dans les archives de l’Ordre :</label>
                <textarea name="describe_creature" rows="6" required></textarea>
                <div class="file">
                    <label for="creatureFile">Croquis de la creature :</label>
                    <input type="file" name="creatureFile">
                </div>
                <div class="select">
                    <label for="type_creature">Choisissez la classification ésotérique à laquelle cette entité appartient :</label>
                    <select name="type_creature" required>
                        <?php
                            while ($bestiarysType = $requestSelectbestiarysType->fetch()) {
                                echo '<option value="'.$bestiarysType['id'].'">'.$bestiarysType['type_name'].'</option>';
                            }
                        ?>
                    </select>
                </div>
                <input type="submit" value="Consigner cette entité mystique">
            </form>
        </div>
    </main>
    <?php include('/var/www/html/codex/function/scripts.php'); ?>
</body>