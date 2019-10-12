<?php

function get_user_messages($userId)
{
    try {
        $stmt = $GLOBALS['db']->prepare('SELECT m.id, m.date, m.subject, m.content, m.seen, u.firstname || \' \' || u.lastname sender FROM message m LEFT JOIN user u ON u.id = m.sender WHERE receiver = :receiver');
        $stmt->execute(['receiver' => $userId]);
        return $stmt->fetchAll();
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

function get_message($messageId)
{
    try {
        $stmt = $GLOBALS['db']->prepare('SELECT m.id, m.date, m.subject, m.content, m.seen, u.firstname || \' \' || u.lastname sender FROM message m LEFT JOIN user u ON u.id = m.sender WHERE m.id = :id');
        $stmt->execute(['id' => $messageId]);
        return $stmt->fetch();
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

function is_read($messageId)
{
    try {
        $stmt = $GLOBALS['db']->prepare('UPDATE message SET seen = 1 WHERE id = :id');
        $stmt->execute(['id' => $messageId]);
        return $stmt->rowCount() == 1;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}