<?php
	include_once "config/config.php";

    if (isset($_POST['login']) && isset($_POST['passwd']) && isset($_POST['submit']) && $_POST['submit'] == "Login")
    {
		$login = $_POST['login'];
		$passwd = hash('whirlpool',$_POST['passwd']);
		$findUserQuery = "SELECT * FROM `user` WHERE `username` = ? AND `password` = ?";
		$findUserResult = $conn->prepare($findUserQuery);
		$findUserResult->execute([$login, $passwd]);
		if ($findUserResult->rowCount() && $user = $findUserResult->fetch())
		{
			$_SESSION['login'] = $_POST['login'];
			$_SESSION['passwd'] = $passwd;
			$_SESSION['user'] = "hypertube";
			ob_start();
			header('Location: index.php');
    		ob_end_flush();
			die();
		}
		else
		{
			header("Location: login.php");
			echo "<script>alert('Something went wrong');</script>";
		}
	}
	else if ($_POST['sp'] == "Sign up")
	{
		ob_start();
        header("Location: signUp.php");
        ob_end_flush();
        die();
	}
?>