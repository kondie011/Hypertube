<?php

	include_once "config/config.php";
	include_once "checkMyMovies.php";

	if (isset($_GET['login']) && isset($_GET['passwd']) && isset($_GET['email']) && isset($_GET['f_name']) && isset($_GET['l_name']))
    {
        $login = $_GET['login'];
        $passwd = $_GET['passwd'];
        $email = $_GET['email'];
        $l_name = $_GET['l_name'];
        $f_name = $_GET['f_name'];
        $findUserQuery = "SELECT * FROM `user` WHERE `username` = ?";
        $findUserResult = $conn->prepare($findUserQuery);
        $findUserResult->execute([$login]);
        if ($findUserResult->rowCount())
        {
            echo "<script>alert('Username already exists');</script>";
        }
        else
        {
        	$addUserQuery = "INSERT INTO `user`(`username`, `password`, `email`, `l_name`, `f_name`) VALUES(?, ?, ?, ?, ?)";
            $addUserResult = $conn->prepare($addUserQuery);
            $addUserResult->execute([$login, $passwd, $email, $l_name, $f_name]);
            $conn->query("COMMIT");
            $_SESSION['login'] = $login;
			$_SESSION['passwd'] = $passwd;
			$_SESSION['user'] = "hypertube";			
        }
    }
    else if ($_GET['sp'] == "Sign up")
    {
        ob_start();
        header("Location: signUp.php");
        ob_end_flush();
        die();
    }
    
	include_once "checkLogin.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<script src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
		<meta name="google-signin-client_id" content="805055211006-l4su8hfp8mrcasp3lf6pvbeo6j1hvn6d.apps.googleusercontent.com">
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		<title>Hypertube</title>
		<style>
			body
			{
				background-color: rgba(0, 0, 0, 0.8);
				text-align: center;
				margin: 0;
				height: 1000px;
			}
			#header
			{
				position: relative;
				top: 0px;
				left: 0px;
				background-color: black;
				width: 100%;
				padding: 10px;
				box-shadow: 0px 3px 16px 0px rgba(0, 0, 0, 0.7 );
				display: inline-grid;
  				grid-template-columns: auto auto auto;
				text-align: center;
				z-index: 1;
			}
			.web_icon
			{
				width: 50px;
				display: inline;
			}
			.user_icon
			{
				width: 50px;
				display: inline;
			}
			.header_item
			{
				text-align: center;
			}
			#web_name
			{
				font-style: bold;
				color: white;
				font-family: monospace;
				font-size: 18px;
			}
			#main
			{
				position: relative;
                display: grid;
                grid-template-columns: 400px auto;
				text-align: center;
				margin-top: 10px;
				width: 100%;
				grid-gap: 10px;
				min-height: -webkit-fill-available;
                min-height: 100%;
			}
			#results
			{
				position: relative;
                display: grid;
                grid-template-columns: auto auto auto auto;
				grid-gap: 10px;
				text-align: center;
				max-width: 1000px;
				overflow: auto;
    			/* height: 800px; */
				padding: 10px;
				background-color: aliceblue;
				border-radius: 5px;
				min-width: 300px;
				margin-right: 20px;
			}
			.post_container
			{
				background-color: white;
				border-radius: 5px;
				border: 0.5px solid gray;
				padding: 2px;
				width: 600px;
				text-align: center;
				margin-top: 10px;
				display: inline-block;
				box-shadow: 0px 8px 16px 0px grey;
			}
			.post_header
			{
				background-color: #DCDCDC;
				margin: 5px;
				border-radius: 5px;
				display: grid;
  				grid-template-columns: 0px auto 25px;
			}
			.poster_dp
			{
				width: 30px;
				margin: 10px;
				display: inline;
			}
			.poster_name
			{
				display: inline;
				font-style: bold;
			}
			.image_container
			{
				background-color: #DCDCDC;
				border-radius: 5px;
				text-align: center;
				display: inline-block;
				padding: 0px;
				width: 100%;
			}
			.post_image
			{
				width: 100%;
			}
			.comment_box
			{
				width: 400px;
				height: 50px;
				border-radius: 5px;
				border: 2px solid #1E90FF;
				color: black;
			}
			.like_post
			{
				width: 50px;
			}
			.like_post:hover
			{
				cursor: pointer;
			}
			.comment_container
			{
				display: inline-grid;
				text-align: top;
  				grid-template-columns: auto auto auto;
			}
			.post_comment
			{
				width: 50px;
				display: inline;
				border-radius: 100%;
				border: 1px solid #00FA9A;
				margin-left: 10px;
			}
			.post_comment:hover
			{
				cursor: pointer;
			}
			#main_dropdown
			{
				position: fixed;
				bottom: 85px;
				right: 25px;
			}
			#post_pic
			{
				width: 40px;
				border-radius: 100%;
				background-color: white;
				padding: 10px;
				border: 2px solid #4169E1;
			}
			#main_dropdown:hover #main_dropdown_items
			{
				display: block;
			}
			#main_dropdown_items
			{
				display: none;
				position: absolute;
				background-color: #f9f9f9;
				box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
				padding: 12px 16px;
				z-index: 1;
				bottom: 40px;
				right: 40px;
				min-width: 160px;
			}
			#main_dropdown_items p
			{
				background-color: #00008B;
				border-radius: 5px;
				color: white;
				padding: 15px;
				box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			}
			#likes_dropdown
			{
				display: none;
				position: fixed;
				z-index: 1;
				padding-top: 100px;
				left: 0;
				top: 0;
				width: 100%;
				height: 100%;
				overflow: auto;
				background-color: rgb(0,0,0);
				background-color: rgba(0,0,0,0.4);
			}
			#likes_dropdown_items
			{
				background-color: #fefefe;
				margin: auto;
				padding: 20px;
				border: 1px solid #888;
				width: 80%;
				box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			}
			#likes_dropdown_items p
			{
				margin: 5px;
			}
			#close
			{
				color: #aaaaaa;
				float: right;
				font-size: 28px;
				margin-right: 9.5%;
				font-weight: bold;
			}
			.delete
			{
				color: #DD0000;
				font-size: 28px;
				font-weight: bold;
			}
			.delete:hover,
			.delete:focus {
				color: red;
				text-decoration: none;
				cursor: pointer;
			}
			#close:hover,
			#close:focus {
				color: #000;
				text-decoration: none;
				cursor: pointer;
			}
			.likes
			{
				cursor: pointer;
				display: inline;
				margin-right: 10px;
				color: grey;
			}
			.comments
			{
				cursor: pointer;
				display: inline;
				color: grey;
			}
			#snackbar
			{
				visibility: hidden;
				min-width: 250px;
				margin-left: -125px;
				background-color: #333;
				color: #fff;
				text-align: center;
				border-radius: 5px;
				padding: 16px;
				position: fixed;
				z-index: 1;
				left: 50%;
				bottom: 30px;
			}

			#snackbar.show
			{
				visibility: visible;
			}
			#pages
			{
				display: inline-block;
				margin-top: 10px;
			}
			#pages a
			{
				color: black;
				float: left;
				padding: 8px 16px;
				text-decoration: none;
			}
            #footer
            {
				position: relative;
				background-color: black;
				display: inline-block;
				bottom: -5px;
				width: 100%;
				color: white;
            }
            #cr
            {
                display: inline;
                float: right;
                margin-right: 10px;
            }
            #f_msg
            {
                display: inline;
                float: left;
                margin-left: 10px;
            }
			#about
			{
				color: white;
				font-family: monospace;
				text-align: center;
				font-size: 15px;
				margin-right: 5%;
				margin-left: 5%; 
			}
			.button_style
			{
				padding: 10px;
				border: 2px solid green;
				border-radius: 5px;
				font-style: bold;
				background-color: black;
				color: white;
				box-shadow: 0px 2px 10px 0px red;
				cursor: pointer;
			}
			.button_style2
			{
				background: darkgrey;
				padding: 5px;
				border-radius: 5px;
				color: white;
				font-family: sans-serif;
				font-size: 15px;
				cursor: pointer;
				margin: 5px;
			}
			.button_style2:hover
			{
				background: darkslategrey;
				font-size: 16px;
				box-shadow: 1px 1px 25px 2px black;
				cursor: pointer;
				margin: 3px;
			}
			.h3_style
			{
				color: grey;
    			font-family: fantasy;
			}
			#tools
			{
				text-align: center;
				max-width: 400px;
			}
			#search_area
			{
				background-color: darkcyan;
				padding: 5px;
				margin: 10px;
				border-radius: 5px;
				box-shadow: 1px 1px 15px 1px black;
			}
			.thumbnail
			{
				width: 99.8%;
				display: inline-grid;
				cursor: pointer;
				margin: 2px;
				background-color: darkgrey;
				color: darkslateblue;
				border-radius: 5px;
				font-size: 10px;
			}
			a
			{
				text-decoration: none;
			}
			.thumbnail:hover
			{
				width: 100%;
				display: inline-grid;
				cursor: pointer;
				box-shadow: 1px 1px 15px 1px black;
				margin: 0px;
			}
		</style>
	</head>
	<body>
		<div id="header">
			<a href="index.php"><img class="web_icon" src="http://www.iconarchive.com/download/i99782/designbolts/free-multimedia/Film.ico"></a>
			<div class="header_item">
                <?php
                    include_once "getHeaderName.php";
                ?>
			</div>
			<div class="header_item">
			
				<?php
					session_start();

					if ($_SESSION['user'] == "google")
					{
						echo '<a href="userProfile.php"><img class="user_icon" id="profile" src="'.$_SESSION['g_image_url'].'"></a>';
					}
					else if ($_SESSION['user'] == "42")
					{
						echo '<a href="userProfile.php"><img class="user_icon" id="profile" src="'.$_SESSION['w_image_url'].'"></a>';
					}
					else
					{
						echo '<a href="userProfile.php"><img class="user_icon" id="profile" src="https://www.shareicon.net/download/2016/11/09/851666_user_512x512.png"></a>';
					}
				?>

				<div class="header_item" style="display: inline; width: 30px;" ng-app="hypertube" ng-controller="hypertube_con">
					<img class="user_icon" onclick="logOut()" src="https://www.freeiconspng.com/uploads/shutdown-icon-28.png">
				</div>
			</div>
		</div>
		<div id="main">

			<div id="tools">

                <input id='page_number' type='number' value='2' style='display: none;'>
                <input id='last_max' type='number' value='0' style='display: none;'>
				<div id="search_area">
					<input type="text" id="search_box" style="width: 250px; height: 30px; border-radius: 5px; border: 1px solid white;" placeholder="Search...">
					<img class="user_icon" id="search_button" onclick="search('search')" style="display: inline; width: 30px; border-radius: 4px; margin-left: 10px; cursor: pointer;" src="https://3vs.co/wp-content/uploads/2017/01/search-icon-png-31.png">
				</div>
				<div class="h3_style" id="genres">
					<h3 id="genre_header">Genre:</h3>
					<input class="button_style2" type="button" id="action" value="Action" onclick="selectIt('action')">
					<input class="button_style2" type="button" id="comedy" value="Comedy" onclick="selectIt('comedy')">
					<input class="button_style2" type="button" id="romance" value="Romance" onclick="selectIt('romance')">
					<input class="button_style2" type="button" id="horror" value="Horror" onclick="selectIt('horror')">
					<input class="button_style2" type="button" id="adventure" value="Adventure" onclick="selectIt('adventure')">
					<input id="chosen_genre" value="" style="display: none;">
				</div>
				<div class="h3_style" id="sort">
					<h3 id="sort_header">Sort by:</h3>
					<input class="button_style2" type="button" id="title" value="Title" onclick="selectIt2('title')">
					<input class="button_style2" type="button" id="year" value="Year" onclick="selectIt2('year')">
					<input class="button_style2" type="button" id="rating" value="Rating" onclick="selectIt2('rating')">
					<input class="button_style2" type="button" id="like_count" value="Number of likes" onclick="selectIt2('like_count')">
					<input class="button_style2" type="button" id="date_added" value="Date added" onclick="selectIt2('date_added')">
					<input class="button_style2" type="button" id="download_count" value="Number of downloads" onclick="selectIt2('download_count')">
					<input class="button_style2" type="button" id="seeds" value="Seeds" onclick="selectIt2('seeds')">
					<input class="button_style2" type="button" id="peers" value="Peers" onclick="selectIt2('peers')">
					<br>
					<select name="order" id="order" onchange="search('search')">
						<option value="Descending" id="desc">Descending</option>
						<option value="Ascending" id="asc">Ascending</option>
					</select>
					<input id="chosen_sort" value="" style="display: none;">
				</div>

				<div id="google_translate_element"></div>

				<script type="text/javascript">
					function googleTranslateElementInit()
					{
						new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
					}
				</script>

				<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

			</div>

			<div id="results">
				<?php
					include "api.php";
					getMovies("GET", $conn, "https://yts.am/api/v2/list_movies.json", array("with_images" => "true", "query_term" => "", "genre" => "", "sort_by" => "like_count", "order_by" => "desc"));
				?>
			</div>

		</div>

		<div id="snackbar"></div>
		<div style="display: none;" class="g-signin2" data-onsuccess="onSignIn"></div>

		<script type="text/javascript">

			var search_in = document.getElementById("search_box");
			search_in.addEventListener("keyup", function (event)
			{
				event.preventDefault();
				if (event.keyCode == 13)
				{
					document.getElementById("page_number").value = "1";
					document.getElementById("search_button").click();
				}
			});

			function onSignIn(googleUser)
			{
				var profile = googleUser.getBasicProfile();
				console.log('ID: ' + profile.getId());
				console.log('Name: ' + profile.getName());
				console.log('Image URL: ' + profile.getImageUrl());
				console.log('Email: ' + profile.getEmail());
			}

           	var app = angular.module('hypertube', []);
			app.controller('hypertube_con', function($scope, $http)
			{
				$scope.checkLoginState = function ()
				{
					FB.getLoginStatus(function(response)
					{
						statusChangeCallback(response);
					});
				};
			});

			function logOut()
			{
				var auth2 = gapi.auth2.getAuthInstance();
				auth2.signOut().then(function ()
				{
					console.log('User signed out.');
				});
				$.ajax({url:"logout.php", success: function(result)
				{
					location.reload();
				}})
			}

			function selectIt(txt)
			{
				var chosen_genre = document.getElementById("chosen_genre");
				var genre_header = document.getElementById("genre_header");
				document.getElementById("page_number").value = "1";

				if (txt == chosen_genre.value)
				{
					chosen_genre.value = "";
				}
				else
				{
					chosen_genre.value = txt;
				}
				
				genre_header.innerHTML = "Genre: " + chosen_genre.value;
			
				search('genre');
			}

			function selectIt2(txt)
			{
				var chosen_sort = document.getElementById("chosen_sort");
				var sort_header = document.getElementById("sort_header");
				document.getElementById("page_number").value = "1";

				if (txt == chosen_sort.value)
				{
					chosen_sort.value = "";
				}
				else
				{
					chosen_sort.value = txt;
				}
				sort_header.innerHTML = "Sort by: " + chosen_sort.value;

				search('sort');
			}

			$(window).scroll(function()
				{
					var scroll = (window.innerHeight + window.scrollY);
					var max = document.getElementById("main").offsetHeight;
					if (scroll >= max && max > document.getElementById("last_max").value && document.getElementById("results").innerHTML.length > 0)
					{
						document.getElementById("last_max").value = max;
						showSnackbar("Loading...");
						search('scroll');
					}
                });

            function search(origin)
            {
				var searchTxt = document.getElementById("search_box").value;
				var genre = document.getElementById("chosen_genre").value;
				var sort = document.getElementById("chosen_sort").value;
				var order = document.getElementById("order").value;
				var list = document.getElementById("results");
				var next_page = document.getElementById("page_number").value;

				if (order == "Ascending")
				{
					order = "asc";
				}
				else
				{
					order = "desc";
				}
				$.ajax({method: "GET", url: "api.php", data: {"search_text": searchTxt, "genre": genre, "sort": sort, "order": order, "page_number": next_page}, success: function(result)
				{
					if (origin == "search" || origin == "sort" || origin == "genre")
					{
						document.getElementById("last_max").value = "0";
						document.getElementById("page_number").value = "1";
						document.getElementById("results").innerHTML = "";	
					}
				
					list.innerHTML += result.split("_____")[0];
					document.getElementById("page_number").value = result.split("_____")[1];
				}});
            }

			function showSnackbar(message)
            {
				var snackbar = document.getElementById("snackbar");
				snackbar.innerHTML = message;
				snackbar.className = "show";
				setTimeout(function()
				{
					snackbar.className = "";
				}, 3000);
			}

	   </script>

		<div id="footer">
        	<p id="f_msg">This website is proundly provided to you by Nedzingahe Kondelelani</p>
        	<p id="cr">knedzing©2018</p>
    	</div>
		
	</body>
</html>
