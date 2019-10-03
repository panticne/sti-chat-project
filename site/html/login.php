<?php

session_start();
echo isset($_SESSION['login']);
if (isset($_SESSION['login'])) {
    header('LOCATION:index.php');
    die();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='content-type' content='text/html;charset=utf-8'/>
    <title>Login</title>
    <meta charset="utf-8">
</head>
<body>
<div class="container">
    <h3 class="text-center">Login</h3>
    <?php
    if (isset($_POST['submit'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        try {

            $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
            $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $file_db->prepare('SELECT id FROM user WHERE username = :username AND password = :password');
            $stmt->execute(['username' => $username, 'password' => $password]);
            $res = $stmt->fetch();

            //var_dump($res);

            if ($res) {
                $_SESSION['login'] = true;
                $_SESSION['id'] = $res[0];
                $_SESSION['username'] = $username;
                header('LOCATION:index.php');
                die();
            }

            echo "<div class='alert alert-danger'>Username and Password do not match.</div>";

            // Close file db connection
            $file_db = null;
        } catch (PDOException $e) {
            // Print PDOException message
            echo $e->getMessage();
        }


    }
    ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" name="password" required>
        </div>
        <button type="submit" name="submit" class="btn btn-default">Login</button>
    </form>
</div>
</body>
</html>