<?php

include_once "../../classes/User.php";

$user = new User();
if(isset($_GET['email']) && isset($_GET['password'])){
    echo json_encode($user->validate($_GET['email'], $_GET['password']));
}else{
    echo  json_encode(false);
}