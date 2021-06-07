<?php
	//sessions.php is called in order to check if the user has loged in.
	//connection.php is called in order to use the functions in it.
	require_once './sessions.php';
	require_once './connection.php';

    if (session_status() === PHP_SESSION_NONE) {
        check_session();
    }
    
	$cod=getUserCod($_SESSION['user']);
	$points = getUserPoints($cod);
	echo "points: ".$points;
?>