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

if (!isset($_POST['send'])) {
    $length = 32;
    $_SESSION['token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
}

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

    <form action="send.php" method="post" class="send">
        <select name="id">
            <option value="<?= $message['sender_id'] ?>"><?= $message['sender'] ?></option>
        </select>
        <input type="text" name="subject" value="Re : <?= $message['subject'] ?>">
        <textarea name="body"><?= "\n\n\n\n—— Message précédent [" . $message['date'] . "] ——\n" . $message['content'] ?></textarea>
        <input type="hidden" name="token" value="<?=$_SESSION['token']?>"/>
        <button type="submit" name="send">Envoyer</button>
    </form>

    <?php
}
// sending a new message
else {
    $users = get_all_users();
    ?>

    <form action="send.php" method="post" class="send">
        <select name="id">
            <option disabled selected>Choisissez un destinataire</option>

            <?php
            foreach ($users as $user) {
                echo '<option value="' . $user['id'] . '">' . $user['firstname'] . ' ' . $user['lastname'] . '</option>';
            }
            unset($user);
            ?>

        </select>
        <input type="text" name="subject" placeholder="Sujet">
        <textarea name="body"></textarea>
        <input type="hidden" name="token" value="<?=$_SESSION['token']?>"/>
        <button type="submit" name="send">Envoyer</button>
    </form>

    <?php
}

if (isset($_POST['send'])) {

    if (!isset($_POST['id'])) {
        echo '<p>Choisissez un destinataire.</p>';
    }
    else {
        if ($_SESSION['token'] == $_POST['token']) {
            $res = send_message(date('Y-m-d H:i'), $_SESSION['id'], $_POST['id'], $_POST['subject'], $_POST['body']);
            if ($res) {
                echo '<p>Message envoyé !</p>';
            }
            else {
                echo '<p>Échec de l\'envoi du message !</p>';
            }
        } else {
            echo "CSRF Detection";
        }

    }
}

include 'include/html_footer.php';

?>
