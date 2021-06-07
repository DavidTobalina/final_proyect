<?php
/*This php part is a checking: if you try to access a file that requires the user to log in you get redirected to login.php passing the param redirected=true that shows an error in the login*/
	function check_session(){
		session_start();
		if(!isset($_SESSION['user'])){	
			header("Location: login.php?redirected=true");
		}
	}