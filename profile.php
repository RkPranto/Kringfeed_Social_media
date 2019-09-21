<?php 
	include("header.php");


	if(isset($_GET['profile_username'])){
		$username = $_GET['profile_username'];
		$user_details_query = mysqli_query($conn, "select * from users where username='$username'");

		$is_valid_profile = mysqli_num_rows($user_details_query);

		if($is_valid_profile > 0 ){
			$user_array = mysqli_fetch_array($user_details_query);

			$num_friends = (substr_count($user_array['friends'], ",")) - 1;
		}
		else{
			header("Location: nouser.php");
		}
	}



	if(isset($_POST['remove_friend'])) {
		$user = new User($conn, $loggedInUser);
		$user->removeFriend($username);
	}

	if(isset($_POST['add_friend'])) {

		$user = new User($conn, $loggedInUser);
		$user->sendRequest($username);
	}
	if(isset($_POST['respond_request'])) {
		header("Location: requests.php");
	}


 ?>

	 	<div class="container">
	 		<div class="profile_left">
		 		<img style="height: 150px;width:150px;" src="<?php echo $user_array['profile_pic'] ?>">
		 		<hr>
		 		
		 		<div class="profile_info">
		 			<a href="<?= $username ?>"><?php echo $user_array['first_name']." ".$user_array['last_name'] ?></a><hr>
		 			<p><?php echo "Posts: ".$user_array['num_posts'] ?></p>
		 			<p><?php echo "Friends: ".$num_friends; ?></p>

		 		</div>


		 		
		 		<form action="<?php echo $username; ?>" method="POST">
		 			<?php 
		 			$profile_user_obj = new User($conn, $username); 

		 			$logged_in_user_obj = new User($conn, $loggedInUser); 

		 			if($loggedInUser != $username) {

		 				if($logged_in_user_obj->isFriend($username)) {
		 					echo '<input type="submit" name="remove_friend" class="btn btn-danger" value="Remove Friend"><br>';
		 				}
		 				else if ($logged_in_user_obj->didReceiveRequest($username)) {
		 					echo '<input type="submit" name="respond_request" class="btn btn-warning" value="Respond to Request"><br>';
		 				}
		 				else if ($logged_in_user_obj->didSendRequest($username)) {
		 					echo '<input type="submit" name="request_sent" class="btn btn-primary" value="Request Sent"><br>';
		 				}
		 				else 
		 					echo '<input type="submit" name="add_friend" class="btn btn-info" value="Add Friend"><br>';

		 			}



		 			?>


		 		</form>


		 	</div>


		 	<div class="main_column column up_content">
		 		<?php 
		 			$user_obj = new User($conn, $username);
		 			
		 			if(isset($_POST['post_to_button'])){
		 				$post_body = $_POST['post_to_text'];
		 				$date_added = date("Y-m-d H:i:s");
		 				if($username != $loggedInUser){
		 					$add_post_query = mysqli_query($conn, "insert into posts values('','$post_body','$loggedInUser','$username','$date_added','yes','no','0')");
		 					echo $add_post_query;
		 				}
		 				else{
		 					$add_post_query = mysqli_query($conn, "insert into posts values('','$post_body','$loggedInUser','none','$date_added','yes','no','0')");

		 				}
		 				echo "<span style='color:green'>New post added</span>";
						

					}
		 		?>
		 		<!-- Post area to this user -->
		 		<form class="post-form" action="<?php echo $username; ?>" method="post">
	 				<textarea name="post_to_text" id="post_text" placeholder="Wanna write on <?= $user_obj->getFirstAndLastName()?>'s Kringfeed?" class="form-control"></textarea>
	 				<input class="form-control submit-button" type="submit" name="post_to_button" value="Post">
	 				<hr>
	 			</form>
		 		<!-- show post of $username  -->
		 		<?php
		 			$user_obj->showMyPost();
		 		 ?>
		 	</div>



	 	</div>
	</body>
</html>