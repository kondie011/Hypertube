<?php

    include_once "config/config.php";

    $search = "";
    $genre = "";
    $sort = "";
    $order = "";
    $page_number = "1";
    if (isset($_GET["genre"]))
    {
        $genre = $_GET["genre"];
    }
    if (isset($_GET["sort"]))
    {
        $sort = $_GET["sort"];
    }
    if (isset($_GET["order"]))
    {
        $order = $_GET["order"];
    }
    if (isset($_GET["page_number"]))
    {
        $page_number = $_GET["page_number"];
    }
    if (isset($_GET["search_text"]))
    {
        $search = $_GET["search_text"];
        getMovies("GET", $conn, "https://yts.am/api/v2/list_movies.json", array("with_images" => "true", "query_term" => $search, "genre" => $genre, "sort_by" => $sort, "order_by" => $order, "page" => $page_number));
    }

    function getMovies($method, $conn, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }
        // Optional Authentication:
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        $decoded_result = json_decode($result);
        $total_movies = $decoded_result->data->movie_count;
        $movies = $decoded_result->data->movies;

        foreach ($movies as $movie)
        {
            if ($movie->medium_cover_image)
            {
                $image = $movie->medium_cover_image;
            }
            else if ($movie->large_cover_image)
            {
                $image = $movie->large_cover_image;
            }
            else if ($movie->background_image_original)
            {
                $image = $movie->background_image_original;
            }
            else if ($movie->background_image)
            {
                $image = $movie->background_image;
            }
            else
            {
                $image = $movie->small_cover_image;
            }
            
            //$movie->torrents[0]->url
            if ($data['origin'])
            {
                
                echo "<img style='position: absolute; margin-left: 10%; left: 0px; margin-right: 10%; width: 80%; z-index: -1; border-radius: 10px;' src=".$movie->background_image.">";
                echo "<h2 id='movie_name' style='color: white; font-family: fantasy; color: aqua;'>".$movie->title_long."</h2>
                      <p id='movie_id' style='display: none;'>".$movie->id."</p>
                      <div style='margin-left: 10%; margin-right: 10%;'>";

                if (is_url_exist($image))
                {
                      echo "</div>
                                <img src=".$image." style='height: 350px;'><br>";
                }
                else
                {
                    echo "</div>
                            <img src='images/image_not_found.jpg' style='height: 350px;'><br>";
                }

                echo "<span style='color: royalblue; font-family: fantasy;'>Genres: </span>";

                for ($c=0; $movie->genres[$c]; $c++)
                {
                    echo "<p style='display: inline; font-family: cursive;'>".$movie->genres[$c]."";
                    if ($movie->genres[$c + 1])
                    {
                        echo ",";
                    }
                    echo " </p>";
                }
                echo     "<p style='display: inline; font-family: cursive;'><span style='color: royalblue; font-family: fantasy;'>Year: </span>".$movie->year." </p>";
                echo     "<p style='display: inline; font-family: cursive;'><span style='color: royalblue; font-family: fantasy;'>Rating: </span>".$movie->rating."/10 </p>";
                echo     "<p style='display: inline; font-family: cursive;'><span style='color: royalblue; font-family: fantasy;'>Runtime: </span>".$movie->runtime." minutes </p>";
                echo     "<p style='display: inline; font-family: cursive;'><span style='color: royalblue; font-family: fantasy;'>Language: </span>".$movie->language." </p>";
                echo     "<p style='display: inline; font-family: cursive;'><span style='color: royalblue; font-family: fantasy;'>Age-rating: </span>".$movie->mpa_rating." </p>";
                echo     "<p style='display: inline; font-family: cursive;'><span style='color: royalblue; font-family: fantasy;'>Seeds: </span>".$movie->torrents[0]->seeds." </p>";
                echo     "<p style='display: inline; font-family: cursive;'><span style='color: royalblue; font-family: fantasy;'>Peers: </span>".$movie->torrents[0]->peers." </p><br>";
                
                getMoviesDetails("GET", $conn, "http://www.omdbapi.com", array("i" => $_GET['imdb_code'], "plot" => "full", "apikey" => "9fea292"));
            
                echo     "<p style='color: white; padding-left: 20%; padding-right: 20%;'>".$movie->description_full."</p><div>";

                if ($movie->torrents[0]->seeds != 0)
                {
                    for ($c=0; $movie->torrents[$c]; $c++)
                    {
                        if ($movie->torrents[$c]->quality == "720p")
                        {
                            $hash = $movie->torrents[$c]->hash;
                            break;
                        }
                    }
                    echo    "<p id='imdbid' style='display: none;'>".$movie->imdb_code."</p>";
                    echo    "<img onclick=playMovie('".$hash."') src='https://s3.amazonaws.com/peoplepng/wp-content/uploads/2018/05/27152606/YouTube-Play-Button-PNG-Photos-1024x766.png' style='width: 40%; margin-top: 10%; cursor: pointer;'>";
                }
                else
                {
                    echo    "<h1 style='font-family: fantasy; color: crimson;'>This movie is not available for streaming</h1>";
                    echo    "<img src='images/image_not_found.jpg' style='width: 40%; cursor: pointer;'>";
                }
                echo "<br><input onclick=showComments('".$movie->id."') value='Comments' type='button'>";
                echo "</div>";
                break;
            }
            else
            {
                include_once "getUsername.php";

                $checkWatchHistoryQ = "SELECT * FROM `watch_history` WHERE `user` = ? AND `movie_id` = ?";
                $checkWatchHistoryR = $conn->prepare($checkWatchHistoryQ);
                $checkWatchHistoryR->execute([$user, $movie->id]);
                $count = $checkWatchHistoryR->rowCount();

                echo    "<a href='movieDetails.php?imdb_code=".$movie->imdb_code."'>
                            <div class='thumbnail'>
                                <p>".$movie->title_long."</p>
                                <p>Rating: ".$movie->rating."/10</p>";
                
                if (is_url_exist($image))
                {
                    echo            "<img style='width: 100%;' src='".$image."'>";
                }
                else
                {
                    echo            "<img style='width: 100%;' src='images/image_not_found.jpg'>";
                }
                
                if ($count > 0)
                {
                    echo        "<p>Watched</p>
                            </div>
                        </a>";
                }
                else
                {
                    echo        "<p>Not yet watched</p>
                            </div>
                        </a>";
                }
            }
        }
        if ($decoded_result->data->page_number != 1 || isset($_GET["search_text"]))
        {
            echo "_____".($decoded_result->data->page_number + 1);
        }
        curl_close($curl);

        return $result;
    }

    function getMoviesDetails($method, $conn, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }
        // Optional Authentication:
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        $decoded_result = json_decode($result);
        //$total_movies = $decoded_result->data->movie_count;
        //$movies = $decoded_result->data->movies;

        echo    "<p style='display: inline; font-family: cursive;'><span style='color: royalblue; font-family: fantasy;'>Actors: </span>".$decoded_result->Actors." </p><br>
                <p style='display: inline; font-family: cursive;'><span style='color: royalblue; font-family: fantasy;'>Director: </span>".$decoded_result->Director." </p><br>
                <p style='display: inline; font-family: cursive;'><span style='color: royalblue; font-family: fantasy;'>Writer: </span>".$decoded_result->Writer." </p>";
        
        /*if ($decoded_result->data->page_number != 1)
        {
            echo "_____".($decoded_result->data->page_number + 1);
        }*/
        curl_close($curl);

        return $result;
    }

    function is_url_exist($url)
    {
        /*$headers=get_headers($url);
        return stripos($headers[0],"200 OK")?true:false;*/
       return true;
    }

?>