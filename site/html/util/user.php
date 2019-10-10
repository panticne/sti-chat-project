<?php

function is_admin($userId)
{
    try {
        $stmt = $GLOBALS['db']->prepare('SELECT admin FROM user WHERE id = :id');
        $stmt->execute(['id' => $userId]);
        $admin = $stmt->fetch();
        return $admin['admin'];
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function delete_user($userId)
{
    try {
        $stmt = $GLOBALS['db']->prepare('DELETE FROM user WHERE id = :id');
        $stmt->execute(['id' => $userId]);
        return $stmt->rowCount() == 1;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function username_exists($username)
{
    try {
        $stmt = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM user WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetch();
        return $res[0] == 1;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function update_user($user)
{
    try {
        $stmt = $GLOBALS['db']->prepare('UPDATE user SET firstname = :firstname, lastname = :lastname, password = :password, admin = :admin, active = :active WHERE id = :id');
        $stmt->execute(['firstname' => $user['firstname'], 'lastname' => $user['lastname'], 'password' => $user['password'], 'admin' => $user['admin'] == "on", 'active' => $user['active'] == "on", 'id' => $user['id']]);
        return $stmt->rowCount() == 1;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function create_user($user)
{
    try {
        $stmt = $GLOBALS['db']->prepare('INSERT INTO user (firstname, lastname, username, password, admin, active) VALUES (:firstname, :lastname, :username, :password, :admin, :active)');
        $stmt->execute(['firstname' => $user['firstname'], 'lastname' => $user['lastname'], 'username' => $user['username'], 'password' => $user['password'], 'admin' => $user['admin'] == "on", 'active' => $user['active'] == "on"]);
        return $stmt->rowCount() == 1;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function get_all_users()
{
    try {
        $stmt = $GLOBALS['db']->query('SELECT * FROM user');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function get_user($userId)
{
    try {
        $stmt = $GLOBALS['db']->prepare('SELECT * FROM user WHERE id = :id');
        $stmt->execute(['id' => $_POST['id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}
