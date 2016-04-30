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
        var_dump($error);
        if($error !== true) header("Location: ../register.php?error=".$error);
        else echo "<h1>Success</h1>";
    }
    else header("Location: ../register.php?error=".$res);
    /*Validar registre d'usuari*/

}else if ($_POST['submitLogin']){
    var_dump($_POST);
    $user = new User();
    if(isset($_POST['tbEmail']) && isset($_POST['tbPassword'])) {
        if ($user->validate($_POST['tbEmail'], $_POST['tbPassword'])) {
            echo "Valid";
        } else {
            header("Location: ../login.php?error=Login incorrect");
        }
    }else{
        header("Location: ../login.php?error=Login incorrect");
    }
}