<?php
	include './header.html';

	//If 'remember' cookie is set we go directly to main.php without showing the form.
	if(isset($_COOKIE['remember'])){
		header("Location:./main.php");
	}

	//Use connection.php to access the methods that are needed.
	require_once 'connection.php';
	
	//When the form is posted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//function from connection.php
		$usu = check_user($_POST['user'], $_POST['key']);
		if($usu==false){
			header("Location: login.php?err=true&user=".$_POST['user']);
		}else{
			//Create 'remember' cookie
			if(isset($_POST['remember'])){
				setcookie("remember","1",time()+3600*24);
			}
			//Start the session and redirects to the application main page.
			session_start();
			$_SESSION['user'] = $_POST['user'];
			header("Location: ./main.php");
		}
	}
?>
<!DOCTYPE html>
<!-- HTML login form:
	This is the first page of the web application.
	The form posted data is managed in the same file by using 'PHP_SELF'.
	In this form the username, the password and the remember me checkbox are posted.
	When the values are posted check_user function from connection.php is called, if the posted parameters check the database ones we are redirected to main.php otherwise we see an error. 
	If the remember-me checkbox is checked 'remember' cookie is set.
 -->
<html>
	<head>
		<title>Login</title>
		<meta charset = "UTF-8" name="viewport" content="width=device-width, initial-scale=1">
		<link href="../css/login.css" rel="stylesheet" type="text/css">
		<link href="../css/header-footer.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="../js/menuFunction.js"></script>
	</head>
	<body>
    <section class="main">
		<article>
			<h2>Login</h2>
		</article>
        <article>
            <?php if(isset($_GET["redirected"]) && $_GET["redirected"]==true){
				//Error: someone is trying to access the application without login in.
				echo "<p style='color:red'>* Login to continue *</p>";
			}?>
			<?php if(isset($_GET["err"]) and $_GET["err"] == true){
				//Error: the user and password don't match in our database.
				echo "<p style='color:red'>* Check the user and password *</p>";
			}?>
			<form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "POST">
				name
				<input value = "<?php if(isset($_GET["user"]))echo $_GET["user"];?>"
				id = "user" name = "user" type = "text"><br>				
				password			
				<input id = "key" name = "key" type = "password"><br><br>
				Remember me
				<input type="checkbox" id="remember" name="remember">
				<div id = "next"><input type = "submit" value="Next"></div>
			</form>
        </article>
		<article>
			<a href="./passwdRecovery.php">Forgot password?</a><br>
			<a href="./createAccount.php">Create account</a>
		</article>
    </section>
    <?php
        include './footer.html';
    ?>
	</body>
</html>