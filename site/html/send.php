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

    echo '<form action="send.php" method="post"><br/>';
    echo '<select name="id">';
    echo '<option>Choisissez un utilisateur</option>';

try {
    $db = init_db();

    // retrieve all user
    $stmt = $db->query('SELECT * FROM user');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = null;
}
catch (PDOException $e) {
    echo $e->getMessage();
}

foreach ($users as $user) {
    echo '<option value="' . $user['id'] . '">' . $user['username'] . '</option>';
}

    echo '</select><br>';
    echo '<input name="subject" placeholder="Sujet"><br/>';
    echo '<textarea name="body"></textarea><br/>';
    echo '<button type="submit" name="send">Envoyer</button>';
    echo '</form>';

if(isset($_POST['send'])){
   // var_dump($_POST);
    try{
        $db = init_db();
        $stmt= $db->prepare('INSERT INTO message (date, sender, receiver, subject,
        content) VALUES (:date, :id,:id_dest,:subject, :content)');
        $stmt->execute(['date' => '01-01-2000', 'id' =>$_SESSION['id'], 'id_dest' => $user['id'], 'subject' => $_POST['subject'], 'content' => $_POST['body']]);
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