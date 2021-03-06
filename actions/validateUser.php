<?php session_start();

include_once "../classes/User.php";
$user = new User();
//var_dump($_POST);

if(isset($_POST['submitUser'])){

    $res = $user->init($_POST['tbName'],$_POST['tbLastName'], $_POST['tbEmail'],$_POST['tbPassword'],$_POST['tbPasswordConfirm']);

    if($res === true) {
        $error = $user->save();
        if($error !== true){
            saveData();
            header("Location: ../register.php?error=".$error);
        }else {
            $_SESSION['idUser'] = $user->getId();
            $_SESSION['nameUser'] = $user->getName();
            $_SESSION['imgUser'] = $user->getImg();
            header("Location: ../profile.php");
        }
    }else{
        saveData();
        header("Location: ../register.php?error=".$res);
    }
    /*Validar registre d'usuari*/

}else if (isset($_POST['submitLogin'])){

    if(isset($_POST['tbEmail']) && isset($_POST['tbPassword'])) {
        if ($user->validate($_POST['tbEmail'], $_POST['tbPassword'])) {
            $user->loadByEmail($_POST['tbEmail']);

            $_SESSION['idUser'] = $user->getId();
            $_SESSION['nameUser'] = $user->getName();
            $_SESSION['imgUser'] = $user->getImg();
            var_dump($_SESSION);
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
    if(isset($_POST['gender']))$user->setGender($_POST['gender']);


    if(trim($_FILES['img']['name']) != ""){
        $imatge = carregarFitxer($_FILES['img'],$_POST['idUser']);
        if(trim($imatge) != "") {

            $user->setImg($imatge);
        }
        else $user->setImg(null);
    }else{
        $user->setImg(null);
    }

    if($error == "") {
        $error = $user->save(true);

        if($error == "") {
            if($user->getImg()  != null) {
                /*Si el form ens envia alguna imatge eliminem totes les imatges d'aquest usuari*/
                $files = glob('../images/profile/' . $_POST['idUser'] . '/*'); // get all file names
                foreach ($files as $file) { // iterate files

                    if (is_file($file) && $file != "../images/profile/" . $_POST['idUser'] . '/' . $imatge) {
                        unlink($file); // delete file
                    }
                }
            }
            header("Location: ../profile.php");
        } else header("Location: ../profile.php?error=".$error);
    }else header("Location: ../profile.php?error=".$error);

}

function carregarFitxer($f, $id) {
    $temp = explode(".", $f["name"]);
    $newName = $id.".".end($temp);

    $nomFitxer = "";
    //var_dump($f);

    if ($f['error'] == 0) {
        if (!file_exists('../images/profile/'.$id)) {
            mkdir('../images/profile/'.$id, 0777, true);
        }
        //echo '../images/profile/'.$id. "/" . $f['name'];
        if (move_uploaded_file($f['tmp_name'], '../images/profile/'.$id. "/" . $f['name'])) {
            rename('../images/profile/'.$id. "/" . $f['name'],'../images/profile/'.$id. "/" . $newName);
            $nomFitxer = $newName;
        } else {
            rename('../images/profile/'.$id. "/" . $f['name'],'../images/profile/'.$id. "/" . $newName);
            $nomFitxer = $newName;
            echo "Error en guardar el fitxer al servidor";
        }
    } else {
        echo "Error en carregar l'imatge";
    }
    return $nomFitxer;
}

//Guarda les dades en cas que l'usuari s'equivoqui en algo.
function saveData(){
    $_SESSION['nomTMP'] = $_POST['tbName'];
    $_SESSION['lastTMP'] = $_POST['tbLastName'];
    $_SESSION['mailTMP'] = $_POST['tbEmail'];
}