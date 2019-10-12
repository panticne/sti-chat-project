<?php

require_once 'util/db.php';
require_once 'util/redirect.php';

session_start();

// redirect to index.php if user is already logged in
if (isset($_SESSION['id'])) {
    redirect_to_index();
}

// if user has submitted login form, perform authentication
$error = '';
if (isset($_POST['submit'])) {

    try {
        $stmt = $GLOBALS['db']->prepare('SELECT id, active FROM user WHERE username = :username AND password = :password');
        $stmt->execute(['username' => $_POST['username'], 'password' => $_POST['password']]);
        $user = $stmt->fetch();

        if ($user && $user['active'] == 1) {
            $_SESSION['id'] = $user['id'];
            redirect_to_index();
        }
        else if ($user['active'] == 0) {
            $error = 'Votre compte est inactif.';
        }
        else {
            $error = 'L\'authentification a échouée.';
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$pageTitle = 'Authentification';
include 'include/html_header.php';

?>

    <div><?= $error ?></div>
    <form action="login.php" method="post">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username"><br>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password"><br>
        <button type="submit" name="submit">Authentification</button>
    </form>

<?php

include 'include/html_footer.php';