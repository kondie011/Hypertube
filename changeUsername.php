<?php

    include_once "config/config.php";
    include_once "getUsername.php";

    if (isset($_GET['newUsername']) && strlen($_GET['newUsername']) > 0)
    {
        $username = $user;
        $newUsername = $_GET['newUsername'];

        $findUserQuery = "SELECT * FROM `user` WHERE `username` = ?";
        $findUserResult = $conn->prepare($findUserQuery);
        $findUserResult->execute([$newUsername]);
        if ($findUserResult->rowCount())
        {
            echo "Username already exists";
        }
        else
        {
            $changeUsernameQ = "UPDATE `user` SET `username` = ? WHERE `username` = ?";
            $changePosterQ = "UPDATE `images` SET `username` = ? WHERE `username` = ?";

            $changeUsernameR = $conn->prepare($changeUsernameQ);
            $changeUsernameR->execute([$newUsername, $username]);
            
            $conn->exec("COMMIT");
            if ($changeUsernameR->rowCount())
            {
                $changePosterR = $conn->prepare($changePosterQ);

                $changePosterR->execute([$newUsername, $username]);
                $conn->exec("COMMIT");

                $_SESSION['login'] = $newUsername;
                echo "Username changed";
            }
            else
            {
                echo "Something went wrong";
            }
        }
    }
    else
    {
        echo "No username was entered";
    }
?>