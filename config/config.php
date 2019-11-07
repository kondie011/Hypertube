<?php
	include_once 'Install.class.php';
	include_once "database.php";

	session_start();
	$obj = new Config();
	if (!($conn = $obj->connect()))
	{
		$createDbQuery = "CREATE DATABASE IF NOT EXISTS `$dbname`";
		
		try {
			$dbh = new PDO("mysql:host=$servername", $username, $password);
			$dbh->exec($createDbQuery) or die("something went wrong");

			$conn = $obj->connect();
			$conn->exec("CREATE TABLE IF NOT EXISTS `user`(`id` INT(200) NOT NULL AUTO_INCREMENT, `username` varchar(255) not null,`f_name` varchar(50) not null,`l_name` varchar(50) not null, `password` varchar(255) not null, `email` varchar(50), `gender` varchar(50), `bio` varchar(500), `p_pic_path` varchar(200), PRIMARY KEY (`id`))");
			$conn->exec("CREATE TABLE IF NOT EXISTS `watch_history`(`user` VARCHAR(255) NOT NULL, `movie_name` VARCHAR(255) NOT NULL, `movie_id` VARCHAR(255) NOT NULL, `time_stamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
			$conn->exec("CREATE TABLE IF NOT EXISTS `comment`(`user` VARCHAR(255) NOT NULL, `txt` VARCHAR(500) NOT NULL, `movie_id` VARCHAR(255) NOT NULL, `time_stamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
			$conn->exec("CREATE TABLE IF NOT EXISTS `movie`(`movie_name` VARCHAR(255) NOT NULL, `movie_hash` VARCHAR(255) NOT NULL, `time_stamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");

			$conn->exec("ALTER DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin");
			$conn->exec("ALTER TABLE `user` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin");
			$conn->exec("ALTER TABLE `watch_history` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin");
			$conn->exec("ALTER TABLE `comment` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin");
			$conn->exec("ALTER TABLE `movie` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin");
			$conn->exec("COMMIT");

		} catch (PDOException $e) {
			die("DB ERROR: ". $e->getMessage());
		}
	}
	
	if(!$conn)
	{
		die("something went wrong".mysqli_connect_error());
	}
?>
