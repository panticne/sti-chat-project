<?php

require_once 'util/db.php';
require_once 'util/user.php';
require_once 'util/redirect.php';

session_start();

// redirect to login if user is not logged in
if (!isset($_SESSION['id'])) {
    redirect_to_login();
}

// redirect to index if user is not admin
if (!is_admin($_SESSION['id'])) {
    redirect_to_index();
}

$pageTitle = 'Administration';
include 'include/html_header.php';
include 'include/html_menu.php';

if (isset($_POST['delete'])) {

    $message = delete_user($_POST['id']) ? 'Utilisateur supprimé !' : 'Erreur lors de la suppression de l\'utilisateur !';
    echo '<p>' . $message . '</p>';
}
elseif (isset($_POST['save'])) {

    // update user
    if (username_exists($_POST['username'])) {
        $message = update_user($_POST) ? 'Utilisateur mis à jour !' : 'Erreur lors de la mise à jour de l\'utilisateur !';
    }
    // create user
    else {
        $message = create_user($_POST) ? 'Utilisateur créé !' : 'Erreur lors de la création de l\'utilisateur !';
    }

    echo '<p>' . $message . '</p>';
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

    unset($user);
    echo '</select>';

    echo '<button type="submit" name="delete">Supprimer</button>';
    echo '<button type="submit" name="edit">Modifier</button>';

    echo '</form>';

    if (isset($_POST['edit'])) {
        try {
            $db = init_db();
            $stmt = $db->prepare('SELECT * FROM user WHERE id = :id');
            $stmt->execute(['id' => $_POST['id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    ?>

    <form action="admin.php" method="post">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <label for="username">Utilisateur</label>
        <input name="username" id="username" value="<?= $user['username'] ?>">

        <label for="firstname">Prénom</label>
        <input name="firstname" id="firstname" value="<?= $user['firstname'] ?>">

        <label for="lastname">Nom</label>
        <input name="lastname" id="lastname" value="<?= $user['lastname'] ?>">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" value="<?= $user['password'] ?>">

        <label for="admin">Admin</label>
        <input name="admin" id="admin" type="checkbox" <?= $user['admin'] ? "checked" : "" ?>>

        <label for="active">Actif</label>
        <input name="active" id="active" type="checkbox" <?= $user['active'] ? "checked" : "" ?>>

        <button type="submit" name="save">Sauver</button>
    </form>

    <?php
}

include 'include/html_footer.php';
