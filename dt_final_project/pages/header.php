<?php
	//sessions.php is called in order to check if the user has loged in.
	//connection.php is called in order to use the functions in it.
	require_once './sessions.php';
	require_once './connection.php';
?>

<div class="dropdown">
	<div id="dropbtn" class="dropbtn"></div>
	<nav id="myDropdown" class="dropdown-content">
		<a><?php
			echo $_SESSION['user'];
		?></a>
		<a><?php
			$cod=getUserCod($_SESSION['user']);
			$points = getUserPoints($cod);
			echo "points: ".$points;
		?></a>
		<a href="./logout.php">Logout</a>
	</nav>
</div>