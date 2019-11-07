<?php
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
				min-height: 1000px;
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
				text-align: center;
                margin-top: 10px;
                width: 80%;
                margin-left: 10%;
                margin-right: 10%;
				grid-gap: 10px;
				min-height: -webkit-fill-available;
                min-height: 100%;
                color: white;
                background-color: rgba(0, 0, 0, 0.4);
                padding: 20px;
                border-radius: 10px;
			}
			#results
			{
				position: relative;
                display: grid;
                grid-template-columns: auto auto auto auto;
				grid-gap: 10px;
				text-align: center;
				max-width: 800px;
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
			#tools
			{
				text-align: center;
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
				border-radius: 5px;
				color: black;
				max-height: 80%;
    			overflow: auto;
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

            <?php
                include_once "getSelectedMovie.php";
			?>
			
			<div id="likes_dropdown">
				<span id="close">&times;</span>
				<div id="likes_dropdown_items"></div>
				<div id="comment_box">
					<input type="text" placeholder="Comment here..." id="comment">
					<input type="button" id="post_comment" value='Comment' onclick="sendComment()">
				</div>
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

		<div id="snackbar"></div>
        <div style="display: none;" class="g-signin2" data-onsuccess="onSignIn"></div>

		<script type="text/javascript">
		
			/*function updateLoc()
			{
				if (navigator.geolocation)
				{
					navigator.geolocation.getCurrentPosition(function(position)
					{
						var lat = position.coords.latitude;
						var lng = position.coords.longitude;
						$.ajax({url: "updateLoc.php", method: "POST", data: {"lat":lat, "lng":lng}, success: function(result)
						{
							//showSnackbar(result);
						}})
					});
				}
			}*/

			function sendComment()
			{
				var movieId = document.getElementById("movie_id").innerHTML;
				var comment = document.getElementById("comment");
				var list = document.getElementById("likes_dropdown_items");

				$.ajax({url:"sendComment.php", method: "POST", data: {"movieId":movieId, "comment":comment.value}, success: function(result)
				{
					comment.value = "";
					list.innerHTML += result;
				}})
			}

			function showComments(id)
			{
				var modal = document.getElementById('likes_dropdown');
				var list = document.getElementById("likes_dropdown_items");
				var span = document.getElementById("close");

				span.onclick = function() {
					modal.style.display = "none";
					list.innerHTML = "";
				}

				window.onclick = function(event) {
					if (event.target == modal) {
						modal.style.display = "none";
						list.innerHTML = "";
					}
				}

				$.ajax({url:"getComments.php", method: "POST", data: {"id":id}, success: function(result)
				{
					if (result == "")
					{
						result = "There are no comments to show";
					}
					modal.style.display = "block";
					list.innerHTML = result;
				}})
			}


			function onSignIn(googleUser)
			{
				var profile = googleUser.getBasicProfile();
				console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
				console.log('Name: ' + profile.getName());
				console.log('Image URL: ' + profile.getImageUrl());
				console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
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

			function playMovie(hash)
			{
				var movieId = document.getElementById("movie_id").innerHTML;
				var movieName = document.getElementById("movie_name").innerHTML;
				var imdbid = document.getElementById("imdbid").innerHTML;
				
				$.ajax({method: "POST", url: "addToWatchHistory.php", data: {"movieId": movieId, "movieName": movieName, "movieHash":hash}, success: function(result)
				{
					//alert(result);
				}});
				
				window.open("http://localhost:3000?hash=" + hash + "&imdbid=" + imdbid);
				
			}

			function search()
			{
				var searchTxt = document.getElementById("search_box").value;
				var list = document.getElementById("results");

				$.ajax({method: "POST", url: "api.php", data: {"search_text": searchTxt}, success: function(result)
				{
					list.innerHTML = result;
				}});
			}

			updateInfo();
			function updateInfo() {
				/*setTimeout(function()
				{
					updateLoc();
					$.ajax({url: "updateInfo.php", success: function(result)
					{
						if (result == "msg" || result == "msgnotif")
						{
							var chatElem = document.getElementById("chat");
							chatElem.style.background = "orangered";
						}
						if (result == "notif" || result == "msgnotif")
						{
							var notifElem = document.getElementById("alert");
							notifElem.style.background = "green";
						}
						updateInfo();
					}})
				}, 3000);*/
			}

			function logOut()
			{
				$.ajax({url:"logout.php", success: function(result)
				{
					location.reload();
				}})
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
