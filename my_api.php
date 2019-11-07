<?php

    include_once "config/config.php";

    if (isset($_GET["history"]))
    {
        $getWatchHistoryQ = "SELECT * FROM `watch_history`";
        $getWatchHistoryR = $conn->prepare($getWatchHistoryQ);
        $getWatchHistoryR->execute();

        $watchHistory = $getWatchHistoryR->fetchAll();
        echo json_encode($watchHistory);
    }

    if (isset($_GET["comments"]))
    {
        $getComQ = "SELECT * FROM `comment`";
        $getComR = $conn->prepare($getComQ);
        $getComR->execute();

        $com = $getComR->fetchAll();
        echo json_encode($com);
    }

?>