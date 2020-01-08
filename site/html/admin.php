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

if (isset($_POST['delete']) && isset($_POST['id'])) {
    $message = delete_user($_POST['id']) ? 'Utilisateur supprimé !' : 'Erreur lors de la suppression de l\'utilisateur !';
    echo '<p>' . $message . '</p>';
}
elseif (isset($_POST['save']) && !empty($_POST['username'])) {

    // update user
    if (get_user_with_username($_POST['username'])) {
        $message = update_user($_POST) ? 'Utilisateur mis à jour !' : 'Erreur lors de la mise à jour de l\'utilisateur !';
    }
    // create user
    else {
        if ($_SESSION['token'] == $_POST['token']) {
            $message = create_user($_POST) ? 'Utilisateur créé !' : 'Erreur lors de la création de l\'utilisateur !';
        } else {
            echo "CSRF Detection";
        }
    }

    echo '<p>' . $message . '</p>';
}
else {
    $length = 32;
    $_SESSION['token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
    ?>

    <form action="admin.php" method="post">
        <select name="id">
            <option disabled selected>Choisissez un utilisateur</option>

            <?php
            foreach (get_all_users() as $user) {
                echo '<option value="' . $user['id'] . '">' . antixss($user['firstname']) . ' ' . antixss($user['lastname']) . '</option>';
            }
            unset($user);
            ?>
        </select>
        <button type="submit" name="delete">Supprimer</button>
        <button type="submit" name="edit">Modifier</button>
        <input type="hidden" name="token" value="<?=$_SESSION['token']?>"/>

    </form><br>

    <?php
    if (isset($_POST['edit']) && isset($_POST['id'])) {
        $user = get_user_with_id($_POST['id']);
    }
    ?>

    <form action="admin.php" method="post">
        <input type="hidden" name="id" value="<?= @$user['id'] ?>">

        <label for="username">Utilisateur</label>
        <input type="text" name="username" id="username" value="<?= @antixss($user['username']) ?>">

        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" id="firstname" value="<?= @antixss($user['firstname']) ?>">

        <label for="lastname">Nom</label>
        <input type="text" name="lastname" id="lastname" value="<?= @antixss($user['lastname']) ?>">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">

        <input name="admin" id="admin" type="checkbox" <?= @$user['admin'] ? "checked" : "" ?>>
        <label for="admin">Admin</label><br>

        <input name="active" id="active" type="checkbox" <?= @$user['active'] ? "checked" : "" ?>>
        <label for="active">Actif</label><br><br>

        <input type="hidden" name="token" value="<?=$_SESSION['token']?>"/>

        <button type="submit" name="save">Sauver</button>
    </form>

    <?php
}

include 'include/html_footer.php';
