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
        <title>User profile</title>
        <style>
            body
            {
                text-align: center;
                background-color: rgba(0, 0, 0, 0.8);
                text-align: center;
                margin: 0;
                min-height: 1000px;
                min-width: 500px;
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
            #main
            {
                position: relative;
                width: 100%;
                /* display: grid;
                grid-template-columns: auto auto; */
				min-height: -webkit-fill-available;
                grid-column-gap: 50px;
            }
            #user_details
            {
                display: inline;
            }
            #user_pics
            {
                width: 100%;
                display: inline-grid;
  				grid-template-columns: auto auto;
                padding: 10px;
                grid-gap: 10px;
				overflow: auto;
                margin-top: 10px;
            }
            .grid_img
            {
                width: 100%;
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
            #edit_profile
            {
                margin-top: 120px;
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
            #footer
            {
				position: relative;
				background-color: black;
				display: inline-block;
				bottom: -5px;
				width: 100%;
				color: white;
            }
            #user_ppic
            {
                width: 300px;
                margin: 10px;
                border-radius: 50px;
                border: 4px solid orangered;
                box-shadow: 2px 2px 15px 0px black;
                /* margin-left: 40px; */
            }
            #change_ppic
            {
                width: 40px;
                box-shadow: 2px 2px 15px 0px black;
                margin-bottom: 10px;
                border-radius: 40px;
            }
            #upload_pics
            {
                width: 100px;
                box-shadow: 2px 2px 15px 0px black;
                margin-bottom: 10px;
                border-radius: 50px;
            }
            #user_ppic:hover
            {
                
            }
            .detail_item
            {
                padding: 10px;
                margin: 5px;
                border: 2px solid royalblue;
                border-radius: 5px;
                color: white;margin-left: 30%;
                margin-right: 30%;
            }
            .detail_item_v
            {
            }
            .detail_item_change
            {
                background-color: white;
            }
			.delete
			{
				color: #DD0000;
				font-size: 28px;
				font-weight: bold;
			}
			.delete:hover,
			.delete:focus
            {
				color: red;
				text-decoration: none;
				cursor: pointer;
			}
            #like_button
            {
                width: 100px;
                cursor: pointer;
                box-shadow: 2px 2px 15px 0px black;
                margin-bottom: 10px;
                border-radius: 100px;
            }
            #view_history
            {
                width: 40px;
                cursor: pointer;
                box-shadow: 2px 2px 15px 0px black;
                margin-bottom: 10px;
                border-radius: 100px;
            }
            #block_user
            {
                width: 100px;
                cursor: pointer;
                box-shadow: 2px 2px 15px 0px black;
                margin-bottom: 10px;
                border-radius: 100px;
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

				<div class="header_item" style="display: inline; width: 30px;">
					<img class="user_icon" onclick="logOut()" src="https://www.freeiconspng.com/uploads/shutdown-icon-28.png">
				</div>
			</div>
		</div>
		
        <div id="edit_profile">
            
            <?php
                include_once "config/config.php";
                include_once "getUsername.php";

                $username = $user;
                if (isset($_GET['visited']))
                {
                    $visited = $_GET['visited'];
                }
                else
                {
                    $visited = $username;
                }
                $ppic = $conn->query("SELECT `p_pic_path` FROM `user` WHERE `username` = '$visited'");

                $getEmailQ = "SELECT `email` FROM `user` WHERE `username` = ?";
                $getEmailR = $conn->prepare($getEmailQ);
                $getEmailR->execute([$visited]);
                $email = ($getEmailR->fetch())['email'];

                $item = $ppic->fetch();
                $path = $item['p_pic_path'];
                
                echo "<p id='email' style='display: none'>$email<p></div>";
                if (file_exists($path) || $path != "")
                {
                    echo    "<img id='user_ppic' src='$path'/>";
                }
                else
                {
                    echo    "<img id='user_ppic' src='https://www.shareicon.net/download/2016/11/09/851666_user_512x512.png'/>";
                }
                if ($visited == $username)
                {
                    echo "<a href='upload_pic.php?from=profile'><img id='change_ppic' src='http://icons-for-free.com/free-icons/png/512/1312548.png'/></a>";
                }
            ?>
        
        <div id="main">
            
            <div id="user_details">
                <h1 style="font-family: cursive; color: white;">User details</h1>

                <?php

                    include_once "config/config.php";

                    if (isset($_GET['visited']))
                    {
                        $user = $_GET['visited'];
                    }
                    else
                    {
                        include_once "getUsername.php";
                    }
                    
                    $getDetailsQ = "SELECT * FROM `user` WHERE `username` = ?";
                    $getDetailsR = $conn->prepare($getDetailsQ);
                    $getDetailsR->execute([$user]);
                    
                    if ($getDetailsR->rowCount() > 0)
                    {
                        $details = $getDetailsR->fetch();
                        if ($visited == $username && $_SESSION['user'] == 'hypertube')
                        {
                            echo "<input class=detail_item_change type='button' name='email' value='Change email' onclick='changeEmail()'/>
                                  <input class=detail_item_change type='button' name='password' value='Change password' onclick='changePassword()'/><br/>";
                        }
                        else
                        {
                            echo "<a href='https://www.facebook.com/search/top/?q=".$details['f_name']." ".$details['l_name']."'><img title='search user on facebook' src='https://www.defietsmaker.nl/wp-content/uploads/2017/06/697057-facebook-512.png' style='width: 40px;'></a>";
                        }
                        echo    "<div class='detail_item'><label class='detail_item_v'>Username: $user</label>";
                        if ($visited == $username)
                        {
                            echo    "<input class='detail_item_change' type='button' name='login' value='Change username' onclick='changeUsername()'/>";
                        }
                        echo    "</div><br/>
                                <div class='detail_item'><label class='detail_item_v'>First name: ".$details['f_name']."</label>";
                        if ($visited == $username)
                        {
                            echo    "<input class='detail_item_change' type='button' name='login' value='Change first name' onclick='changeFName()'/>";
                        }
                        echo    "</div><br/>
                                <div class='detail_item'><label class='detail_item_v'>Last name: ".$details['l_name']."</label>";
                        if ($visited == $username)
                        {
                            echo    "<input class='detail_item_change' type='button' name='login' value='Change last name' onclick='changeLName()'/>";
                        }
                        echo    "</div><br/>
                                <div class='detail_item'><label class='detail_item_v'>Gender: ".$details['gender']."</label>";
                        if ($visited == $username)
                        {
                            echo "<select class='detail_item_change' name='login' id='gender' onchange='changeGender()'>
                                    <option value='male'>Male</option>
                                    <option value='female'>Female</option>
                                </select>";
                        }
                        echo    "</div><br/>
                                <div class='detail_item'><label class='detail_item_v'>Bio: ".$details['bio']."</label>";
                        if ($visited == $username)
                        {
                            echo    "<input class='detail_item_change' type='button' name='login' value='Edit Bio' onclick='changeBio()'/>";
                        }
                        echo    "</div><br/>";
                    }
                ?>

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

		<div id="snackbar"></div>
        <div style="display: none;" class="g-signin2" data-onsuccess="onSignIn"></div>
        
        <script type="text/javascript">

            function search()
            {
                searchTxt = document.getElementById("search_box").value;

                if (searchTxt != "")
                {
                    $(location).attr('href', 'search.php?txt=' + searchTxt);
                }
                else
                {
                    showSnackbar("No text Entered");
                }
            }

            function changeUsername()
            {
                var newUsername = prompt("Please enter your new Username", "kondie_");
                if (newUsername != "" && newUsername != null)
                {
                    $.ajax({url:"changeUsername.php", data: {"newUsername":newUsername}, success: function(result)
                    {
                        showSnackbar(result);
                    }})
                }
                else
                {
                    showSnackbar("No username entered");
                }
            }

            function changeEmail()
            {
                var newEmail = prompt("Please enter your new Email", "knedzing@student.wethinkcode.co.za");
                if (newEmail != "" && newEmail != null)
                {
                    $.ajax({url:"changeEmail.php", data: {"newEmail":newEmail}, success: function(result)
                    {
                        showSnackbar(result);
                    }})
                }
                else
                {
                    showSnackbar("No email entered");
                }
            }

            function changeFName()
            {
                var f_name = prompt("Please enter your new first name", "");
                if (f_name != "" && f_name != null)
                {
                    $.ajax({url:"changeFName.php", data: {"f_name":f_name}, success: function(result)
                    {
                        showSnackbar(result);
                    }})
                }
                else
                {
                    showSnackbar("No first name entered");
                }
            }

            function changeLName()
            {
                var l_name = prompt("Please enter your new last name", "");
                if (l_name != "" && l_name != null)
                {
                    $.ajax({url:"changeLName.php", data: {"l_name":l_name}, success: function(result)
                    {
                        showSnackbar(result);
                    }})
                }
                else
                {
                    showSnackbar("No last name entered");
                }
            }

            function changeGender()
            {
                var genderElem = document.getElementById('gender');
                var gender = genderElem.options[genderElem.selectedIndex].value;
                if (gender != "" && gender != null)
                {
                    $.ajax({url:"changeGender.php", data: {"gender":gender}, success: function(result)
                    {
                        showSnackbar(result);
                    }})
                }
                else
                {
                    showSnackbar("No gender entered");
                }
            }

            function changeBio()
            {
                var bio = prompt("Please enter your Bio", "");
                if (bio != "" && bio != null)
                {
                    $.ajax({url:"changeBio.php", data: {"bio":bio}, success: function(result)
                    {
                        showSnackbar(result);
                    }})
                }
                else
                {
                    showSnackbar("No bio entered");
                }
            }

            function changePassword()
            {
                var oldPassword = prompt("Please enter your OLD PASSWORD", "");
                var newPassword = prompt("Please enter your NEW PASSWORD", "");
                var confPassword = prompt("Please re-enter your NEW PASSWORD", "");
                if (oldPassword != "" && newPassword != "" && confPassword != "")
                {
                    $.ajax({url:"changePassword.php", data: {"oldPassword":oldPassword, "newPassword":newPassword, "confPassword":confPassword}, success: function(result)
                    {
                        showSnackbar(result);
                    }})
                }
                else
                {
                    showSnackbar("Enter all the values");
                }
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

            function changePos(lat, lng)
            {
                $.ajax({url:"changePos.php", data: {"lat":lat, "lng": lng}, success: function(result)
                {
                    showSnackbar(result);
                }})
            }
            
        </script>
    
        <div id="footer">
            <p id="f_msg">This website is proundly provided to you by Nedzingahe Kondelelani</p>
            <p id="cr">knedzing©2018</p>
        </div>

    </body>
</html>
