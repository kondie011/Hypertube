<?php

    include_once "config/config.php";

    if ($_SESSION['login'] == "" && $_SESSION['user'] == "hypertube")
    {
        header('Location: login.php');
        die();
    }
    else if ($_SESSION['user'] == "hypertube")
    {
    }
    else if ($_SESSION['user'] == "")
    {
        header('Location: login.php');
        die();
    }

?>