<?php

require_once 'util/db.php';
require_once 'util/user.php';
require_once 'util/redirect.php';

session_start();

// redirect to login if user is not logged in
if (!isset($_SESSION['id'])) {
    redirect_to_login();
}

$pageTitle = 'Changement du mot de passe';
include 'include/html_header.php';
include 'include/html_menu.php';

if (isset($_POST['submit']) && !empty($_POST['old_password']) && !empty($_POST['new_password'])) {

    $user = get_user_with_id($_SESSION['id']);
    if ($_SESSION['token'] == $_POST['token']) {
        if (password_verify($_POST['old_password'], $user['password']) && update_password($_SESSION['id'], $_POST['new_password'])) {
            echo "Mot de passe changé !";
        }
        else {
            echo "Échec du changement de mot de passe !";
        }
    } else {
        echo "CSRF Detection";
    }
}
else{
    $length = 32;
    $_SESSION['token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
}

?>

    <form action="pwd.php" method="post">
        <label for="old_password">Mot de passe actuel</label>
        <input type="password" id="old_password" name="old_password">
        <label for="new_password">Nouveau mot de passe</label>
        <input type="password" id="new_password" name="new_password">
        <input type="hidden" name="token" value="<?=$_SESSION['token']?>"/>
        <button type="submit" name="submit">Valider</button>
    </form>

<?php

include 'include/html_footer.php';
