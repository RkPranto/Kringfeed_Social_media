<?php 
	include("header.php");
 ?>

 	<div class="container">
 		<div class="main_column column">

 			<?php 
 				$user_message_obj = new Message($conn, $loggedInUser);
 				$user_message_obj->showMessages();
 			 ?>
 			 <form class="post-form" action="index.php" method="post">
 				<textarea name="post_text" id="post_text" placeholder="" class="form-control"></textarea>
 				<input class="form-control submit-button" type="submit" name="message_button" value="Send">
 				<hr>
 			</form>

 		</div>


 	</div>