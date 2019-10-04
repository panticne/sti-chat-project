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
    $stmt->execute(['password' => $_POST['password'], 'id' => $_SESSION['id']]);
    $rowCount = $stmt->rowCount();

    if ($rowCount == 1) {
        echo "Mot de passe changé !";
    }
    else {
        echo "Echec du changement de mot de passe !";
    }
}

$pageTitle = 'Changement du mot de passe';
include 'include/html_header.php';

?>

    <form action="pwd.php" method="post">
        <label for="password">Nouveau mot de passe</label>
        <input type="password" id="password" name="password">
        <button type="submit" name="submit">Valider</button>
    </form>

<?php

include 'include/html_footer.php';
