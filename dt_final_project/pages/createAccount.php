<?php
	include './header.html';

	//Use connection.php to access the functions that are neded.
	require_once 'connection.php';

	//When the form is posted
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$userNa = $_POST['newuser'];
        $userk = $_POST['newkey'];
        $userk2 = $_POST['newkey2'];
        $userMa = $_POST['newmail'];
        
        $check=check_name($userNa);

        /*This part is error control, we get an error if:
        	-A field is empty.
        	-If the user name already exists.
        	-If the passwords don't match.
        	-If there is an error creating the new user.
        If there are no error a new user is created in users table.*/
        if(empty($_POST['newuser'])||empty($_POST['newkey'])||empty($_POST['newkey2'])||empty($_POST['newmail'])){
        	header("Location: createAccount.php?err3=true&ma=".$userMa."&us=".$userNa);
        }
		elseif($check==true){
			header("Location: createAccount.php?err4=true&ma=".$userMa);
		}
        elseif($userk != $userk2){
			header("Location: createAccount.php?err2=true&ma=".$userMa."&us=".$userNa);
		}else{
			$usu = newUser($userNa, $userk, $userMa);
			if($usu===false){
				header("Location: createAccount.php?err=true&ma=".$userMa);
			}else{
				header("Location: createAccount.php?err=false");
			}
		}
	}
?>
<!DOCTYPE html>
<!-- HTML account creation form:
	The form action is done in the same file using 'PHP_SELF'.
	In this form it is introduced the user name, verification values, the new password and the re-write of the new password.
	There is also a link to go back to the login form.
 -->
<html>
	<head>
		<title>CreateAccount</title>
		<meta charset = "UTF-8">
		<link href="../css/terms.css" rel="stylesheet" type="text/css">
		<link href="../css/recovery.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<section class="main">
			<article>
				<h2>Create account</h2><br>
				<form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "POST">
					name:
					<input id = "newuser" name = "newuser" type = "text" maxlength="29" value="<?php if(isset($_GET["us"]))echo $_GET["us"];?>"><br>
					password:
					<input id = "newkey" name = "newkey" type = "password" maxlength="29"><br>
					repeat password:
					<input id = "newkey2" name = "newkey2" type = "password"><br>
					email:
					<input id = "newmail" name = "newmail" type = "email" maxlength="50" value="<?php if(isset($_GET["ma"]))echo $_GET["ma"];?>"><br>
					<div id="next"><input type = "submit" value="Next"></div><br>
				</form>
				<?php 
					if(isset($_GET["err"]) and $_GET["err"] == 'true'){
						echo "<p style='color:red'>* There was an error creating the new user *</p>";
					}
					if(isset($_GET["err2"]) and $_GET["err2"] == 'true'){
						echo "<p style='color:red'>* The password needs to match *</p>";
					}
					if(isset($_GET["err3"]) and $_GET["err3"] == 'true'){
						echo "<p style='color:red'>* All the data must be filled *</p>";
					}
					if(isset($_GET["err4"]) and $_GET["err4"] == 'true'){
						echo "<p style='color:red'>* This username is already taken, try another one *</p>";
					}
					if(isset($_GET["err"]) and $_GET["err"] == 'false'){
						echo "<p style='color:red'>* Account created! Check your email *</p>";
					}
				?>
			</article>
		</section>
		<?php
			include './footer.html';
		?>
	</body>
</html>