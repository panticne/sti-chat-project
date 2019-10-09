<?php

require_once 'util/db.php';
require_once 'util/redirect.php';

session_start();

// redirect to login if user is not logged in
if (!isset($_SESSION['id'])) {
    redirect_to_login();
}

try {
    $db = init_db();

    $stmt = $db->prepare('SELECT m.id, m.date, m.subject, m.content, m.seen, u.firstname sender_firstname, u.lastname sender_lastname FROM message m INNER JOIN user u ON u.id = m.sender WHERE m.id = :idmess');
    $stmt->execute(['idmess' => $_GET['message']]);
    $message = $stmt->fetch();
    $db = null;
}
catch (PDOException $e) {
    echo $e->getMessage();
}
$pageTitle = 'Lecture Message';
include 'include/html_header.php';
include 'include/html_menu.php';


echo '<td>' . $message['sender_firstname'] . ' ' . $message['sender_lastname'] . '</td>' . '<td>' . $message['date'] . '</td>';
echo '<td>' . $message['subject'] . '</td>';
echo '<td>' . $message['content'] . '</td>';

include 'include/html_footer.php';

?>


