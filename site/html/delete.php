<?php

require_once 'util/db.php';
require_once 'util/message.php';
require_once 'util/redirect.php';

session_start();

// redirect to login if user is not logged in
if (!isset($_SESSION['id'])) {
    redirect_to_login();
}

if(isset($_GET['delete'])){
    // deletes the message but make sure it was received by the user making the delete request
    delete_message($_SESSION['id'], $_GET['delete']);
}

redirect_to_index();