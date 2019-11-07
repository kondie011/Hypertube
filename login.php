<!DOCTYPE html>
<html>
	<head>
		<script src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
		<meta name="google-signin-client_id" content="805055211006-l4su8hfp8mrcasp3lf6pvbeo6j1hvn6d.apps.googleusercontent.com">
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		<title>login page</title>
		<style>
			body
			{
				width: 95%;
				background-image: url("https://i.pinimg.com/originals/91/19/00/9119008dae516ce7cc7677e809af0b56.png");
			}
			#ze_form
			{
				font-size: 30px;
				background-image: linear-gradient(cyan, indigo);
				border-radius: 10px;
				width: 300px;
				padding: 50px;
				border: 1px solid black;
				text-align: center;
				margin-left: 35%;
			}
			#ze_form input
			{
				margin: 5px;
			}
			#welcome
			{
				color: white;
				font-size: 55px;
				font-family: cursive;
				margin-left: 30%;
			}
			#welcome a
			{
				text-decoration: none;
			}
			#web_name
			{
				font-size: 80px;
				font-style: italic;
				color: orangered;
				shadow: 2px 2px black;
			}
			.input_info
			{
				border-radius: 5px;
				height: 30px;
				width: 300px;
			}
			.text_style1
			{
				font-family: fantasy;
				font-style: normal;
			}
			.button_style1
			{
				padding: 10px;
				font-size: 25px;
			}
			.button_style2
			{
				padding: 10px;
				font-size: 15px;
				width: 100%;
				background-color: grey;
				color: white;
				font-style: italic;
				border-radius: 5px;
			}
		</style>
	</head>
	<body ng-app="login" ng-controller="login_con">
		<p id="welcome">Welcome to <a href="index.php"><span id="web_name">Hypertube</span></a></p>
		<form id="ze_form" name="index.php" method="POST" enctype="multipart/form-data" action="login_func.php">
			<label class="text_style1" for="login">Username: </label>
			<input class="input_info" type="text" name="login" value="<?php echo $_SESSION['login']; ?>"/>
    		<br />
			<label class="text_style1" for="passwd">Password: </label>
			<input class="input_info" type="password" name="passwd" value="<?php echo $_SESSION['passwd'];?>"/>
    		<br />
			<input class="button_style1" type="submit" name="submit" value="Login"/>
			<br />
            <input class="button_style2" type="submit" name="forgot_pass" value="Forgot password?" onclick="forgotPass()"/>
			<br />
            <input class="button_style1" type="submit" name="sp" value="Sign up"/>
			<br />
			<p style="color: white; font-size: 20px; font-family: cursive;">Or connect with:</p>
            <a href="https://api.intra.42.fr/oauth/authorize?client_id=43c57bb453214ee3832296a532afdabf04557fe16d1211f6c652062694409c85&redirect_uri=http%3A%2F%2Flocalhost%3A8100%2Fhypertube%2Flogin.php&response_type=code">
				<img src="https://www.42.us.org/wp-content/uploads/2017/07/logo.png" style="width: 40px">
			</a>
            <!-- <input class="button_style1" type="button" name="google" value="Continue with Google+" ng-click="oathG()"/> -->
			<div style="margin-left: 90px;" class="g-signin2" data-onsuccess="onSignIn"></div>
            <!-- <input class="button_style1" type="button" name="fb" value="Continue with Facebook" ng-click="checkLoginState()"/> -->
			<div id="google_translate_element"></div>

			<script type="text/javascript">
				function googleTranslateElementInit()
				{
					new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
				}
			</script>

			<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
		</form>

		<h1>{{google.username}}</h1>
		<h1>{{google.email}}</h1>
		<script type="text/javascript">

			var Url = document.location.href;
			if (Url.split("?code=").length === 2) {
				OCode = Url.split("?code=")[1];
				//document.write("if you are not automatically redirected, Click <a href ='http://localhost:3000/login42/"+OCode+"'>ici</a>.");
				window.location.replace("http://localhost:3000/login42/"+OCode);
			}

			function onSignIn(googleUser)
			{
				var profile = googleUser.getBasicProfile();
				console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
				console.log('Name: ' + profile.getName());
				console.log('Image URL: ' + profile.getImageUrl());
				console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
				$.ajax({url: "./saveGUser.php", method: "POST", data: {"id":profile.getId(), "name":profile.getName(), "image_url": profile.getImageUrl(), "email":profile.getEmail(), "fname":profile.getGivenName(), "lname":profile.getFamilyName()}, success: function (result)
				{
					//alert(result);
					window.location.href = "index.php";
				}});
				//signOut();
			}
			
			function signOut()
			{
				var auth2 = gapi.auth2.getAuthInstance();
				auth2.signOut().then(function () {
				console.log('User signed out.');
				});
			}

			var app = angular.module('login', []);
			app.controller('login_con', function($scope, $http)
			{
				$scope.google = {username: "", email: ""};
				$scope.checkLoginState = function ()
				{
					FB.getLoginStatus(function(response)
					{
						statusChangeCallback(response);
					});
				};
				$scope.oath42 = function ()
				{
					alert("dddd");
					var url = "https://api.intra.42.fr/oauth/token";//?client_id=43c57bb453214ee3832296a532afdabf04557fe16d1211f6c652062694409c85&redirect_uri=http%3A%2F%2Flocalhost%3A8100%2Fhypertube%2Flogin.php&response_type=code";
					$http({
						method: 'POST',
						url: url,
						json: true,
						body: {
							grant_type: 'authorization_code',
							client_id: '43c57bb453214ee3832296a532afdabf04557fe16d1211f6c652062694409c85',
							client_secret: '4622d7c251aa00bdf28153b528e6675b57ea88006b8f46526d1c834eb201d9d2',
							redirect_uri: 'http%3A%2F%2Flocalhost%3A8100%2Fhypertube%2Flogin'
						}
					})
					.then(function successCallback(response)
					{
						//$scope.response = response;
						console.log(response);
					}, function errorCallback(response){
						console.log("Unable to perform get request");
					});
				}
				/*$scope.oathG = function ()
				{
					alert("dddd");
					var params = {
						"clientid": "805055211006-l4su8hfp8mrcasp3lf6pvbeo6j1hvn6d.apps.googleusercontent.com",
						"cookiepolicy": "single_host_origin",
						"callback": function(result)
						{
							if (result["status"]["signed_in"])
							{
								var req = gapi.client.plus.people.get(
									{
										"userId": "me"
									}
								);
								req.execute(function (resp)
								{
										alert(resp.displayName + "   " + resp.emails[0].value);
									$scope.$apply(function ()
									{
										$scope.google.username = resp.displayName;
										$scope.google.email = resp.emails[0].value;
									});
								});
							}
						},
						"approvalprompt": "force",
						"scope": "https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read"
					}
					gapi.auth.signIn(params);
				}*/
			});

			(function ()
			{
				var s = document.createElement("script");
				s.type = "text/javascript";
				s.async = true;
				s.src = "https://apis.google.com/js/client.js?onload=onLoadFunc";
				var script = document.getElementsByTagName("script")[0];
				script.parentNode.insertBefore(s, script);
			})();

			function onLoadFunc()
			{
				gapi.client.setApiKey("AIzaSyAyGRycOWWLr4ANDvGLQMAkr8n6rz8W6uE");
				gapi.client.load("plus", "v1", function (){});

				gapi.load("auth2", function ()
				{
					gapi.auth2.init();
				});
				
			}

			window.fbAsyncInit = function() {
				FB.init({
				appId      : '562285220890645',
				cookie     : true,
				xfbml      : true,
				version    : 'v3.2'
				});
				
				FB.AppEvents.logPageView();
			};

			(function(d, s, id){
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
				js.src = "https://connect.facebook.net/en_US/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));

			function statusChangeCallback(response)
			{
                console.log('statusChangeCallback');
                console.log(response);
                // The response object is returned with a status field that lets the
                // app know the current login status of the person.
                // Full docs on the response object can be found in the documentation
                // for FB.getLoginStatus().
                if (response.status === 'connected') {
                    // Logged into your app and Facebook.
                    console.log('Welcome!  Fetching your information.... ');
                    FB.api('/me', function (response) {
                        console.log('Successful login for: ' + response.name);
                    });
                } else {
                    
                }
            }

			// function oath42()
			// {
			// 	/*$.ajax({url: "api.php", data: {"origin":"42"}, success: function(result)
			// 	{
			// 		alert(result);
			// 	}});*/
			// 	window.location.href = "https://api.intra.42.fr/oauth/authorize?client_id=43c57bb453214ee3832296a532afdabf04557fe16d1211f6c652062694409c85&redirect_uri=http%3A%2F%2Flocalhost%3A8100%2Fhypertube%2Findex.php&response_type=code";
			// }

			function forgotPass()
			{
				var username = prompt("Please enter your username", "kondie_");
				var email, newPass, confPass;
				if (username != "")
				{
					var email = prompt("Please enter your email", "joeblog@mailinator.com");
					if (email != "")
					{
						var newPass = prompt("Please enter your new password", "");
						if (newPass != "")
						{
							var confPass = prompt("Please re-enter your new password", "");
						}
					}
				}
				if (username != "" && email != "" && newPass.length > 5 && confPass.length > 5)
				{
					if (newPass == confPass)
					{
						$.ajax({url: "forgotPassword.php?username="+username+"&email="+email+"&password="+newPass, success: function(result)
						{
							alert(result);
						}});
					}
					else
					{
						alert("Your password doesn't match");
					}
				}
				else
				{
					alert("Please enter all the values");
				}
			}

		</script>
	</body>
</html>
