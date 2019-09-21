<?php 
	require "config/config.php";

	$email="";
	$password = "";
	$log_err = "";
	session_start();

	if ( isset($_COOKIE['email']) && isset($_COOKIE['password']) && isset($_COOKIE['username'])){
		$_SESSION['username'] = $_COOKIE['username'];
		header("Location: index.php");
	}



	if(isset($_POST['login_button'])){

		$_SESSION['log_email'] = $_POST['log_email'];
		$_SESSION['log_password'] = $_POST['log_password'];

		$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); //sanitize email
		$password = md5($_POST['log_password']);

		$log_check_query = mysqli_query($conn, "SELECT * from users where email='$email' and password='$password'");

		$log_num_rows = mysqli_num_rows($log_check_query);


		if($log_num_rows==1){
			$row = mysqli_fetch_array($log_check_query);

			$username = $row['username'];

			$user_activity_query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND active='no'");

			if(mysqli_num_rows($user_activity_query) == 1){
				$reopen_account = mysqli_query($conn, "UPDATE users SET active='yes' WHERE email='$email'");
			}

			$_SESSION['username'] = $username;
			
			
			if(isset($_POST['remember']) && $_POST['remember']=='remember'){
				setcookie('email',$email, time()+86400*30);
				setcookie('password',$password, time()+86400*30);
				setcookie('username',$username, time()+86400*30);
			}

			header("Location: index.php");
			exit();

		}
		else{
			$log_err = "Email and Password doesn't match. Please enter correct email and password!";
		}
	}

?>