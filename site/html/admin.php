<?php

require_once 'util/db.php';
require_once 'util/redirect.php';

session_start();

// redirect to login if user is not logged in
if (!isset($_SESSION['id'])) {
    redirect_to_login();
}

$pageTitle = 'Administration';
include 'include/html_header.php';
include 'include/html_menu.php';

?>

    <!-- TODO -->

<?php

include 'include/html_footer.php';
