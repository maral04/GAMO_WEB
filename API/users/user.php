<?php
include_once "../../classes/User.php";
	$user = new User();
	$arrayuser = $user->loadByEmail($_GET["mail"]);
	echo json_encode($arrayuser);
?>