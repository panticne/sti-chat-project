<?php

require_once 'util/db.php';
require_once 'util/user.php';
require_once 'util/message.php';
require_once 'util/redirect.php';

session_start();

// redirect to login if user is not logged in
if (!isset($_SESSION['id'])) {
    redirect_to_login();
}

$pageTitle = 'Envoyer un message';
include 'include/html_header.php';
include 'include/html_menu.php';

// replying to an existing message
if (isset($_GET['message'])) {

    $message = get_message($_GET['message']);
    if (!$message) {
        echo '<p>Ce message n\'existe pas ou a été supprimé !</p>';
        exit();
    }

    $senderExists = !empty($message['sender']);
    if (!$senderExists) {
        echo '<p>L\'utilisateur n\'existe pas ou a été supprimé !</p>';
        exit();
    }
    ?>

    <form action="send.php" method="post">
        <select name="id" disabled>
            <option value="<?= $message['sender_id'] ?>"><?= $message['sender'] ?></option>
        </select><br>
        <input name="subject" value="Re : <?= $message['subject'] ?>"><br/>
        <textarea name="body"></textarea><br/>
        <button type="submit" name="send">Envoyer</button>
    </form>

    <?php
}
// sending a new message
else {
    $users = get_all_users();
    ?>

    <form action="send.php" method="post">
        <select name="id">
            <option disabled selected>Choisissez un destinataire</option>

            <?php
            foreach ($users as $user) {
                echo '<option value="' . $user['id'] . '">' . $user['firstname'] . ' ' . $user['lastname'] . '</option>';
            }
            unset($user);
            ?>

        </select><br>
        <input name="subject" placeholder="Sujet"><br/>
        <textarea name="body"></textarea><br/>
        <button type="submit" name="send">Envoyer</button>
    </form>

    <?php
}

if (isset($_POST['send'])) {

    $res = send_message(date('Y-m-d'), $_SESSION['id'], $_POST['id'], $_POST['subject'], $_POST['body']);
    if ($res) {
        echo '<p>Message envoyé !</p>';
    }
    else {
        echo '<p>Échec de l\'envoi du message !</p>';
    }
}

include 'include/html_footer.php';

?>
