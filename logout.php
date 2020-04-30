<?php 

    // Initialise session
    session_start();

    // Unset of all of the session variables
    $_SESSION = array();

    // Session destroy
    session_destroy();

    // Redirect to login page
    header('Location: login.php');

?>