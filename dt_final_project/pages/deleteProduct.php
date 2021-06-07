<?php
    require_once './connection.php';
    require_once './sessions.php';

    check_session();

    $user = $_SESSION['user'];
	$u=getUserCod($_SESSION['user']);

    deleteProduct($u, $_GET["text"]);