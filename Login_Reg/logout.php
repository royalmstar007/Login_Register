<?php  //session code to provide access to logined users only
    session_start();
    session_destroy();
    header("Location: login.php");
?>