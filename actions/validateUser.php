<?php session_start();
/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 25/04/2016
 * Time: 12:27
 */

include_once "../classes/User.php";
$user = new User();
if(isset($_POST['submitUser'])){
    var_dump($_POST);

    $res = $user->init($_POST['tbName'],$_POST['tbLastName'], $_POST['tbEmail'],$_POST['tbPassword'],$_POST['tbPasswordConfirm']);
    var_dump($res);

    if($res === true) {
        $error = $user->save();
        var_dump($error);
        if($error !== true) header("Location: ../register.php?error=".$error);
        else {
            header("Location: ../eventList.php");
        }
    }
    else header("Location: ../register.php?error=".$res);
    /*Validar registre d'usuari*/

}else if (isset($_POST['submitLogin'])){
    var_dump($_POST);

    if(isset($_POST['tbEmail']) && isset($_POST['tbPassword'])) {
        if ($user->validate($_POST['tbEmail'], $_POST['tbPassword'])) {
            $user->loadByEmail($_POST['tbEmail']);

            $_SESSION['idUser'] = $user->getId();
            var_dump($user->getId());
            header("Location: ../eventList.php");
        } else {
            header("Location: ../login.php?error=Login incorrect");
        }
    }else{
        header("Location: ../login.php?error=Login incorrect");
    }
}else if(isset($_POST['submitProfile'])){
    var_dump($_POST);
    $user->load($_POST['id']);
    $user->setId($_POST['id']);
    $user->setEmail($_POST['tbEmail']);
    $user->setName(($_POST['tbName']));
    $user->setLastname($_POST['tbLastName']);
    $user->setBirth($_POST['tbBirth']);
    $user->setTshirt($_POST['tbTshirt']);
    $user->setClub($_POST['tbClub']);
    $user->setIdLocalitzacio($_POST['idLocal']);
    $user->setCountry($_POST['tbCountry']);
    $user->setRegion($_POST['tbRegion']);
    $user->setCity($_POST['tbCity']);
    $user->setAddress($_POST['tbAddress']);
    $user->setPostalCode($_POST['tbPostalCode']);
    $user->setPhone1($_POST['tbPhone']);
    $user->setPhone2($_POST['tbPhone2']);
    if(isset($_POST['sport']))$user->setSport($_POST['sport']);

    $user->save(true);
}