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
    if (get_user_with_username($_POST['username'])) {
        $message = update_user($_POST) ? 'Utilisateur mis à jour !' : 'Erreur lors de la mise à jour de l\'utilisateur !';
    }
    // create user
    else {
        $message = create_user($_POST) ? 'Utilisateur créé !' : 'Erreur lors de la création de l\'utilisateur !';
    }

    echo '<p>' . $message . '</p>';
}
else {
    ?>

    <form action="admin.php" method="post">
        <select name="id">
            <option disabled selected>Choisissez un utilisateur</option>

            <?php
            foreach (get_all_users() as $user) {
                echo '<option value="' . $user['id'] . '">' . $user['firstname'] . ' ' . $user['lastname'] . '</option>';
            }
            unset($user);
            ?>
        </select>
        <button type="submit" name="delete">Supprimer</button>
        <button type="submit" name="edit">Modifier</button>
    </form><br>

    <?php
    if (isset($_POST['edit'])) {
        $user = get_user_with_id($_POST['id']);
    }
    ?>

    <form action="admin.php" method="post">
        <input type="hidden" name="id" value="<?= @$user['id'] ?>">

        <label for="username">Utilisateur</label>
        <input name="username" id="username" value="<?= @$user['username'] ?>"><br>

        <label for="firstname">Prénom</label>
        <input name="firstname" id="firstname" value="<?= @$user['firstname'] ?>"><br>

        <label for="lastname">Nom</label>
        <input name="lastname" id="lastname" value="<?= @$user['lastname'] ?>"><br>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" value="<?= @$user['password'] ?>"><br>

        <label for="admin">Admin</label>
        <input name="admin" id="admin" type="checkbox" <?= @$user['admin'] ? "checked" : "" ?>><br>

        <label for="active">Actif</label>
        <input name="active" id="active" type="checkbox" <?= @$user['active'] ? "checked" : "" ?>><br>

        <button type="submit" name="save">Sauver</button>
    </form>

    <?php
}

include 'include/html_footer.php';
