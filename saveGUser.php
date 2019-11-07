<?php

    include_once "config/config.php";

    if (isset($_POST['id']) && isset($_POST['email']) && isset($_POST['image_url']) && isset($_POST['name']) && isset($_POST['fname']) && isset($_POST['lname']))
    {
        $id = $_POST['id'];
        $email = $_POST['email'];
        $image_url = $_POST['image_url'];
        $name = $_POST['name']."_".$id;
        $f_name = $_POST['fname'];
        $l_name = $_POST['lname'];
        $passwd = "";

        $findUserQuery = "SELECT * FROM `user` WHERE `username` = ?";
        $findUserResult = $conn->prepare($findUserQuery);
        $findUserResult->execute([$name]);

        if ($findUserResult->rowCount() == 0)
        {
        	$addUserQuery = "INSERT INTO `user`(`username`, `password`, `email`, `l_name`, `f_name`, `p_pic_path`) VALUES(?, ?, ?, ?, ?, ?)";
            $addUserResult = $conn->prepare($addUserQuery);
            $addUserResult->execute([$name, $passwd, $email, $l_name, $f_name, $image_url]);
            $conn->query("COMMIT");
        }

        $_SESSION['g_id'] = $id;
        $_SESSION['g_email'] = $email;
        $_SESSION['g_name'] = $name;
        $_SESSION['g_image_url'] = $image_url;
        $_SESSION['user'] = "google";
    }
?>