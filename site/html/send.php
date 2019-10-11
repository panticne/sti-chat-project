<?php

require_once 'util/db.php';
require_once 'util/redirect.php';

session_start();

// redirect to login if user is not logged in
if (!isset($_SESSION['id'])) {
    redirect_to_login();
}

$pageTitle = 'Envoyer un message';
include 'include/html_header.php';
include 'include/html_menu.php';

try {
    if (isset($_GET['message'])) {

        $stmt = $GLOBALS['db']->prepare('SELECT m.id, m.subject, u.id sender_id, u.firstname sender_firstname, u.lastname sender_lastname, u.username FROM message m INNER JOIN user u ON u.id = m.sender WHERE m.id = :idmess');
        $stmt->execute(['idmess' => $_GET['message']]);
        $user = $stmt->fetch();

        echo '<form action="send.php" method="post"><br/>';
        echo '<select name="id">';
        echo '<option value="' . $user['sender_id'] . '">' . $user['sender_firstname'] . ' ' . $user['sender_lastname'] . '</option>';
        echo '</select><br>';
        echo '<input name="subject" value="RE : ' . $user['subject'] . '"><br/>';
        echo '<textarea name="body"></textarea><br/>';
        echo '<button type="submit" name="send">Envoyer</button>';
        echo '</form>';
    }
    else {
        // retrieve all user
        $stmt = $GLOBALS['db']->query('SELECT * FROM user');
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<form action="send.php" method="post"><br/>';
        echo '<select name="id">';
        echo '<option disabled selected>Choisissez un utilisateur</option>';

        foreach ($users as $user) {
            echo '<option value="' . $user['id'] . '">' . $user['firstname'] . ' ' . $user['lastname'] . '</option>';
        }
        unset($user);

        echo '</select><br>';
        echo '<input name="subject" placeholder="Sujet"><br/>';
        echo '<textarea name="body"></textarea><br/>';
        echo '<button type="submit" name="send">Envoyer</button>';
        echo '</form>';
    }
}
catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_POST['send'])) {
    try {
        $stmt = $GLOBALS['db']->prepare('INSERT INTO message (date, sender, receiver, subject, content) VALUES (:date, :id, :id_dest, :subject, :content)');
        $stmt->execute(['date' => date('d-m-Y'), 'id' => $_SESSION['id'], 'id_dest' => $_POST['id'], 'subject' => $_POST['subject'], 'content' => $_POST['body']]);
        $res = $stmt->rowCount();

        if ($res == 1) {
            echo '<p>Message envoyé !</p>';
        }
        else {
            echo '<p>Échec de l\'envoi du message !</p>';
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

include 'include/html_footer.php';

?>
