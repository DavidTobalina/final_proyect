<?php
	include './header.html';
	//Use connection.php to access the functions that are neded.
	require_once 'connection.php';

	//When the form is posted
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $userMail=$_POST['m'];

        /*This part is error checking. If there is no errors checkData() function is called in order to update the new password and a confirmation message is shown. The errors can be:
        	-The passwords don't match.
        	-The data introduced is wrong.*/
        if(empty($_POST['m'])){
        	header("Location: passwdRecovery.php?err2=true");
        }else{
			$mail = checkMail($userMail);
			if($mail=='wrongmail'){
				header("Location: passwdRecovery.php?err=true");
			}else{
				header("Location: passwdRecovery.php?err=false");
			}
        }
	}
?>
<!DOCTYPE html>
<!-- HTML password recovery form:
	The form action is done in the same file using 'PHP_SELF'.
	In this form it is introduced the user name, the verification values, the new password and the re-write of the new password.
	There is also a link to go back to the login.
 -->
<html>
	<head>
		<title>Recovery</title>		
		<meta charset = "UTF-8">
		<link href="../css/terms.css" rel="stylesheet" type="text/css">
		<link href="../css/recovery.css" rel="stylesheet" type="text/css">
	</head>
	<body>
    <section class="main">
		<article>
			<h2>Forgot password?</h2><br>
			<form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "POST">
				Write down your email and we will send it to you
				<br><br><input id = "m" name = "m" type = "email" maxlength="49">
				<div id="next">
					<input type = "submit" value="Next">
				</div><br>
			</form>
			<?php
				if(isset($_GET["err2"]) and $_GET["err2"] == 'true'){
					echo "<p style='color:red'>* You must write the email first *</p>";
				}
				if(isset($_GET["err"]) and $_GET["err"] == 'true'){
					echo "<p style='color:red'>* The email wasn't found in our database, check the email direction *</p>";
				}
				if(isset($_GET["err"]) and $_GET["err"] == 'false'){
					echo "<p style='color:red'>* Message was sent *</p>";
				}
			?>
		</article>
	</section>
	<?php
        include './footer.html';
    ?>
	</body>
</html>