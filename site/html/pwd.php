<?php

require_once 'util/db.php';
require_once 'util/redirect.php';

session_start();

// redirect to login if user is not logged in
if (!isset($_SESSION['id'])) {
    redirect_to_login();
}

if (isset($_POST['submit'])) {

    $db = init_db();

    $stmt = $db->prepare('UPDATE user SET password = :password WHERE id = :id');
    $stmt->execute(['password' => $_POST['pwd'], 'id' => $_SESSION['id']]);
    $rowCount = $stmt->rowCount();

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