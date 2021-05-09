<?php
    require_once './connection.php';
    require_once './sessions.php';
    if (session_status() === PHP_SESSION_NONE) {
        check_session();
    }
    
	$cod=getUserCod($_SESSION['user']);

	if(isset($_GET['text'])){
		deleteTask($_GET["text"], 1, 1, $cod);
		earnPoints($cod);
	}

	$count=countTasks($cod);
	if($count==0){
		echo "<p style='color:red'>No tasks created</p>";
	}else{
		$today = [];
		$tomorrow = [];
		$someday = [];
		$dateNow = date('Y-m-d');
		$timeNow = date('H:i:s');

		$all=getTasks($cod);
		foreach ($all as $row) {
			$d = strtotime($row['date']);
			$date = date("d/m/Y", $d);

			$diff = abs($d - strtotime($dateNow));
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

			if($row['date']==$dateNow && $row['time']>$timeNow){
				array_push($today, $row['text'].",".$row["time"]);
			}elseif($row['date']>$dateNow && $days==1){
				array_push($tomorrow, $row['text'].",".$row["time"]);
			}elseif($row['date']>$dateNow && $days>1){
				array_push($someday, $row['text'].",".$row["time"]);
			}else{
				deleteTask($row['text'], $row['date'], $row['time'], $cod);
			}
		}
		echo "<div class='days'><h3>Today</h3>";
		foreach($today as $day){
			$arr = explode(",", $day);
			echo "<div class='task'><p>".$arr[0]." at ".substr($arr['1'] , 0, 5)."</p><div class='checkTask'></div></div>";
		}
		echo "</div>";
		echo "<div class='days'><h3>Tomorrow</h3>";
		foreach($tomorrow as $day){
			$arr = explode(",", $day);
			echo "<div class='task'><p>".$arr[0]." at ".substr($arr['1'] , 0, 5)."</p><div class='checkTask'></div></div>";
		}
		echo "</div>";
		echo "<div class='days'><h3>Someday</h3>";
		foreach($someday as $day){
			$arr = explode(",", $day);
			echo "<div class='task'><p>".$arr[0]." at ".substr($arr['1'] , 0, 5)."</p><div class='checkTask'></div></div>";
		}
		echo "</div>";
	}