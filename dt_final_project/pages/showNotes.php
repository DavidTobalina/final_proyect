<?php
    require_once './connection.php';
    require_once './sessions.php';
    if (session_status() === PHP_SESSION_NONE) {
        check_session();
    }
    
	$cod=getUserCod($_SESSION['user']);
	if(isset($_GET['text'])){
		deleteNote($cod, $_GET["text"]);
	}
	$count=countNotes($cod);
	if($count==0){
		echo "<p style='color:red'>No notes created</p>";
	}else{
		$all=getNotes($cod);
		foreach ($all as $row) {
			echo "<div class='n'><p>".$row['text']."</p><div class='trash'></div></div><br>";
		}
	}