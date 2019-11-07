<?php
    include_once "config/config.php";

    if ($_SESSION['user'] == "hypertube")
    {
        $username = $_SESSION['login'];
    }
    else if ($_SESSION['user'] == "google")
    {
        $username = $_SESSION['g_name'];
    }
    else if ($_SESSION['user'] == "42")
    {
        $username = $_SESSION['w_name'];
    }
    else
    {
        $username = "";
    }
    if ($username != "")
    {
        echo "<p id='web_name'>"."Welcome <span style='color: royalblue;'>".$username."</span></p>";
    }
    else
    {
        echo "<p id='web_name'>Camagru</p>";
    }
?>