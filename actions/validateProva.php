<?php
var_dump($_POST);
include_once "../classes/Prova.php";
$prova = new Prova();


if(isset($_POST['submitProva'])){
    $error = $prova->init($_POST['tbName'],$_POST['tbDescription'],$_POST['tbIniDate'],$_POST['tbIniTime'],$_POST['tbDistance'],$_POST['tbPositive'],$_POST['tbNegtive'],$_POST['tbCheckpoints'],$_POST['tbTimeLimit'],$_POST['sport'],$_POST['tbCountry'],$_POST['tbRegion'],$_POST['tbCity'],$_POST['tbAddress'],$_POST['tbCp'],$_POST['tbManager'],$_POST['tbPrice'],$_POST['tbInscripcionsIni'],$_POST['tbInscripcionsFin'],$_POST['tbLimitInscrits']);
    $result = $prova->save();
    echo "result ".$result;

    if(is_numeric($result)){
        echo "Numeric";
        if(trim($_FILES['tbImages']['name']) != ""){
           // echo "name ".$_FILES['tbImages'];
            $file = carregarFitxer($_FILES['tbImages'],$_POST['idUser']);
            if(trim($file) != "") $prova->setImg($file);
            else $prova->setImg(null);
        }else{
            echo "Null";
            $prova->setImg(null);
        }
        $prova->updateImg();
    }else{
        echo $result;
    }

    var_dump($prova);
}

function carregarFitxer($f, $id) {
    $nomFitxer = "";
    //var_dump($f);

    if ($f['error'] == 0) {
        if (!file_exists('../images/events/'.$id)) {
            mkdir('../images/events/'.$id, 0777, true);
        }
        echo '../images/events/'.$id. "/" . $f['name'];
        if (move_uploaded_file($f['tmp_name'], '../images/events/'.$id. "/" . $f['name'])) {
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


