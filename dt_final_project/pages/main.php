<?php
	//sessions.php is called in order to check if the user has loged in.
	require_once 'connection.php';
	require_once './sessions.php';
	check_session();

	$user = $_SESSION['user'];
	$u=getUserCod($_SESSION['user']);

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST['i']) && isset($_POST['d']) &&  isset($_POST['t'])){
			$today = date("Y-m-d");
			$now = date('H:i');

			$text = $_POST['i'];
			$date = $_POST['d'];
			$time = $_POST['t'];

			if($date>$today || ($date==$today && $time>$now)){
				$task = newTask($text, $date, $time, $u);
			}
			header("./main.php");
		}
		if(isset($_POST['note'])){
			$text = $_POST['note'];

			$task = newNote($text, $u);
			echo '<script src="../js/notes.js"></script>';

		}
		if(isset($_POST['array'])){
			$stringAmounts=$_POST['arrayCant'];
			$arrayAmounts = explode(",", $stringAmounts);
			$arrayProducts=$_POST['array'];

			if(countProducts($u)>0){
				deleteProducts($u);
			}

			$length = count($arrayProducts);
			for($i=0; $i<$length; $i++){
				newProduct($arrayProducts[$i], $u, $arrayAmounts[$i]);
			}
			echo '<script src="../js/shoppingList.js"></script>';
		}
	}
?>
<!DOCTYPE html>
<!-- HTML main page:
	If the login checking is correct we can access this file. This page is meant to be an index to access the application functions.
 -->
<html>
	<head>
		<title>Main</title>
		<meta charset = "UTF-8">
		<link href="../css/main.css" rel="stylesheet" type="text/css">
		<script src="../js/main.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="menu">
				<ul class="menu">
		    		<li class="menu2">Tasks</li>
		    		<li class="menu2">Notes</li>
					<li class="menu2">Shopping list</li>
					<li class="menu2">Calendar</li>
		        </ul>
			</div>
			<div id="content">
				<?php
					require("./header.php");
					echo "<h1>Welcome ".$_SESSION['user']."</h1>";
				?>
				<input id="hidden" type="hidden" value="<?php $u?>">
				<div id="inside">
					<div>Create task</div>
					<div>
						<h2>Your tasks</h2>
						<?php require_once("./showTasks.php"); ?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>