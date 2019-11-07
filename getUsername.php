<?php
    session_start();

    if ($_SESSION['user'] == "hypertube")
    {
        $user = $_SESSION['login'];
    }
    else if ($_SESSION['user'] == "google")
    {
        $user = $_SESSION['g_name'];
    }
    else if ($_SESSION['user'] == "42")
    {
        $user = $_SESSION['w_name'];
    }
?>