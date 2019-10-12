<?php

require_once 'util/db.php';
require_once 'util/message.php';
require_once 'util/redirect.php';

session_start();

// redirect to login if user is not logged in
if (!isset($_SESSION['id'])) {
    redirect_to_login();
}

$message = get_message($_GET['message']);
$hasSender = !empty($message['sender']);

// mark message as read
is_read($_GET['message']);

$pageTitle = 'Lecture Message';
include 'include/html_header.php';
include 'include/html_menu.php';

?>

<table>
    <tr>
        <td>Expéditeur</td>
        <td><?= ($hasSender ? $message['sender'] : '<em>Inconnu</em>') ?></td>
    </tr>
    <tr>
        <td>Date</td>
        <td><?= $message['date'] ?></td>
    </tr>
    <tr>
        <td>Sujet</td>
        <td><?= $message['subject'] ?></td>
    </tr>
    <tr>
        <td>Message</td>
        <td><?= $message['content'] ?></td>
    </tr>
</table>

<?php

include 'include/html_footer.php';
