<?php

    include_once "config/config.php";

    if (isset($_POST['movieId']) && isset($_POST['movieName']) && isset($_POST['movieHash']))
    {
        $movieId = $_POST['movieId'];
        $movieName = $_POST['movieName'];
        $movieHash = $_POST['movieHash'];

        include_once "getUsername.php";

        $addWatchHistoryQ = "INSERT INTO `watch_history`(`user`, `movie_name`, `movie_id`) VALUES(?, ?, ?)";
        $checkQ = "SELECT * FROM `movie` WHERE `movie_name` = ?";
        $addWatchHistoryR = $conn->prepare($addWatchHistoryQ);
        $addWatchHistoryR->execute([$user, $movieName, $movieId]);
        $checkR = $conn->prepare($checkQ);
        $checkR->execute([$movieName]);

        if ($checkR->rowCount() == 0)
        {
            $addMovieQ = "INSERT INTO `movie`(`movie_name`, `movie_hash`) VALUES(?, ?)";
            $addMovieR = $conn->prepare($addMovieQ);
            $addMovieR->execute([$movieName, $movieHash]);
        }
        $conn->exec("COMMIT");
    }
?>