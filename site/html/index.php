<?php

require_once 'util/db.php';
require_once 'util/redirect.php';

session_start();

// perform logout if user has clicked the button
if (isset($_POST['logout'])) {
    $_SESSION = array();
}

// redirect to login if user is not logged in
if (!isset($_SESSION['id'])) {
    redirect_to_login();
}

try {
    $db = init_db();

    // retrieve user's messages
    $stmt = $db->prepare('SELECT * FROM message WHERE receiver = :receiver');
    $stmt->execute(['receiver' => $_SESSION['id']]);
    $messages = $stmt->fetchAll();
    $db = null;

    foreach ($messages as $message) {
        echo "Id: " . $message['id'] . "<br/>";
        echo "Title: " . $message['subject'] . "<br/>";
        echo "Time: " . $message['date'] . "<br/>";
        echo "<br/>";
    }
}
catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<a href="send.php">Envoyer un message</a><br>
<a href="pwd.php">Changer le mot de passe</a><br>

<form action="" method="post">
    <button type="submit" name="logout">Logout</button>
</form>
