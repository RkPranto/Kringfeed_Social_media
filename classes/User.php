<?php 
	

	class User{
		private $user_db;
		private $con;

		public function __construct($con, $loggedInUser){
			$this->con = $con;
			$user_details_query = mysqli_query($con,"select * from users where username='$loggedInUser'");
			$this->user_db = mysqli_fetch_array($user_details_query);

		}

		public function getFirstAndLastName(){
			return $this->user_db['first_name']." ".$this->user_db['last_name']; 
		}

		public function getUsername()
		{
			return $this->user_db['username'];
		}

		public function getNumPosts()
		{
			return $this->user_db['num_posts'];
		}

		public function getFriendArray(){
			return $this->user_db['friends'];
		}

		public function getProfilePic() {
			return $this->user_db['profile_pic'];
		}

		public function isFriend($username_to_check) {
			$usernameComma = "," . $username_to_check . ",";

			if(strstr($this->user_db['friends'], $usernameComma) || $username_to_check == $this->user_db['username']) {
				return true;
			}
			else {
				return false;
			}
		}



		public function didReceiveRequest($user_from) {
			$user_to = $this->user_db['username'];
			$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_request WHERE user_to='$user_to' AND user_from='$user_from'");
			if(mysqli_num_rows($check_request_query) > 0) {
				return true;
			}
			else {
				return false;
			}
		}

		public function didSendRequest($user_to) {
			$user_from = $this->user_db['username'];
			$check_request_query = mysqli_query($this->con, "select * from friend_request where user_to='$user_to' and user_from='$user_from'");

			if(mysqli_num_rows($check_request_query)>0){
				return true;
			}
			else{
				return false;
			}
		}

		public function removeFriend($user_to_remove) {
			$logged_in_user = $this->user_db['username'];

			$query = mysqli_query($this->con, "SELECT friends FROM users WHERE username='$user_to_remove'");
			$row = mysqli_fetch_array($query);
			$remove_friend_array = $row['friends'];

			$new_friend_array = str_replace($user_to_remove . ",", "", $this->user_db['friends']);
			$remove_friend = mysqli_query($this->con, "UPDATE users SET friends='$new_friend_array' WHERE username='$logged_in_user'");

			$new_friend_array = str_replace($this->user_db['username'] . ",", "", $remove_friend_array);
			$remove_friend = mysqli_query($this->con, "UPDATE users SET friends='$new_friend_array' WHERE username='$user_to_remove'");
		}

		public function sendRequest($user_to) {
			$user_from = $this->user_db['username'];
			$request_time = date("Y-m-d H:i:s");
			$query = mysqli_query($this->con, "INSERT INTO friend_request VALUES(NULL, '$user_to', '$user_from','$request_time')");
		}



		public function showMyPost()
		{
			$added_by  = $this->user_db['username']; 
			$post_query = mysqli_query($this->con, "select * from posts where added_by='$added_by' or user_to='$added_by' order by id desc");

			while($single_row = mysqli_fetch_array($post_query)){
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
 				<div class='post_info col-*-3'>
 					<a href='$added_by'>$first_name $last_name </a>$user_to&nbsp;&nbsp;&nbsp;&nbsp;
 					<span style='color:#636e72; font-size:14px;'>$time_message</span>
 					<br>
 					<p>$body</p>
 					<hr>
 					<img src='img/white_heart.png' style='height:30px;width:40px; border-right: 2px solid #EBEDEF;padding-right:10px;'>
 					<img src='img/white_laugh.png' style='height:30px;width:40px; border-right: 2px solid #EBEDEF;padding-right:10px;'>
 					<img src='img/white_sad.png' style='height:30px;width:40px; border-right: 2px solid #EBEDEF;padding-right:10px;'>
 					<hr>
 					<h6>11 Likes</h6>
 				</div>
 			</div>";

 				echo $rstring;


			}

		}



		public function showMyFriendRequests()
		{
			

		}

		public function addFriend($add_user){
			echo "fiend add";
		}



	}


 ?>