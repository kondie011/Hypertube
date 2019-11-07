<?php

    include_once "config/config.php";

    if (isset($_GET['oldPassword']) && isset($_GET['newPassword']) && isset($_GET['confPassword']) && strlen($_GET['newPassword']) >= 6)
    {
        $username = $_SESSION['login'];
        $oldPassword = $_GET['oldPassword'];
        $newPassword = $_GET['newPassword'];
        $confPassword = $_GET['confPassword'];

        if ($newPassword == $confPassword && preg_match("/[0-9]/", $newPassword) && preg_match("/[A-Z]/", $newPassword))
        {
            $theRealPass = hash('whirlpool', $newPassword);
            $theRealOldPass = hash('whirlpool', $oldPassword);
            $changePassQ = "UPDATE `user` SET `password` = ? WHERE `username` = ? AND `password` = ?";
            $changePassR = $conn->prepare($changePassQ);
            $changePassR->execute([$theRealPass, $username, $theRealOldPass]);
            $conn->exec("COMMIT");
            if ($changePassR->rowCount())
            {
                $_SESSION['passwd'] = $theRealPass;
                echo "Password changed";
            }
            else
            {
                echo "Something went wrong";
            }
        }
        else
        {
            echo "Password doesn't match or you entered an invalid password";
        }
    }
    else
    {
        echo "You forgot to enter all the values";
    }
?>