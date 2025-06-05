<?php
    $title = 'Magicae.';
    include('/var/www/html/codex/function/call_bdd.php');
    include('/var/www/html/codex/function/head.php');

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET["id"]);
        $requestSelectSpell = $bdd->prepare(
            "SELECT element_type_id, spell_name, img_spell
            FROM spells
            WHERE id = :id
        ");
        $requestSelectSpell->execute(['id'=>$id]);
        $data = $requestSelectSpell->fetch();
        if (isset($_SESSION["currentUser"])) {
            $requestSelectElement = $bdd->prepare(
                'SELECT e.id AS id, e.name_element AS name_element
                FROM usersElements one
                JOIN elements_type e ON one.element_type_id = e.id
                WHERE user_id = :user_id
            ');
            $requestSelectElement->execute(['user_id'=>$_SESSION["currentUser"]['id']]);
            $resultExist = false;
            foreach ($_SESSION["currentUser"]['elements'] as $element) {
                if ($element['id'] == $data['element_type_id']) {
                    $resultExist = true;
                    break;
                }
            }
            if ($resultExist) {
                if (isset($_POST['name_spell']) && isset($_FILES['spellFile']) && isset($_POST['elements'])) {
                    $nameSpell = htmlspecialchars($_POST['name_spell']);
                    $imgspell = $_FILES['spellFile'];
                    $elementId = $_POST['elements'];
                    $getExtension = strtolower(pathinfo($imgspell["name"], PATHINFO_EXTENSION));
                    $extensionType = ['png','jpeg','jpg','webp','bmp','svg'];
                    
                    switch ($_FILES["spellFile"]['error']) {
                        case 4:
                            $requestUpdateSpell = $bdd->prepare(
                                'UPDATE spells
                                SET (:spell_name,:img_spell,:element_type_id)
                                WHERE id = :id
                            ');
                            $requestUpdateSpell->execute([
                                'id'=>$id,
                                'spell_name'=>$nameSpell,
                                'img_spell'=> $data['spell_name'],
                                'element_type_id'=>$elementId
                            ]);
                            header('location:http://localhost:8080/codex/index.php');
                            break;
                        case  0:
                            if(!in_array($getExtension, $extensionType)){
                                echo "Votre croquis de magicae ne correspont pas : ".$getExtension." au format valide du grimoir: png, jpeg, jpg, webp, bmp, svg</p>";
                            } else {
                                $uniqueName = uniqid().'.'.$getExtension;
                                $requestSelectTypeForDefault = $bdd->prepare(
                                    'SELECT name_element 
                                    FROM elements_type
                                    WHERE id = :id
                                ');
                                $requestSelectTypeForDefault->execute(['id'=>$elementId]);
                                $element = $requestSelectTypeForDefault->fetch();
                                $defaultSpellPath = '"./../assets/img/sorts/'.$element['name_element'].'/"'.$uniqueName;
                                move_uploaded_file($_FILES['spellFile']['tmp_name'], $defaultSpellPath);
                                if ($data['img_spell'] != 'default_spell_light.jpg' OR 'default_spell_water.jpg' OR 'default_spell_wind.jpg' OR 'default_spell_fire.jpg') {
                                    unlink('./../assets/img/sorts/'.$element['name_element'].'/'.$data['img_spell']);
                                }
                                $requestUpdateSpell = $bdd->prepare(
                                    'UPDATE spells
                                    SET (:spell_name,:img_spell,:element_type_id)
                                    WHERE id = :id
                                ');
                                $requestUpdateSpell->execute([
                                    'id'=>$id,
                                    'spell_name'=>$nameSpell,
                                    'img_spell'=> $uniqueName,
                                    'element_type_id'=>$elementId
                                ]);
                                header('location:http://localhost:8080/codex/index.php');
                            }
                            break;
                    }
                }
            } else {
                echo $_SESSION['error']['exist'];
            }
        } else {
            header('location:http://localhost:8080/codex/index.php');
        }
    }
?>

<body>
    <?php include('/var/www/html/codex/layout/header.php'); ?>
    <main>
        <section>
            <div class="container">
                <div class="cards-container">
                    <h2>M'odification de votre magicae :</h2>
                    <?php echo '<form class="form-content" action="update_spell.php?id='.$id.'" method="post" enctype="multipart/form-data">'; ?>
                        <label for="name_spell">Nom de votre magicae :</label>
                        <input type="text" name="name_spell" value="<?= $data['spell_name'] ?>" required>
                        <div>
                            <p>Croquis actuelle de votre magicae :</p>
                            <div>
                                <img src="<?php 
                                    foreach ($_SESSION["currentUser"]['elements'] as $elements) {
                                        if ($elements['id'] == $data['element_type_id']) {
                                            echo './../assets/img/sorts/'.$elements['name_element'].'/'.$data['img_spell'];
                                        }  
                                    }
                                ?>" alt="image du sort">
                            </div>
                            <label for="spellFile">Nouveau croquis de votre magicae :</label>
                            <input type="file" name="spellFile">
                        </div>
                        <label for="elements">Voie actuelle de votre magicae : <?php 
                            foreach ($_SESSION["currentUser"]['elements'] as $elements) {
                                if ($elements['id'] == $data['element_type_id']) {
                                    echo $elements['name_element'];
                                }  
                            } ?>, Choisissez la nouvelle voie de votre magicae.
                        </label>
                        <select name="elements" required>
                            <?php
                                if ($_SESSION["currentUser"]['role'] == 100) {
                                    while ($elements = $requestSelectElement->fetch()) {
                                        echo '<option value="'.$elements['id'].'">'.$elements['name_element'].'</option>';
                                    }
                                } else {
                                    foreach ($_SESSION["currentUser"]['elements'] as $elements) {
                                        echo '<option value="'.$elements['id'].'">'.$elements['name_element'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                        <input type="submit" value="Rajoutée ma magicae au grimoire">
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>