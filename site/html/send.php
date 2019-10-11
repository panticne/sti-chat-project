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

?>
<?php


try{
    
    if(isset($_GET['message'])){
        $db = init_db();
            
        // retrieve all user
        $stmt = $db->prepare('SELECT m.id, m.subject, u.firstname sender_firstname, u.lastname sender_lastname, u.username FROM message m INNER JOIN user u ON u.id = m.sender WHERE m.id = :idmess');
        $stmt->execute(['idmess' => $_GET['message']]);
        $users = $stmt->fetch();
        $db = null;
        echo '<form action="send.php" method="post"><br/>';
        echo '<input name="id" value="'.$users['username'].'">';
        echo '</select><br>';
        echo '<input name="subject" value="RE : '.$users['subject'].'"><br/>';
        echo '<textarea name="body"></textarea><br/>';
        echo '<button type="submit" name="send">Envoyer</button>';
        echo '</form>';

    }else{
        $db = init_db();
        // retrieve all user
        $stmt = $db->query('SELECT * FROM user');
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        echo '<form action="send.php" method="post"><br/>';        
        echo '<select name="id">';
        foreach ($users as $user) {
            echo '<option value="' . $user['id'] . '">' . $user['username'] . '</option>';
        }   
        echo '<option>Choisissez un utilisateur</option>';
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
if(isset($_POST['send'])){
    try{
        $db = init_db();
        $stmt= $db->prepare('INSERT INTO message (date, sender, receiver, subject,
        content) VALUES (:date, :id,:id_dest,:subject, :content)');
        $stmt->execute(['date' =>  date('Y-m-d'), 'id' =>$_SESSION['id'], 'id_dest' => $user['id'], 'subject' => $_POST['subject'], 'content' => $_POST['body']]);
        $res = $stmt->rowCount();
        $db = null;
        if ($res == 1) {
            echo '<p>Message envoyé !</p>';
        }
        else {
            echo '<p>Échec de l\'envoie du message !</p>';
        }
    }

    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

include 'include/html_footer.php';
?>