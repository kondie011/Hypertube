<?php

    include_once "config/config.php";

    $getAllMoviesQ = "SELECT * FROM `movie`";
    $getLastWatchedQ = "SELECT * FROM `watch_history` WHERE `movie_name` = ? ORDER BY `time_stamp` DESC";
    $getCurrentTimestampQ = "SELECT CURRENT_TIMESTAMP";

    $getAllMoviesR = $conn->prepare($getAllMoviesQ);
    $getAllMoviesR->execute();
    while ($movie = $getAllMoviesR->fetch())
    {
        $getCurrentTimestampR = $conn->query($getCurrentTimestampQ);
        $timestamp_now = new DateTime($getCurrentTimestampR->fetch()['CURRENT_TIMESTAMP']);

        $getLastWatchedR = $conn->prepare($getLastWatchedQ);
        $getLastWatchedR->execute([$movie['movie_name']]);
        $timestamp_last = new DateTime($getLastWatchedR->fetch()["time_stamp"]);

        $diff = $timestamp_last->diff($timestamp_now);
        if ($diff->format('%m') >= 1)
        {
            $deleteMovieQ = "DELETE FROM `movie` WHERE `movie_name` = ?";
            $deleteMovieR = $conn->prepare($deleteMovieQ);
            $deleteMovieR->execute([$movie['movie_name']]);
            if (file_exists("movies/".$movie['movie_hash'].".mp4"))
            {
                unlink("movies/".$movie['movie_hash'].".mp4");
            }
            else if (file_exists("movies/".$movie['movie_hash'].".mkv"))
            {
                unlink("movies/".$movie['movie_hash'].".mkv");
            }
        }
    }

?>