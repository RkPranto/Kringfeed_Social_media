<?php 
	

	class Post{
		private $user_obj;
		private $con;

		public function __construct($con, $loggedInUser){
			$this->con = $con;
			$this->user_obj = new User($con, $loggedInUser);
		}

		public function submitPost($body, $user_to){
			$body = strip_tags($body); //removes html tags 
			$body = mysqli_real_escape_string($this->con, $body);
			$check_empty = preg_replace('/\s+/', '', $body); //Deletes all spaces 

			if($check_empty != ""){
				$date_added = date("Y-m-d H:i:s");

				$added_by = $this->user_obj->getUserName();

				if($user_to == $added_by) {
					$user_to = "none";
				}

				$query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$body', '$added_by', '$user_to', '$date_added', 'yes', 'no', '0')");

				$returned_id = mysqli_insert_id($this->con);

				$num_posts = $this->user_obj->getNumPosts();
				$num_posts++;

				$update_query = mysqli_query($this->con, "update users set num_posts='$num_posts' where username='$added_by'");

			}
      
		}


		public function loadPostsFriends(){
			
			$data_query = mysqli_query($this->con, "select * from posts where deleted ='no' order by id desc");

			while($single_row = mysqli_fetch_array($data_query)){
				$rstring = "";
				$id = $single_row['id'];
				$body = $single_row['body'];
				$added_by = $single_row['added_by'];
				$date_time = $single_row['date_added'];

				if($single_row['user_to'] == 'none'){
					$user_to= "";
				}
				else{
					$user_to_obj = new User($this->con, $single_row['user_to']);

					$user_to = "to <a href='".$single_row['user_to']."'>".$user_to_obj->getFirstAndLastName()."</a>";
				}



				$user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
				$user_row = mysqli_fetch_array($user_details_query);
				$first_name = $user_row['first_name'];
				$last_name = $user_row['last_name'];
				$profile_pic = $user_row['profile_pic'];




				//////////////
				//Timeframe
					$date_time_now = date("Y-m-d H:i:s");

					$start_date = new DateTime($date_time); //Time of post

					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 

					if($interval->y >= 1) {
						if($interval->y == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval->m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month". $days;
						}
						else {
							$time_message = $interval->m . " months". $days;
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}

					$rstring .= "<div class='posted_status row column'>
 				<div class='added_by_pic col-*-1'>
 					<img src='$profile_pic'>
 				</div>
 				<div class='post_info col-*-3' id='post_change'>
 					<a href='$added_by'>$first_name $last_name </a>$user_to&nbsp;&nbsp;&nbsp;&nbsp;
 					<span style='color:#636e72; font-size:14px;'>$time_message</span>
 					<br>
 					<p>$body</p>
 					<hr>
 					<img id='heart' onclick='change_heart()' src='img/white_heart.png' style='height:30px;width:40px; border-right: 2px solid #EBEDEF;padding-right:10px;'>
 					<img id='laugh' onclick='change_laugh()' src='img/white_laugh.png' style='height:30px;width:40px; border-right: 2px solid #EBEDEF;padding-right:10px;'>
 					<img id='sad' onclick='change_sad()' src='img/white_sad.png' style='height:30px;width:40px; border-right: 2px solid #EBEDEF;padding-right:10px;'>
 				</div>
 				
 			</div>";

 				echo $rstring;

			}
		}

	}


 ?>