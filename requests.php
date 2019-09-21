<?php 
	include("header.php");



 ?>
 	<div class="container">
 		
	 	<div class="main_column column">
	 		<!-- here all friend request will be shown of $loggedInUser -->
	 			<h3>Friend Requests</h3>

	 			<?php 
	 				$query = mysqli_query($conn, "select * from friend_request where user_to='$loggedInUser'");

	 				if(mysqli_num_rows($query) == 0 ){
	 					echo "You have no friend requests !";
	 				}
	 				else{
	 					while($single_request = mysqli_fetch_array($query)){
	 						$user_from = $single_request['user_from'];
	 						$user_from_obj = new User($conn, $user_from);
	 						$name = $user_from_obj->getFirstAndLastName();

	 						echo "<div class='single_request column'>
				 			<h4><a href='$user_from'><span style='font-weight: bold;
			font-size: 22px;color: #0074E8;'>$name</span></a> sent you friend request.</h4>";

							$user_from_friend_array = $user_from_obj->getFriendArray();

							if(isset($_POST['accept_button'.$user_from])){
								$add_friend_query = mysqli_query($conn, "update users set friends=CONCAT(friends,'$loggedInUser,') where username = '$user_from'");
								$add_friend_query = mysqli_query($conn, "update users set friends=CONCAT(friends,'$user_from,') where username = '$loggedInUser'");
								$request_delete_query = mysqli_query($conn, "delete from friend_request where user_from='$user_from' and user_to='$loggedInUser'");

								echo "You and ".$user_from." are now friends !";	
								header("Location: requests.php");
							}
							if(isset($_POST['reject_button'.$user_from])){
								$request_delete_query = mysqli_query($conn, "delete from friend_request where user_from='$user_from' and user_to='$loggedInUser'");

								echo "You have rejected ".$user_from."'s friend request !";	
								header("Location: requests.php");
							}
							echo "<form action='requests.php' method='post'>
					 			<input type='submit' name='accept_button$user_from' value='Accept' class='btn btn-success'>
					 			<input type='submit' name='reject_button$user_from' value='Reject' class='btn btn-danger'>
				 			</form>

				 		</div>";



	 					}
	 				}	

		 		 ?>

	 		
	 		
	 	</div>






	</div>		 	

	</body>
</html>

