<?php 
	$first_name ="";
	$last_name ="";
	$user_email = "";
	$user_password = "";
	$user_confirm_password="";
	$date = date("Y-m-d"); // set current date
	$error = array();
	$error['result'] = NULL;

//first name
	if(isset($_POST['signup_button'])){
		$first_name = strip_tags($_POST['first_name']);
		$first_name = str_replace(' ','', $first_name);
		$first_name = ucfirst(strtolower($first_name));
		$_SESSION['first_name'] = $first_name;

		if(strlen($first_name)>20 || strlen($first_name) < 3 ){
			$error['first_name'] = "Your first name must have between 3 and 20 characters<br>";
		}

//last name
		$last_name = strip_tags($_POST['last_name']);
		$last_name = str_replace(' ','', $last_name);
		$last_name = ucfirst(strtolower($last_name));
		$_SESSION['last_name'] = $last_name;

		if(strlen($last_name)>20 || strlen($last_name) < 3 ){
			$error['last_name'] = "Your last name must have between 3 and 20 characters<br>";
		}


//email 
		$user_email = strip_tags($_POST['user_email']);

		if(filter_var($user_email, FILTER_VALIDATE_EMAIL)){

			$user_email = filter_var($user_email, FILTER_VALIDATE_EMAIL);

			$err_check_query = mysqli_query($conn, "SELECT email FROM users WHERE email = '$user_email'");

			$num_rows = mysqli_num_rows($err_check_query);

			if($num_rows>0){
				$error['email'] = "Email already registered !<br>" ;
			}
		}
		else{
			$error['email'] = "Invalid email format<br>";
		}
		$_SESSION['user_email'] = $user_email;

		

//password

		$user_password = strip_tags($_POST['user_password']);
		$user_confirm_password = strip_tags($_POST['user_confirm_password']);

		if(strlen($user_password) < 6){
			$error['password'] = "Password must have at least 6 characters<br>";
		}

		if($user_password != $user_confirm_password){
			$error['password'] = "Password doesn't match<br>";
		}
		else{
			if(preg_match('/[^A-Za-z0-9]/', $user_password)) {
				$error['password'] = "Password can only be english characters and numbers !<br>";
			}
		}


		if(!isset($error['first_name']) && !isset($error['last_name']) && !isset($error['email'])  && !isset($error['password']) 
		){
			$user_password = md5($user_password); //Encrypt password 

//Generate username 
			$username = strtolower($first_name . "_" . $last_name);
			$check_username_query = mysqli_query($conn, "SELECT username FROM users WHERE username='$username'");



	//if username exists
			while(mysqli_num_rows($check_username_query) != 0) {
				$username = $username . "_" . rand(1,1000);
				$check_username_query = mysqli_query($conn, "SELECT username FROM users WHERE username='$username'");
			}

//profile pic
			$profile_pic = "img/demo_propic.jpg";

//insert user
			$query = "INSERT INTO users VALUES ('', '$first_name', '$last_name', '$username', '$user_email', '$user_password', '$date', '0', '0', 'yes', ',','$profile_pic')";
			$sql = mysqli_query($conn,$query);


			$error['result'] = "<span style='color:green'>Your account has been created succesfully! Please Login Now !</span>";

			$_SESSION['first_name'] = "";
			$_SESSION['last_name'] = "";
			$_SESSION['user_email'] = "";
			

		}


	}

 ?>
