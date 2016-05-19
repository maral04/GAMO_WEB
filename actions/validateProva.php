<?php
session_start();
var_dump($_POST);
include_once "../classes/Prova.php";
include_once "../classes/Event.php";
$prova = new Prova();
 var_dump($_SESSION['idUser']);
if(isset($_SESSION['idUser'])) $idUser = $_SESSION['idUser'];
else header("location: ../login.php");

if(isset($_POST['submitProva'])){
    //var_dump($_POST['sport']);
    $error = $prova->init($idUser,$_POST['tbName'],$_POST['tbDescription'],$_POST['tbIniDate'],$_POST['tbIniTime'],$_POST['tbDistance'],$_POST['tbPositive'],$_POST['tbNegtive'],$_POST['tbCheckpoints'],$_POST['tbTimeLimit'],$_POST['sport'],$_POST['tbCountry'],$_POST['tbRegion'],$_POST['tbCity'],$_POST['tbAddress'],$_POST['tbCp'],$_POST['tbManager'],$_POST['tbPrice'],$_POST['tbInscripcionsIni'],$_POST['tbInscripcionsFin'],$_POST['tbLimitInscrits']);
    if($_POST['submitProva'] == 'New prova') $result = $prova->save($_POST['idEvent']);
    else {
        $prova->setIdEvent($_POST['idEvent']);
        $result = $prova->save();
    }
    echo "result ".$result;
    //var_dump($_POST);

    if(is_numeric($result)){
        echo "Numeric";
        if(trim($_FILES['tbImages']['name']) != ""){
           // echo "name ".$_FILES['tbImages'];
            $file = carregarFitxer($_FILES['tbImages'],$result,1);
            if(trim($file) != "") $prova->setImg($file);
            else $prova->setImg(null);
        }else{
            echo "Null";
            $prova->setImg(null);
        }
        if(trim($_FILES['tbTrack']['name']) != ""){
            // echo "name ".$_FILES['tbImages'];
            $file2 = carregarFitxer($_FILES['tbTrack'],$result,2);
            if(trim($file2) != "") $prova->setTrack($file2);
            else $prova->setTrack(null);
        }else{
            echo "Null";
            $prova->setTrack(null);
        }
        $prova->updateImg();
        $prova->updateGpx();

        header("Location: ../createProva.php#profile");
    }else{
        echo $result;
    }

    var_dump($prova);
}else if(isset($_POST['submitEvent'])){
    $event = new Event();
    $event->init($idUser,$_POST['tbName'],$_POST['tbDescription'],$_POST['tbIniDate'],$_POST['tbFinDate'],$_POST['tbCountry'],$_POST['tbRegion'],$_POST['tbCity'],$_POST['tbAddress'],$_POST['tbCp']);
    $result = $event->save();
    echo "result ".$result;

    if(is_numeric($result)){
        echo "Numeric";
        $_SESSION['idEvent'] = $result;
        if(trim($_FILES['tbImages']['name']) != ""){
            // echo "name ".$_FILES['tbImages'];
            $file = carregarFitxer($_FILES['tbImages'],$result,3);
            if(trim($file) != "") $event->setImg($file);
            else $event->setImg(null);
        }else{
            echo "Null";
            $event->setImg(null);
        }
        $event->updateImg();
        header("Location: ../createProva.php");
    }else{
        header("Location: ../createEvent.php?error=".$result);
    }

    var_dump($event);
}

function carregarFitxer($f, $id, $type) {
    $nomFitxer = "";
    //var_dump($f);
    if ($type == 1) $root = '../images/proves/';
    else if($type == 2) $root = '../track/';
    else $root = '../images/events/';

    if ($f['error'] == 0) {
        if (!file_exists($root.$id)) {
            mkdir($root.$id, 0777, true);
        }
        echo $root.$id. "/" . $f['name'];
        if (move_uploaded_file($f['tmp_name'], $root.$id. "/" . $f['name'])) {
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


