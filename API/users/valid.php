<?php

include_once "../../classes/User.php";


if(isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password1'])&& isset($_POST['password2'])){
    /*Registre*/
    $user = new User();
    $res = $user->init($_POST['name'],$_POST['lastname'],$_POST['email'],$_POST['password1'],$_POST['password2']);
    if($res === true) {
        $error = $user->save();

        if($error !== true) echo  json_encode(array('error' => $error));
        else echo json_encode(true);
    }
    else json_encode(array('error' => $res));
} else if(isset($_GET['email']) && isset($_GET['password'])){
    /*Loin*/
    $user = new User();
    echo json_encode($user->validate($_GET['email'], $_GET['password']));
}else {
    echo json_encode(false);
}