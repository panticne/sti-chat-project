<?php require_once 'util/user.php'; ?>

<form action="" method="post">
    <button type="submit" name="logout">Logout</button>
</form>

<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="send.php">Envoyer un message</a></li>
        <li><a href="pwd.php">Changer son mot de passe</a></li>
        <?= is_admin($_SESSION['id']) ? '<li><a href="admin.php">Administration</a></li>' : '' ?>
    </ul>
</nav>