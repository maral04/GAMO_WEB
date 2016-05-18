<?php

include_once "../../classes/User.php";



if(isset($_GET['email'])){
    /*Loin*/
    $user = new User();
    $user->setEmail($_GET["email"]);
    	//var_dump($user);
        echo json_encode($user->exist());
}
