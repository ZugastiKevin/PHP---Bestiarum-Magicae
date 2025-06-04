<?php 
    ob_start();
    session_start();

    if (!empty($_COOKIE['token-user'])) {
        $bdd = new PDO('mysql:host=mysql;dbname=codex;charset=utf8','root','root');
        $token = $_COOKIE['token-user'];
        $requestPrepareUser = $bdd->prepare(
            "SELECT id, nom, prenom
            FROM user
            WHERE token = :token
        ");
        $requestPrepareUser->execute(['token'=>sha1($token)]);
        $data = $requestPrepareUser->fetch();
        $_SESSION["currentUser"] = ['id'=>$data['id'], 'nom'=>$data['nom'], 'prenom'=>$data['prenom']];
        updateToken($data['id']);
    }

    function deleteToken($id) {
        $bdd = new PDO('mysql:host=mysql;dbname=codex;charset=utf8','root','root');
        $requestUpdate = $bdd->prepare(
            "UPDATE users
            SET token = :token, tokenValidate = :tokenValidate
            WHERE id = :id
        ");
        $requestUpdate->execute(['token'=>null, 'tokenValidate'=>null, 'id'=>$id]);
        setcookie('token-user', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'lax'
        ]);
        session_unset();
        session_destroy();
        header("location:http://localhost:8080/codex/index.php");
    }

    function updateToken($id) {
        $bdd = new PDO('mysql:host=mysql;dbname=codex;charset=utf8','root','root');
        $token = bin2hex(random_bytes(32));
        $time = time() + (7 * 24 * 60 * 60);
        $requestUpdate = $bdd->prepare(
            "UPDATE user 
            SET token = :token, tokenValidate = :tokenValidate
            WHERE id = :id
        ");
        $requestUpdate->execute(['id'=>$id, 'token'=>sha1($token), 'tokenValidate'=>$time]);

        setcookie('token-user', $token, [
            'expires' => $time,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'lax'
        ]);
    }

    function createSessionUserWithRemember($id, $lastname, $firstname) {
        $_SESSION["currentUser"] = ['id'=>$id, 'nom'=>$lastname, 'prenom'=>$firstname];
        updateToken($id);
    }

    function createSessionUser($id, $lastname, $firstname) {
        $_SESSION["currentUser"] = ['id'=>$id, 'nom'=>$lastname, 'prenom'=>$firstname];
    }