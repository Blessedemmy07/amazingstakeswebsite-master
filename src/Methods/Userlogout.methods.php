<?php
    session_start();

    unset($_SESSION['logged_in_user']);
    session_destroy();

    if(!isset($_SESSION['logged_in_user']) && empty($_SESSION['logged_in_user'])) {
        header("Location: /");
    }

?>