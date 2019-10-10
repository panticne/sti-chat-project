<?php

$GLOBALS['db'] = init_db();

/**
 * Initializes the database connection and return the created object.
 */
function init_db()
{
    $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}
