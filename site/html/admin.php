<?php

require_once 'util/db.php';
require_once 'util/redirect.php';

session_start();

// redirect to login if user is not logged in
if (!isset($_SESSION['id'])) {
    redirect_to_login();
}

$pageTitle = 'Administration';
include 'include/html_header.php';
include 'include/html_menu.php';

if (isset($_POST['delete'])) {

    var_dump($_POST);

    try {
        $db = init_db();
        $stmt = $db->prepare('DELETE FROM user WHERE id = :id');
        $stmt->execute(['id' => $_POST['id']]);
        $res = $stmt->rowCount();
        $db = null;

        if ($res == 1) {
            echo '<p>Utilisateur supprimé !</p>';
        }
        else {
            echo '<p>Échec de la suppression de l\'utilisateur !</p>';
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}
else {
    echo '<form action="admin.php" method="post">';
    echo '<select name="id">';
    echo '<option>Choisissez un utilisateur</option>';

    try {
        $db = init_db();

        // retrieve all user
        $stmt = $db->query('SELECT * FROM user');
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }

    foreach ($users as $user) {
        echo '<option value="' . $user['id'] . '">' . $user['username'] . '</option>';
    }

    echo '</select>';

    echo '<button type="submit" name="delete">Supprimer</button>';
    echo '<button type="submit" name="edit">Modifier</button>';

    echo '</form>';

    echo '<form action="admin.php" method="post">';
    echo '<select name="id">';
    echo '<option>Choisissez un utilisateur</option>';

    try {
        $db = init_db();

        // retrieve all user
        $stmt = $db->query('SELECT * FROM user');
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }

    foreach ($users as $user) {
        echo '<option value="' . $user['id'] . '">' . $user['username'] . '</option>';
    }

    echo '</select>';

    echo '<button type="submit" name="delete">Supprimer</button>';
    echo '<button type="submit" name="edit">Modifier</button>';

    echo '</form>';

    echo '<form action="admin.php" method="post">';
    echo '<input name="id">';
    echo '<option>Choisissez un utilisateur</option>';

    try {
        $db = init_db();

        // retrieve all user
        $stmt = $db->query('SELECT * FROM user');
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }

    foreach ($users as $user) {
        echo '<option value="' . $user['id'] . '">' . $user['username'] . '</option>';
    }

    echo '</select>';

    echo '<button type="submit" name="delete">Supprimer</button>';
    echo '<button type="submit" name="edit">Modifier</button>';

    echo '</form>';

}
?>

    <!-- TODO  -->

<?php

include 'include/html_footer.php';
