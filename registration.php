<?php 
	//error_reporting(E_ERROR | E_PARSE);
	require 'config/config.php';
	require 'signup.php';
	require 'login.php';
	//include("header.php");


 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Kringfeed</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/registration.css">
	<link rel="stylesheet" type="text/css" href="css/registration.checkbox.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="jquery-3.4.1.slim.js"></script>
</head>
<body>
		<!-- TOp bar -->
		<div class="top_bar" style="height: 80px;">
			<div class="logo">
				<a href="index.php" style="font-size: 70px;width:321px;">Kringfeed !!!</a>
			</div>

		</div>





	<div class="container">		
		<div id="block1">
			<div class="head-title">
				<h2 style="font-weight: bold; color: #fff; text-align: center; margin: 10px;">LOGIN</h2>
			</div>
			<form class="form-block" action="registration.php" method="post">
				<p><?php if(isset($error['result']))echo $error['result']; ?></p>
				<label for="email"> Email :</label><br>
				<input class="form-control" id="email" type="email" name="log_email" placeholder="Enter your e-mail..." value="<?php if(isset($_SESSION['log_email']))echo $_SESSION['log_email']; ?>" required> <br>

				<label for="password">Password : </label><br>
				<input class="form-control" id="password" type="password" name="log_password" placeholder="Enter your password..." value="<?php if(isset($_SESSION['log_password']))echo $_SESSION['log_password']; ?>" required> <br>

				<label class="container_check">Remember me
				  <input name="remember" type="checkbox" checked="checked" value="remember">
				  <span class="checkmark"></span>
				</label>

				<input class="form-control submit-button" type="submit" name="login_button" value="Login" style="color:white;">

				<p><?php if(isset($log_err))echo $log_err; ?></p>
				<p style="color:#212529"> Need an account? <a href="#" onclick="reg_link1()" class="reg_link">Sign up</a></p>

			</form>
			


			</div>

	
		<div id="block2">
			<div class="head-title">
				<h2 style="font-weight: bold; color: #fff; text-align: center; margin: 10px;">SIGN UP</h2>
			</div>
			<form class="form-block" action="registration.php" method="post">
				
				<label for="first_name"> First Name :</label><br>
				<input id="first_name" class="form-control" type="text" name="first_name" placeholder="First Name" value="<?php if(isset($_SESSION['first_name']))echo $_SESSION['first_name']; ?>" required>
				
				<p><?php if(isset($error['first_name']))echo $error['first_name']; ?></p>


				<label for="last_name"> Last Name :</label><br>
				<input id="last_name" class="form-control" type="text" name="last_name" placeholder="Last Name" value="<?php if(isset($_SESSION['last_name']))echo $_SESSION['last_name']; ?>" required>
				<p><?php if(isset($error['last_name']))echo $error['last_name']; ?></p>

				<label for="email"> Email :</label><br>
				<input id="email" class="form-control" type="email" name="user_email" placeholder="Email" value="<?php if(isset($_SESSION['user_email']))echo $_SESSION['user_email']; ?>" required>
				<p><?php if(isset($error['email']))echo $error['email']; ?></p>

				<label for="password"> Password :</label><br>
				<input id="password" class="form-control" type="password" name="user_password" placeholder="Password" required>
				
				<p><?php if(isset($error['password']))echo $error['password']; ?></p>

				<label for="c_password"> Confirm Password :</label><br>
				<input id="c_password" class="form-control" type="password" name="user_confirm_password" placeholder="Confirm Password" required><br>

				<input class="form-control submit-button" type="submit" name="signup_button" value="Sign Up" style="color:white;">

				<p style="color:#212529"> Already have an account? <a href="#" onclick="reg_link2()" class="reg_link" >Sign In</a></p>

			</form>
		</div>	

	</div>

	<script type="text/javascript">
		var b1 = document.getElementById('block1');
		var b2 = document.getElementById('block2');
		function reg_link1(){
			b1.style.display='none';
			b2.style.display='block';
		}
		function reg_link2(){
			b2.style.display='none';
			b1.style.display='block';
		}

	</script>


</body>
</html>