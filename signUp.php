<?php
    include "config/config.php";

    if (isset($_POST['login']) && isset($_POST['l_name']) && isset($_POST['f_name']) && isset($_POST['passwd']) && isset($_POST['conf_passwd']) && isset($_POST['email']) && isset($_POST['submit']) && $_POST['submit'] == "Sign up")
    {
        $login = $_POST['login'];
        $passwd = hash('whirlpool',$_POST['passwd']);
        $email = $_POST['email'];
        $l_name = $_POST['l_name'];
        $f_name = $_POST['f_name'];
        
        if (isset($_POST['location']))
        {
            $location = $_POST['location'];
        }
        else
        {
            $location = "";
        }
        $findUserQuery = "SELECT * FROM `user` WHERE `username` = ?";
        $findUserResult = $conn->prepare($findUserQuery);
        $findUserResult->execute([$login]);
        if ($findUserResult->rowCount())
        {
            
        }
        else if ($_POST['conf_passwd'] == $_POST['passwd'])
        {
            if (strlen($_POST['passwd']) >= 6 && preg_match("/[0-9]/", $_POST['passwd']) && preg_match("/[A-Z]/", $_POST['passwd']))
            {
                $url = $_SERVER['HTTP_HOST'] . str_replace("signUp.php", "", $_SERVER['REQUEST_URI']);
                $reqUri = $_SERVER['REQUEST_URI'];
                //$url = $_SERVER['HTTP_HOST'] . substr($reqUri, 0, strrpos($reqUri, "signup.php"));
                sendEmail($email,   "<html>
                                        <p>Hi, $f_name $l_name(AKA: $login), Welcome to Matcha where you can find the LOVE of your life<p>
                                        <a href='http://".$url."index.php?login=".$login."&passwd=".$passwd."&email=".$email."&f_name=".$f_name."&l_name=".$l_name."'>
                                            <input type='submit' value='click to verify' style='color: #FFFFFF; padding: 10px; background-color: green;'/>
                                        </a>
                                    </html>", "Verification");
                die("Check your email");
            }
            else
            {
                echo "<script>alert('Password must be at least 6 characters, contain at least one number and an uppercase character');</script>";
            }
        }
        else
        {
            echo "<script>alert('password doesn't match');</script>";
        }
    }
    else if ($_POST['sp'] == "Sign up")
    {
        ob_start();
        header("Location: signUp.php");
        ob_end_flush();
        die();
    }
    
    function sendEmail($to, $msg, $sbj)
    {
        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        $from = "www.kondie@live.com";
        $header = "From:" . $from;

        mail($to, $sbj, $msg, $header);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sign page</title>
        <style>
            body
            {
                background-image: url("https://www.hdwallpaper.nu/wp-content/uploads/2016/02/deadpool_wallpaper527372.jpg");
            }
            #ze_form
            {
                font-size: 30px;
                text-align: left;
                position: relative;
                border: 1px solid grey;
                border-radius: 10px;
                padding: 30px;
                width: 300px;
                left: 40%;
                background-color: black;
                text-align: -webkit-right;
            }
            #ze_form input
            {
                margin: 5px;
            }
            #welcome
            {
                margin-left: 39%;
                color: white;
                font-size: 55px;
                font-family: fantasy;
                left: 39%;
            }
            .text_style1
            {
                font-size: 17px;
                color: white;
                font-family: fantasy;
            }
        </style>
    </head>
    <body>
        <a href="login.php"><img src="http://icons.iconarchive.com/icons/graphicloads/100-flat-2/256/arrow-back-icon.png" style="width: 40px;" title="Back to login"></a>
        <p id="welcome">Fill in the details</p>
        <form id="ze_form" name="index.php" method="POST" enctype="multipart/form-data">
            <label class="text_style1" for="login">Username: </label><input type="text" name="login" value="" required/>
            <br />
            <label class="text_style1" for="email">Email: </label><input type="email" name="email" value="" required/>
            <br />
            <label class="text_style1" for="f_name">First name: </label><input type="text" name="f_name" value="" required/>
            <br />
            <label class="text_style1" for="l_name">Last name: </label><input type="text" name="l_name" value="" required/>
            <br />
            <label class="text_style1" for="passwd">Password: <label><input type="password" name="passwd" value="" required/>
            <br />
            <label class="text_style1" for="conf_passwd">Confirm password: <label><input type="password" name="conf_passwd" value="" required/>
            <br />
            <input type="submit" name="submit" value="Sign up"/>		<div id="google_translate_element"></div>

            <script type="text/javascript">
                function googleTranslateElementInit()
                {
                    new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
                }
            </script>

            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        </form>
    </body>
</html>
