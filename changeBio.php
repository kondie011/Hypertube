<?php

    include_once "config/config.php";
    include_once "getUsername.php";

    if (isset($_GET['bio']) && strlen($_GET['bio']) > 0)
    {
        $username = $user;
        $bio = $_GET['bio'];

        $changeBioQ = "UPDATE `user` SET `bio` = ? WHERE `username` = ?";
        $changeBioR = $conn->prepare($changeBioQ);
        $changeBioR->execute([$bio, $username]);
        $conn->exec("COMMIT");
        if ($changeBioR->rowCount())
        {
            echo "Bio changed";
        }
        else
        {
            echo "Something went wrong";
        }
    }
    else
    {
        echo "No Bio was entered";
    }
?>