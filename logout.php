<?php 
	session_start();
	session_destroy();
	setcookie('email','',time()-3600);
	setcookie('password','',time()-3600);
	setcookie('username','',time()-3600);

	header('Location: registration.php');
	
 ?>