<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 20/05/2016
 * Time: 8:54
 */

if(isset($_SESSION['idUser'])) $idUser = $_SESSION['idUser'];
else header("location: ../login.php");

include_once "../classes/Event.php";
var_dump($_POST);
if(isset($_POST['submitEvent'])) {
    echo "INSERT";
    $event = new Event();
    $event->init($idUser, $_POST['tbName'], $_POST['tbDescription'], $_POST['tbIniDate'], $_POST['tbFinDate'], $_POST['tbCountry'], $_POST['tbRegion'], $_POST['tbCity'], $_POST['tbAddress'], $_POST['tbCp']);
    $result = $event->save();
    echo "result " . $result;

    if (is_numeric($result)) {
        echo "Numeric";
        $_SESSION['idEvent'] = $result;
        if (trim($_FILES['tbImages']['name']) != "") {
            // echo "name ".$_FILES['tbImages'];
            $file = carregarFitxer($_FILES['tbImages'], $result, 3);
            if (trim($file) != "") $event->setImg($file);
            else $event->setImg(null);
        } else {
            echo "Null";
            $event->setImg(null);
        }
        $event->updateImg();
        header("Location: ../createProva.php");
    } else {
        header("Location: ../createEvent.php?error=" . $result);
    }

    var_dump($event);
}else if (isset($_POST['updateEvent'])){
    echo "UPDATE ".$_POST['idEvent'];
    $event = new Event();
    $event->init($idUser, $_POST['tbName'], $_POST['tbDescription'], $_POST['tbIniDate'], $_POST['tbFinDate'], $_POST['tbCountry'], $_POST['tbRegion'], $_POST['tbCity'], $_POST['tbAddress'], $_POST['tbCp'], $_POST['idEvent']);
    $result = $event->save(true);
    echo "result " . $result;

    if (is_numeric($result)) {
        echo "Numeric";
        $_SESSION['idEvent'] = $result;
        if (trim($_FILES['tbImages']['name']) != "") {
            // echo "name ".$_FILES['tbImages'];
            $file = carregarFitxer($_FILES['tbImages'], $result, 3);
            if (trim($file) != "") $event->setImg($file);
            else $event->setImg(null);
        } else {
            echo "Null";
            $event->setImg(null);
        }
        $event->updateImg();
        header("Location: ../organise.php");
    } else {
        header("Location: ../createEvent.php?error=" . $result);
    }

    var_dump($event);

}

function carregarFitxer($f, $id, $type) {
    $files = glob('../images/events/' . $id . '/*'); // get all file names
    foreach ($files as $file) { // iterate files
        unlink($file); // delete file
    }

    $temp = explode(".", $f["name"]);
    $newName = $id.".".end($temp);

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
            rename($root.$id. "/" . $f['name'],$root.$id. "/" . $newName);
            $nomFitxer = $newName;
        } else {
            rename($root.$id. "/" . $f['name'],$root.$id. "/" . $newName);
            $nomFitxer = $newName;
            echo "Error en guardar el fitxer al servidor";
        }
    } else {
        echo "Error en carregar l'imatge";
    }

    return $nomFitxer;
}