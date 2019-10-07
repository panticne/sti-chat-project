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
            echo '<p>Erreur lors de la suppression de l\'utilisateur !</p>';
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}
elseif (isset($_POST['save'])) {

    try {
        $db = init_db();

        // check if user exists
        $stmt = $db->prepare('SELECT COUNT(*) FROM user WHERE id = :id');
        $stmt->execute(['id' => $_POST['id']]);
        $res = $stmt->fetch();

        if ($res[0] == 1) {
            // update user
            $stmt = $db->prepare('UPDATE user SET firstname = :firstname, lastname = :lastname, password = :password, admin = :admin, active = :active WHERE id = :id');
            $stmt->execute(['firstname' => $_POST['firstname'], 'lastname' => $_POST['lastname'], 'password' => $_POST['password'], 'admin' => $_POST['admin'] == "on", 'active' => $_POST['active'] == "on", 'id' => $_POST['id']]);
            $res = $stmt->rowCount();

            if ($res == 1) {
                echo '<p>Utilisateur mis à jour !</p>';
            }
            else {
                echo '<p>Erreur lors de la mise à jour de l\'utilisateur !</p>';
            }
        }
        else {
            // insert user
            $stmt = $db->prepare('INSERT INTO user (firstname, lastname, username, password, admin, active) VALUES (:firstname, :lastname, :username, :password, :admin, :active)');
            $stmt->execute(['firstname' => $_POST['firstname'], 'lastname' => $_POST['lastname'], 'username' => $_POST['username'], 'password' => $_POST['password'], 'admin' => $_POST['admin'] == "on", 'active' => $_POST['active'] == "on"]);
            $res = $stmt->rowCount();

            if ($res == 1) {
                echo '<p>Utilisateur créé !</p>';
            }
            else {
                echo '<p>Erreur lors de la création de l\'utilisateur !</p>';
            }
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
