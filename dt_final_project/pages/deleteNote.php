<?php
    require_once './connection.php';
    require_once './sessions.php';

    check_session();

    $user = $_SESSION['user'];
	$u=getUserCod($_SESSION['user']);

    deleteNote($u, $_GET["text"]);

    header("main.php?x=1");
    exit;