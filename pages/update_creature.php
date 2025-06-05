<?php
    $title = 'Bestiarum.';
    include('/var/www/html/codex/function/call_bdd.php');
    include('/var/www/html/codex/function/head.php');

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET["id"]);
        $requestSelectCreatureById = $bdd->prepare(
            "SELECT one.id AS id, one.user_id AS user_id, one.bestiary_type_id AS bestiary_type_id, one.name_creature AS name_creature, one.describ_creature AS describ_creature, one.img_creature AS img_creature, e.id AS creature_id, e.type_name AS type_name
            FROM bestiary one
            JOIN bestiary_type e ON one.bestiary_type_id = e.id
            WHERE id = :id
        ");
        $requestSelectCreatureById->execute(['id'=>$id]);
        $data = $requestSelectCreatureById->fetch();
        if (isset($_SESSION["currentUser"]['id']) == $data['user_id'] || isset($_SESSION["currentUser"]['role']) == 100) {
            if (isset($_POST['name_creature']) && isset($_POST['describe_creature']) && isset($_POST['type_creature']) && isset($_FILES['creatureFile'])) {
                $requestSelectCreatureAll = $bdd->prepare(
                    "SELECT one.name_creature AS name_creature, e.id AS id, e.type_name AS type_name
                    FROM bestiary one
                    JOIN bestiarys_type e ON one.bestiary_type_id = e.id
                ");
                $requestSelectCreatureAll->execute();
                $resultExist = false;
                while ($comparing = $requestSelectCreatureAll->fetch()) {
                    if ($comparing['name_creature'] == $data['name_creature']) {
                        $resultExist = true;
                        break;
                    }
                }
                if (!$resultExist) {    
                    $nameCreature = trim(htmlspecialchars($_POST["name_creature"]));
                    $describeCreature = trim(htmlspecialchars($_POST["describe_creature"]));
                    $typeCreature = trim(htmlspecialchars($_POST['type_creature']));
                    $imgCreature = $_FILES['creatureFile'];
                    $getExtension = strtolower(pathinfo($imgCreature["name"], PATHINFO_EXTENSION));
                    $extensionType = ['png','jpeg','jpg','webp','bmp','svg'];
                    
                    switch ($_FILES["spellFile"]['error']) {
                        case 4:
                            $requestUpdateCreature = $bdd->prepare(
                                'UPDATE bestiary
                                SET (:id,:user_id,:bestiary_type_id,:name_creature,:describ_creature,:img_creature)
                                WHERE id = :id
                            ');
                            $requestUpdateCreature->execute([
                                'id'=>$id,
                                'user_id'=>$data['user_id'],
                                'bestiary_type_id'=>$typeCreature,
                                'name_creature'=>$nameCreature,
                                'describ_creature'=> $describeCreature,
                                'img_creature'=>$imgCreature
                            ]);
                            header('location:http://localhost:8080/codex/index.php');
                            break;
                        case  0:
                            if(!in_array($getExtension, $extensionType)){
                                echo "Votre croquis de creature ne correspont pas : ".$getExtension." au format valide du bestiarum: png, jpeg, jpg, webp, bmp, svg</p>";
                            } else {
                                $uniqueName = uniqid().'.'.$getExtension;
                                $requestSelectTypeForDefault = $bdd->prepare(
                                    'SELECT type_name 
                                    FROM bestiary_type
                                    WHERE id = :id
                                ');
                                $requestSelectTypeForDefault->execute(['id'=>$typeCreature]);
                                $creature = $requestSelectTypeForDefault->fetch();
                                $defaultSpellPath = '"./../assets/img/creatures/'.$creature['type_name'].'/"'.$uniqueName;
                                move_uploaded_file($_FILES['spellFile']['tmp_name'], $defaultSpellPath);
                                while ($comparing = $requestSelectCreatureAll->fetch()) {
                                    if ($data['img_creature'] != 'default_creature_'.$comparing['type_name'].'.jpg') {
                                        unlink('./../assets/img/creatures/'.$data['type_name'].'/'.$data['img_spell']);
                                    }
                                }
                                $requestUpdateCreature = $bdd->prepare(
                                    'UPDATE bestiary
                                    SET (:id,:user_id,:bestiary_type_id,:name_creature,:describ_creature,:img_creature)
                                    WHERE id = :id
                                ');
                                $requestUpdateCreature->execute([
                                    'id'=>$id,
                                    'user_id'=>$data['user_id'],
                                    'bestiary_type_id'=>$typeCreature,
                                    'name_creature'=>$nameCreature,
                                    'describ_creature'=> $describeCreature,
                                    'img_creature'=>$imgCreature
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
    }
?>

<body>
    <?php include('/var/www/html/codex/layout/header.php'); ?>
    <main>
        <?php echo '<form class="form-content" action="update_creature.php?id='.$id.'" method="post" enctype="multipart/form-data">'; ?>
            <label for="name_creature">Corrigez ou confirmez le nom de la créature, tel qu’il demeure gravé dans les archives :</label>
            <input type="text" name="name_creature" value="<?= $data['name_creature'] ?>" required>
            <label for="describe_creature">Révisez ou enrichissez sa description pour refléter fidèlement sa nature et les récits qui l’entourent :</label>
            <textarea name="describe_creature" rows="6" value="<?= $data['describ_creature'] ?>" required></textarea>
            <label for="type_creature">La classification mystique à laquelle cette entité est rattachée : <?= $data['describ_creature'] ?> Modifiez, si besoin :</label>
            <select name="type_creature" required>
                <?php
                    while ($bestiarysType = $requestSelectCreatureAll->fetch()) {
                        echo '<option value="'.$bestiarysType['id'].'">'.$bestiarysType['type_name'].'</option>';
                    }
                ?>
            </select>
            <div>
                <p>Croquis actuelle de la creature :</p>
                <div>
                    <img src="<?= './../assets/img/creatures/'.$data['type_name'].'/'.$data['img_creature'] ?>" alt="image de la creature">
                </div>
            </div>
            <label for="creatureFile">Vous pouvez remplacer son croquis si une nouvelle représentation a été découverte :</label>
            <input type="file" name="creatureFile">
            <input type="submit" value="Mettre à jour les connaissances mystiques">
        </form>
    </main>
</body>