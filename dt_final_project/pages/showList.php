<?php
    require_once './connection.php';
    require_once './sessions.php';
    if (session_status() === PHP_SESSION_NONE) {
        check_session();
    }
    
	$cod=getUserCod($_SESSION['user']);
	$count=countProducts($cod);
	if($count==0){
		echo "<p style='color:red'>No shopping list created</p>";
	}else{
		$all=getList($cod);
		foreach ($all as $row) {
			$text = $row['text'];
			$amount = $row['amount'];
			if($text!='milk' && $text!='tomato' && $text!='cheese' && $text!='salad' && $text!='chicken'){
				echo "<div class='product'><img src='../images/shopping-cart.png' alt='".ucfirst($text)."'>".ucfirst($text)."<div class='amount'>Cantidad: ".$amount."</div><div class='check'></div></div>";
			}else{
				echo "<div class='product'><img src='../images/".$text.".png' alt='".ucfirst($text)."'>".ucfirst($text)."<div class='amount'>Cantidad: ".$amount."</div><div class='check'></div></div>";
			}
		}
	}