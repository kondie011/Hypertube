<?php
    include_once "config/config.php";
    include_once "getUsername.php";

    if (isset($_POST['movieId']) && isset($_POST['comment']))
    {
        $movieId = $_POST['movieId'];
        $comment = $_POST['comment'];

        $sendCommentQ = "INSERT INTO `comment`(`user`, `txt`, `movie_id`) VALUES(?, ?, ?)";
        $sendCommentR = $conn->prepare($sendCommentQ);
        $sendCommentR->execute([$user, $comment, $movieId]);
        if ($sendCommentR->rowCount() > 0)
        {
            echo "<p>Your comment: ".$comment."</p><br>";
        }
    }
?>