<?php

session_start();

if (isset($_POST['logout'])) {
    $_SESSION = array();
}

if (!isset($_SESSION['login'])) {
    header('LOCATION:login.php');
    die();
}

echo 'Welcome ' . $_SESSION['username'] . '<br/>';

try {
    $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
    $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $file_db->prepare('SELECT * FROM message WHERE receiver = :receiver');
    $stmt->execute(['receiver' => $_SESSION['id']]);
    $res = $stmt->fetchAll();

    foreach ($res as $row) {
        echo "Id: " . $row['id'] . "<br/>";
        echo "Title: " . $row['subject'] . "<br/>";
        echo "Time: " . $row['date'] . "<br/>";
        echo "<br/>";
    }

    // Close file db connection
    $file_db = null;
} catch (PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
}

?>

<a href="send.php">Envoyer un message</a><br>
<a href="pwd.php">Changer le mot de passe</a><br>

<form action="" method="post">
    <button type="submit" name="logout">Logout</button>
</form>
