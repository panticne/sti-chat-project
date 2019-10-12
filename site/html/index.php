<?php

require_once 'util/db.php';
require_once 'util/user.php';
require_once 'util/message.php';
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

$user = get_user($_SESSION['id']);
$pageTitle = 'Accueil – ' . $user['username'];
include 'include/html_header.php';
include 'include/html_menu.php';

?>

    <table>
        <caption>Messages</caption>
        <tr>
            <th>Date</th>
            <th>Expéditeur</th>
            <th>Sujet</th>
            <th>Lu</th>
            <th colspan="3">Actions</th>
        </tr>

        <?php
        foreach (get_user_messages($_SESSION['id']) as $m) {

            $hasSender = !empty($m['sender']);

            echo '<tr>';
            echo '<td>' . $m['date'] . '</td>';
            echo '<td>' . ($hasSender ? $m['sender'] : '<em>Inconnu</em>') . '</td>';
            echo '<td>' . $m['subject'] . '</td>';
            echo '<td>' . ($m['seen'] == 'TRUE' ? 'Oui' : 'Non') . '</td>';
            echo '<td>' . ($hasSender ? '<a href="send.php?message=' . $m['id'] . '">Répondre</a>' : '') . '</td>';
            echo '<td><a href="index.php?delete=' . $m['id'] . '">Supprimer</a></td>';
            echo '<td><a href="read.php?message=' . $m['id'] . '">Ouvrir</a>' . '</td>';
            echo '</tr>';
        }
        ?>

    </table>

<?php

include 'include/html_footer.php';
