<?php
    include_once "config/config.php";
    
    if ($_SESSION['user'] == "hypertube")
    {
        $_SESSION['login'] = "";
        $_SESSION['passwd'] = "";
        $_SESSION['user'] = "";
    }
    else if ($_SESSION['user'] == "google")
    {
        $_SESSION['g_id'] = "";
        $_SESSION['g_email'] = "";
        $_SESSION['g_name'] = "";
        $_SESSION['g_image_url'] = "";
        $_SESSION['user'] = "";
    }
    else if ($_SESSION['user'] == "42")
    {
        $_SESSION['w_id'] = "";
        $_SESSION['w_email'] = "";
        $_SESSION['w_name'] = "";
        $_SESSION['w_image_url'] = "";
        $_SESSION['user'] = "";
    }
    ob_start();
    header("Location: login.php");
    ob_end_flush();
?>