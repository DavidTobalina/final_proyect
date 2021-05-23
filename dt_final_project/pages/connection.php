<?php
//In order to send messages with mailer is necessary to use the library:
use PHPMailer\PHPMailer\PHPMailer;

function connection(){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$sql="select * from users;";
		$users=$bd->query($sql);
		return $users;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function check_user($name, $key){
	$users=connection();
	foreach ($users as $row) {
		if($row['name']==$name && password_verify($key, $row['passwd'])){
			$us=true;
			break;
		}else{
			$us=false;
		}
	}
	return $us;
}

function check_name($name){
	$users=connection();
	foreach ($users as $row) {
		if($row['name']==$name){
			$us=true;
			break;
		}else{
			$us=false;
		}
	}
	return $us;
}

function getUserCod($name){
	$users=connection();
	foreach ($users as $row) {
		if($row['name']==$name){
			$us=$row['code'];
			break;
		}else{
			$us="false";
		}
	}
	return $us;
}

function getUserPoints($cod){
	$users=connection();
	foreach ($users as $row) {
		if($row['code']==$cod){
			$us=$row['points'];
			break;
		}else{
			$us="false";
		}
	}
	return $us;
}

function earnPoints($cod){
	$first = getUserPoints($cod);
	$second = $first+25;

	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$ins="update users set points = $second where code = $cod;";
		$resul=$bd->query($ins);
		return $resul;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function newUser($newuser,$newkey,$newmail){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		require "../composer/vendor/autoload.php";	//IMPORTANT
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug  = 0;
		$mail->SMTPAuth   = true;
		$mail->SMTPSecure = "tls";
		$mail->Host       = "smtp.gmail.com";
		$mail->Port       = 587;
		$mail->Username   = "IMPORTANT";
		$mail->Password   = "IMPORTANT";
		$mail->SetFrom('IMPORTANT', 'Tasker');
		$mail->Subject    = "Welcome to Tasker";
		$mail->MsgHTML('Welcome '.$newuser.", now you can login and start planning");
		$mail->AddAddress($newmail, "Tasker");
		$x = $mail->Send();
		if(!$x) {
		echo "Error" . $mail->ErrorInfo;
		} else {
		echo "Sent";
		}

		$bd=new PDO($connection_string,$u,$k);
		$ins="insert into users(name, passwd, mail) values ('$newuser', '".password_hash($newkey, PASSWORD_DEFAULT)."', '$newmail');";
		$resul=$bd->query($ins);
		return $resul;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function checkMail($m){
	$users=connection();
	$count=0;
	foreach ($users as $row) {
		if($row['mail']==$m){
			$us=$row['name'];
			$pass=$row['passwd'];
		 	require "../composer/vendor/autoload.php";	//IMPORTANT
		 	$mail = new PHPMailer();
		 	$mail->IsSMTP();
		 	$mail->SMTPDebug  = 0;
		 	$mail->SMTPAuth   = true;
		 	$mail->SMTPSecure = "tls";
			$mail->Host       = "smtp.gmail.com";
			$mail->Port       = 587;
			$mail->Username   = "IMPORTANT";
			$mail->Password   = "IMPORTANT";
			$mail->SetFrom('IMPORTANT', 'Tasker');
			$mail->Subject    = "Password recovery";
			$mail->MsgHTML('Hello '.$us." your password is ".$pass);
			$address = $m;
			$mail->AddAddress($address, "Tasker");
			$resul = $mail->Send();
			if(!$resul) {
			  echo "Error" . $mail->ErrorInfo;
			} else {
			  echo "Sent";
			}
			$count++;
		}
	}
	if($count<1){
		$ma="wrongmail";
	}else{
		$ma='';
	}
	return $ma;
}

function getUserName($cod){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$ins="select name from users where code = $cod;";
		$resul=$bd->query($ins);
		foreach ($resul as $row) {
			$r=$row['name'];
			return $r;
		}
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function newTask($text, $date, $time, $user){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$ins="insert into tasks(text, date, time, codUser) values ('$text', '$date', '$time', '$user');";
		$resul=$bd->query($ins);
		return $resul;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function countTasks($cod){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$ins="select count(*) as total from tasks where codUser = $cod;";
		$resul=$bd->query($ins);
		foreach ($resul as $row) {
			return $row['total'];
		}
		
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function getTasks($cod){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$sql="select * from tasks where codUser=$cod;";
		$all=$bd->query($sql);
		return $all;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function deleteTask($text, $date, $time, $cod){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1:3306';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$sql="select * from tasks where text='$text' and date='$date' and time='$time' and codUser='$cod';";
		$resul=$bd->query($sql);
		foreach ($resul as $row) {
			deleteTaskById($row['codTask']);
		}
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function deleteTaskById($cod){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$sql="delete from tasks where codTask='$cod';";
		$all=$bd->query($sql);
		return $all;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function newNote($text, $user){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$ins="insert into notes(text, codUser) values ('$text','$user');";
		$resul=$bd->query($ins);
		return $resul;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function countNotes($cod){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$ins="select count(*) as total from notes where codUser = $cod;";
		$resul=$bd->query($ins);
		foreach ($resul as $row) {
			return $row['total'];
		}
		
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function getNotes($cod){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$sql="select * from notes where codUser=$cod;";
		$all=$bd->query($sql);
		return $all;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function deleteNote($cod, $text){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$sql="delete from notes where codUser=".$cod." and text='".$text."';";;
		$all=$bd->query($sql);
		return $all;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function newProduct($text, $user, $amount){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$ins="insert into list(text, codUser, amount) values ('$text','$user','$amount');";
		$resul=$bd->query($ins);
		return $resul;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function countProducts($cod){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$ins="select count(*) as total from list where codUser = $cod;";
		$resul=$bd->query($ins);
		foreach ($resul as $row) {
			return $row['total'];
		}
		
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function getList($cod){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$sql="select * from list where codUser=$cod;";
		$all=$bd->query($sql);
		return $all;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function deleteProducts($cod){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$sql="delete from list where codUser=$cod;";;
		$all=$bd->query($sql);
		return $all;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}

function deleteProduct($cod, $text){
	$connection_string='mysql:dbname=dt_final_project;host=127.0.0.1';
	$u='root';
	$k='';
	try{
		$bd=new PDO($connection_string,$u,$k);
		$sql="delete from list where codUser=".$cod." and text='".$text."';";;
		$all=$bd->query($sql);
		return $all;
	}catch(PDOException $e){
		echo "Error in the database: ".$e->getMessage();
	}
}