<?php

    include_once "config/config.php";

    if (isset($_GET['id']) && isset($_GET['image_url']) && isset($_GET['name']) && isset($_GET['fname']) && isset($_GET['lname']))
    {
        $id = $_GET['id'];
        $email = $_GET['name']."@student.wethinkcode.co.za";
        $image_url = $_GET['image_url'];
        $name = $_GET['name']."_".$id;
        $f_name = $_GET['fname'];
        $l_name = $_GET['lname'];
        $passwd = "";


        $findUserQuery = "SELECT * FROM `user` WHERE `email` = ? AND `username` = ?";
        $findUserResult = $conn->prepare($findUserQuery);
        $findUserResult->execute([$email, $name]);

        if ($findUserResult->rowCount() == 0)
        {
            echo "here we codesss";
        	$addUserQuery = "INSERT INTO `user`(`username`, `password`, `email`, `l_name`, `f_name`, `p_pic_path`) VALUES(?, ?, ?, ?, ?, ?)";
            $addUserResult = $conn->prepare($addUserQuery);
            $addUserResult->execute([$name, $passwd, $email, $l_name, $f_name, $image_url]);
            $conn->query("COMMIT");
        }

        $_SESSION['w_id'] = $id;
        $_SESSION['w_email'] = $email;
        $_SESSION['w_name'] = $name;
        $_SESSION['w_image_url'] = $image_url;
        $_SESSION['user'] = "42";
        header("Location: index.php");
    }
?>
<html>
  <head>
    <title>Video stream sample</title>
  </head>
  <body>
    Loading...
  </body>
</html>