<?php 
	require('config/config.php');
	include("classes/User.php");
	include("classes/Post.php");
	include("classes/Message.php");
	session_start();

	if(isset($_SESSION['username'])){
		$loggedInUser = $_SESSION['username'];
		$user_details_query = mysqli_query($conn, "SELECT * FROM users WHERE username='$loggedInUser'");
		$user = mysqli_fetch_array($user_details_query);
	}
	else{
		header('Location: registration.php');
	}


 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Welcome to Kringfeed</title>

 	<!--CSS-->
 	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/messaging.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
	<link rel="stylesheet" type="text/css" href="css/requests.css">

	<!--Javascript-->
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="jquery-3.4.1.slim.js"></script>

	<script src="https://kit.fontawesome.com/6e054c7eb8.js"></script>
	
 </head>
 <body>

	<div class="top_bar">
		<div class="logo">
			<a href="index.php">Kringfeed !!!</a>
		</div>

		 <div class="top_icons">
 		<!--	<a href="#">
 				<?= $loggedInUser ?>
 			</a>
 			<a href="index.php">
 				home
 			</a>
 			<a href="messaging.php">
 				message
 			</a>
 			<a href="#">
 				notif
 			</a>
 			<a href="#">
 				setting
 			</a>
 			<a href="logout.php">
 				logout
 			</a>
 -->

 			<a href="<?= $loggedInUser ?>" style="font-weight: bold;">
 				<?= $loggedInUser ?>
 			</a>
 			<a href="index.php">
 				<i class="fa fa-home fa-lg"></i>
 			</a>
 			<a href="messaging.php">
 				<i class="fa fa-envelope"></i>
 			</a>
 			<a href="#">
 				<i class="fa fa-bell"></i>
 			</a>
 			<a href="#">
 				<i class="fa fa-cogs"></i>
 			</a>
 			<a href="logout.php">
 				<i class="fa fa-times-circle"></i>
 			</a>

 		</div>


	</div>

