<?php
session_start();
//var_dump($_POST);
include_once "../classes/Prova.php";
include_once "../classes/Event.php";

if(isset($_GET['final'])) {
    if(isset($_SESSION['idEvent']))$_SESSION['idEvent'] = null;
    header("location: ../index.php");

}
$prova = new Prova();
 var_dump($_SESSION['idUser']);
if(isset($_SESSION['idUser'])) $idUser = $_SESSION['idUser'];
else header("location: ../login.php");

if(isset($_POST['submitProva'])){

    $provaAmbEvent = false;
    if(isset($_POST['sport'])) $sport = $_POST['sport'];
    else $sport = "";
    $error = $prova->init($idUser,$_POST['tbName'],$_POST['tbDescription'],$_POST['tbIniDate'],$_POST['tbIniTime'],$_POST['tbDistance'],$_POST['tbPositive'],$_POST['tbNegtive'],$_POST['tbCheckpoints'],$_POST['tbTimeLimit'],$sport,$_POST['tbCountry'],$_POST['tbRegion'],$_POST['tbCity'],$_POST['tbAddress'],$_POST['tbCp'],$_POST['tbManager'],$_POST['tbPrice'],$_POST['tbInscripcionsIni'],$_POST['tbInscripcionsFin'],$_POST['tbLimitInscrits']);
    if($error == "") {
        if (isset($_SESSION['idEvent'])) {
            if ($_SESSION['idEvent'] != null) {
                $provaAmbEvent = true;
                $result = $prova->save($_SESSION['idEvent']);
            } else {

            }
        } else {
            $result = $prova->save();
        }
        /*if($_POST['submitProva'] == 'New prova') $result = $prova->save($_POST['idEvent']);
        else {
            $prova->setIdEvent($_POST['idEvent']);
            $result = $prova->save();
        }
        echo "result ".$result;
        //var_dump($_POST);*/
        echo "result ".$result;
        if (is_numeric($result)) {
            echo "Numeric";
            if (trim($_FILES['tbImages']['name']) != "") {
                // echo "name ".$_FILES['tbImages'];

                $file = carregarFitxer($_FILES['tbImages'], $result, 1);
                if (trim($file) != "") {
                    $prova->setImg($file);
                    $prova->updateImg();
                }
                else $prova->setImg(null);
            } else {
                echo "Null";
                $prova->setImg(null);
            }
            if (trim($_FILES['tbTrack']['name']) != "") {
                // echo "name ".$_FILES['tbImages'];
                $file2 = carregarFitxer($_FILES['tbTrack'], $result, 2);
                if (trim($file2) != "") {
                    $prova->setTrack($file2);
                    $prova->updateGpx();
                }
                else $prova->setTrack(null);
            } else {
                echo "Null";
                $prova->setTrack(null);
            }
            echo "asdasdsa";
            //var_dump($prova->getImg());
            //var_dump($prova->getTrack());
            //die();
            if ($provaAmbEvent == true) header("Location: ../createProva.php?result=multi");
            else header("Location: ../createProva.php?result=unic");
        } else {
            echo $result;
        }
    }else{
        header("Location: ../createProva.php?error=".$error);
    }

    var_dump($prova);
}else if (isset($_POST['updateProva'])){

    if(isset($_POST['sport'])) $sport = $_POST['sport'];
    else $sport = "";

    $error = $prova->init($idUser,$_POST['tbName'],$_POST['tbDescription'],$_POST['tbIniDate'],$_POST['tbIniTime'],$_POST['tbDistance'],$_POST['tbPositive'],$_POST['tbNegtive'],$_POST['tbCheckpoints'],$_POST['tbTimeLimit'],$sport,$_POST['tbCountry'],$_POST['tbRegion'],$_POST['tbCity'],$_POST['tbAddress'],$_POST['tbCp'],$_POST['tbManager'],$_POST['tbPrice'],$_POST['tbInscripcionsIni'],$_POST['tbInscripcionsFin'],$_POST['tbLimitInscrits'],$_POST['idProva']);
    $result = $prova->save($_POST['idEvent'],true);

    if(is_numeric($result)){
        echo "Numeric";
        if(trim($_FILES['tbImages']['name']) != ""){
            // echo "name ".$_FILES['tbImages'];
            $file = carregarFitxer($_FILES['tbImages'],$result,1);
            if(trim($file) != "") $prova->setImg($file);
            else $prova->setImg(null);

            $prova->updateImg();
        }else{
            echo "Null";
            $prova->setImg(null);
        }
        if(trim($_FILES['tbTrack']['name']) != ""){
            // echo "name ".$_FILES['tbImages'];
            $file2 = carregarFitxer($_FILES['tbTrack'],$result,2);

            if(trim($file2) != "") $prova->setTrack($file2);
            else $prova->setTrack(null);

            $prova->updateGpx();
        }else{
            echo "Null";
            $prova->setTrack(null);
        }

        //var_dump($prova->getTrack());
        //die();

        header("Location: ../organize.php");
    }else{
        echo $result;
    }
}

function carregarFitxer($f, $id, $type) {


    $temp = explode(".", $f["name"]);
    $newName = $id.".".end($temp);
    $nomFitxer = "";
    //var_dump($f);
    if ($type == 1) $root = '../images/proves/';
    else if($type == 2) $root = '../track/';
    else $root = '../images/events/';

    $files = glob($root . $id . '/*'); // get all file names
    foreach ($files as $file) { // iterate files
        unlink($file); // delete file
    }

    if ($f['error'] == 0) {
        if (!file_exists($root.$id)) {
            mkdir($root.$id, 0777, true);
        }
        echo $root.$id. "/" . $f['name'];
        if (move_uploaded_file($f['tmp_name'], $root.$id. "/" . $f['name'])) {
            echo $root.$id. "/" . $f['name']." + ".$root.$id. "/" . $newName."<br>";
            rename($root.$id. "/" . $f['name'],$root.$id. "/" . $newName);
            $nomFitxer = $newName;
        } else {
            echo $root.$id. "/" . $f['name']." + ".$root.$id. "/" . $newName."<br>";

            rename($root.$id. "/" . $f['name'],$root.$id. "/" . $newName);
            $nomFitxer = $newName;
            echo "Error en guardar el fitxer al servidor";
        }
    } else {
        echo "Error en carregar l'imatge";
    }
    return $nomFitxer;
}


