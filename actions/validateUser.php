<?php
/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 25/04/2016
 * Time: 12:27
 */
include_once "../classes/User.php";
if(isset($_POST['submitUser'])){
    var_dump($_POST);
    $user = new User();
    $res = $user->init($_POST['tbName'],$_POST['tbLastName'], $_POST['tbEmail'],$_POST['tbPassword'],$_POST['tbPasswordConfirm']);
    var_dump($res);
    if($res === true) {
        $error = $user->save();
        if($error != "") $res = $error;
        echo header("Location: ../register.php?error=".$res);
    }
    else header("Location: ../register.php?error=".$res);
    /*Validar registre d'usuari*/

}