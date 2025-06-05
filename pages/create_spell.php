<?php
    $title = 'Magicae.';
    include('/var/www/html/codex/function/call_bdd.php');
    include('/var/www/html/codex/function/head.php');

    if (isset($_SESSION["currentUser"])) {
        $requestSelectElement = $bdd->prepare(
            'SELECT id, name_element 
            FROM elements_type
        ');
        $requestSelectElement->execute(array());
        if (isset($_POST['name_spell']) && isset($_FILES['spellFile']) && isset($_POST['elements'])) {
            $nameSpell = htmlspecialchars($_POST['name_spell']);
            $imgspell = $_FILES['spellFile'];
            $elementIds = $_POST['elements'];
            $getExtension = strtolower(pathinfo($imgspell["name"], PATHINFO_EXTENSION));
            $extensionType = ['png','jpeg','jpg','webp','bmp','svg'];
            
            $requestSelectElementForDefault = $bdd->prepare(
                'SELECT name_element 
                FROM elements_type
                WHERE id = :id
            ');
            $requestSelectElementForDefault->execute(['id'=>$elementIds[0]]);
            $element = $requestSelectElementForDefault->fetch();
            switch ($_FILES["spellFile"]['error']) {
                case 4:
                    $defaultSpell = 'default_spell_' . $element['name_element'] . '.jpg';
                    $requestCreateSpell = $bdd->prepare(
                        'INSERT INTO spells(spell_name,img_spell,element_type_id) 
                        VALUES (:spell_name,:img_spell,:element_type_id)
                    ');
                    $requestCreateSpell->execute([
                        'spell_name'=>$nameSpell,
                        'img_spell'=> $defaultSpell,
                        'element_type_id'=>$elementIds[0]
                    ]);
                    header('location:http://localhost:8080/codex/index.php');
                    break;
                case  0:
                    if(!in_array($getExtension, $extensionType)){
                        echo "Votre croquis de magicae ne correspont pas : ".$getExtension." au format valide du grimoir: png, jpeg, jpg, webp, bmp, svg</p>";
                    } else {
                        $uniqueName = uniqid().'.'.$getExtension;
                        $defaultSpellPath = '"./../assets/img/sorts/'.$element['name_element'].'/"'.$uniqueName;
                        move_uploaded_file($_FILES['spellFile']['tmp_name'], $defaultSpellPath);
                        $requestCreateSpell = $bdd->prepare(
                            'INSERT INTO spells(spell_name,img_spell,element_type_id) 
                            VALUES (:spell_name,:img_spell,:element_type_id)
                        ');
                        $requestCreateSpell->execute([
                            'spell_name'=>$nameSpell,
                            'img_spell'=> $uniqueName,
                            'element_type_id'=>$elementIds[0]
                        ]);
                        header('location:http://localhost:8080/codex/index.php');
                    }
                    break;
            }
        }
    } else {
        header('location:http://localhost:8080/codex/index.php');
    }
?>

<body>
    <?php include('/var/www/html/codex/layout/header.php'); ?>
    <main>
        <section>
            <div class="container">
                <div class="cards-container">
                    <h2>Écriture de votre magicae :</h2>
                    <form class="form-content" action="create_spell.php" method="post" enctype="multipart/form-data">
                        <label for="name_spell">Nom de votre magicae :</label>
                        <input type="text" name="name_spell" placeholder="nom spell" required>
                        <label for="spellFile">Croquis de votre magicae :</label>
                        <input type="file" name="spellFile">
                        <label for="elements">Choisissez la voie de votre magicae.</label>
                        <select name="elements[]" required>
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