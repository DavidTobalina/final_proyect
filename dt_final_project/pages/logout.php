<?php
	//This is the logout file, it destroys the session and cookies and redirects to the login form.
	//Join session
	session_start();
	//Empty session array
	$_SESSION = array();
	//Destroy the session
	session_destroy();
	//Delete the session cookie
	setcookie(session_name(), 123, time() - 1000);
	//Delete the remember me cookie
	setcookie("remember", "1",time() - 1000);
	//Delete the calendar cookie
	setcookie("calendar", "",time() - 1000);
	//Redirect to login
	header("Location: ../");