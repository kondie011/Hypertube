<?php
    include_once "config/config.php";

    if (isset($_POST['id']))
    {
        $movieId = $_POST['id'];

        $getCommentsQ = "SELECT * FROM `comment` INNER JOIN `user` ON `user`.`username` = `comment`.`user` WHERE `comment`.`movie_id` = ? ORDER BY `time_stamp`";
        $getCommentsR = $conn->prepare($getCommentsQ);
        $getCommentsR->execute([$movieId]);

        while ($item = $getCommentsR->fetch())
        {
            $dp = "https://www.shareicon.net/download/2016/11/09/851666_user_512x512.png";
            if (file_exists($item['p_pic_path']) || $item['p_pic_path'] != "")
            {
                $dp = $item['p_pic_path'];
            }
            echo "<div style='background-color: darkgrey; padding: 5px; border-radius: 5px; color: white; font-family: fantasy; margin: 5px;'>
                    <a href='userprofile.php?visited=".$item['user']."'>
                        <div style='background-color: white; width: 46px; height: 46px; border-radius: 10%; align-items: center; display: inline-flex; text-align: center;'>
                            <img title=".$item['user']." src='".$dp."' style='width: 40px; cursor: pointer; margin-left: 3px;'>
                        </div>
                    </a>
                    <p style='display: inline;'>".$item['txt']."</p>
                  </div>";
        }
    }
?>