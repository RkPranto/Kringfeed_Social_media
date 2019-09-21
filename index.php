<?php 
	include("header.php");

	if(isset($_POST['post_button'])){
		$post = new Post($conn, $loggedInUser);
		$post->submitPost($_POST['post_text'],'none');
	}

 ?>

 	
 	<div class="container">
 		
 		<div class="user_details column">
	 		<a href="<?= $loggedInUser ?>"><img src="<?php echo $user['profile_pic'] ?>"></a>
	 		<div class="user_details_info">
	 			<a href="<?= $loggedInUser ?>">
	 			<?php echo $user['first_name']." ".$user['last_name'] ?>
		 		</a><br>
		 		<a href="#">
		 			<?php echo "Num posts: ".$user['num_posts'] ?>
		 		</a><br>

		 		<a href="#">
		 			<?php echo "Num likes: ".$user['num_likes'] ?>
		 		</a><br>
	 		</div>
	 	</div>

	 	<div class="main_column column">
 			<form class="post-form" action="index.php" method="post">
 				<textarea name="post_text" id="post_text" placeholder="What's on your mind?" class="form-control"></textarea>
 				<input class="form-control submit-button" type="submit" name="post_button" value="Share">
 				<hr>
 			</form>

 			<?php 
 				$user_post_obj = new Post($conn, $loggedInUser);
 				$user_post_obj->loadPostsFriends();
 			 ?>

 		</div>


 	</div>

 	<!-- <script type='text/javascript'>
					var h = document.getElementById('heart');
					var l = document.getElementById('laugh');
					var s = document.getElementById('sad');

					function change_heart(){
						var image = document.getElementById('heart');
			            if (image.src.match('white_heart.png')) {
			                image.src = 'red_heart.png';
			            }
			            else {
			                image.src = 'white_heart.png';
			            }
					}
					function change_laugh(){

					}
					function change_sad(){

					}
				</script> -->


 	
 
 </body>
 </html>