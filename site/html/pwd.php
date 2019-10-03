<?php

session_start();

if (!isset($_SESSION['login'])) {
    header('LOCATION:login.php');
    die();
}

if (isset($_POST['submit'])) {

    $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
    $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $file_db->prepare('UPDATE user SET password = :password WHERE id = :id');
    $stmt->execute(['password' => $_POST['pwd'], 'id' => $_SESSION['id']]);
    $rowCount = $stmt->rowCount();

    var_dump($rowCount);
    if ($rowCount == 1) {
        echo "Mot de passe changé !";
    }
    else {
        echo "Echec du changement de mot de passe !";
    }
}

?>

<form action="" method="post">
    <label for="pwd">Nouveau mot de passe</label>
    <input type="password" id="pwd" name="pwd">
    <button type="submit" name="submit">Valider</button>
</form>