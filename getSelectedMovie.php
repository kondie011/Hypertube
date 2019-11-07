<?php
    if (isset($_GET['imdb_code']))
    {
        include "api.php";
        
        $imdb_code = $_GET['imdb_code']; 

        getMovies("GET", $conn, "https://yts.am/api/v2/list_movies.json", array("query_term" => $imdb_code, "origin" => "details"));            
    }
?>