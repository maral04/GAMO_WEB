<?php session_start();
/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 25/04/2016
 * Time: 12:27
 */

include_once "../classes/User.php";
$user = new User();
//var_dump($_POST);
if(isset($_POST['submitUser'])){

    $res = $user->init($_POST['tbName'],$_POST['tbLastName'], $_POST['tbEmail'],$_POST['tbPassword'],$_POST['tbPasswordConfirm']);
    //var_dump($res);

    if($res === true) {
        $error = $user->save();
        //var_dump($error);
        if($error !== true) header("Location: ../register.php?error=".$error);
        else {
            header("Location: ../index.php");
        }
    }
    else header("Location: ../register.php?error=".$res);
    /*Validar registre d'usuari*/

}else if (isset($_POST['submitLogin'])){

    if(isset($_POST['tbEmail']) && isset($_POST['tbPassword'])) {
        if ($user->validate($_POST['tbEmail'], $_POST['tbPassword'])) {
            $user->loadByEmail($_POST['tbEmail']);

            $_SESSION['idUser'] = $user->getId();
            //var_dump($user->getId());
            header("Location: ../index.php");
        } else {
            header("Location: ../login.php?error=Login incorrect");
        }
    }else{
        header("Location: ../login.php?error=Login incorrect");
    }
}else if(isset($_POST['submitProfile'])){
    //var_dump($_POST);
    //var_dump($_FILES);
    $error = "";

    if(trim($_FILES['img']['name']) != ""){
        $imatge = carregarFitxer($_FILES['img'],$_POST['idUser']);
        if(trim($imatge) != "") {

            $user->setImg($imatge);
        }
        else $user->setImg(null);
    }else{
        $user->setImg(null);
    }

    $user->load($_POST['idUser']);
    $user->setId($_POST['idUser']);
    $user->setEmail($_POST['tbEmail']);
    $user->setName(($_POST['tbName']));
    $user->setLastname($_POST['tbLastName']);
    if(!$user->setBirth($_POST['tbBirth'])) $error = "Invalid Date of Birth (Yet to be born)";
    $user->setTshirt($_POST['tbTshirt']);
    $user->setClub($_POST['tbClub']);
    $user->setCountry($_POST['tbCountry']);
    $user->setRegion($_POST['tbRegion']);
    $user->setCity($_POST['tbCity']);
    $user->setAddress($_POST['tbAddress']);
    if(trim($_POST['tbPostalCode']) != "") {
        if (!$user->setPostalCode($_POST['tbPostalCode'])) $error = "Invalid Postal Code";
    }
    if(trim($_POST['tbPhone']) != ""){
        if(!$user->setPhone1($_POST['tbPhone'])) $error = "Invalid Phone Number";
    }
    if(trim($_POST['tbPhone2']) != "") {
        if (!$user->setPhone2($_POST['tbPhone2'])) $error = "Invalid Phone Number";
    }
    if(isset($_POST['sport']))$user->setSport($_POST['sport']);

    if($error == "") {
        $error = $user->save(true);

        if($error == "") {
            $files = glob('../images/profile/'.$_POST['idUser'].'/*'); // get all file names
            foreach($files as $file){ // iterate files
                if(is_file($file) && $file != "../images/profile/".$_POST['idUser'].'/'.$imatge ) {
                   unlink($file); // delete file
                }
            }
            header("Location: ../profile.php");
        }
        else header("Location: ../profile.php?error=".$error);
    }else header("Location: ../profile.php?error=".$error);

}

function carregarFitxer($f, $id) {
    $nomFitxer = "";
    //var_dump($f);

    if ($f['error'] == 0) {
        if (!file_exists('../images/profile/'.$id)) {
            mkdir('../images/profile/'.$id, 0777, true);
        }
        echo '../images/profile/'.$id. "/" . $f['name'];
        if (move_uploaded_file($f['tmp_name'], '../images/profile/'.$id. "/" . $f['name'])) {
            $nomFitxer = $f['name'];
        } else {
            $nomFitxer = $f['name'];
            echo "Error en guardar el fitxer al servidor";
        }
    } else {
        echo "Error en carregar l'imatge";
    }

    return $nomFitxer;
}