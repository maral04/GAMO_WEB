<?php

/**
 * Created by PhpStorm.
 * User: uri cabré_
 * Date: 13/5/2016
 * Time: 8:51
 */
include_once "../classes/DataBase.php";
include_once "../classes/Club.php";

if (isset($_POST['submitClub'])) {
    $club= new Club();
    var_dump($_FILES,$_POST);

    if($_POST["tbDescr"] != null &&  $_POST["tbName"]!= null){

        $club->setName($_POST["tbName"]);

        if (!$club->exist()) {

            if(trim($_FILES['img']['name']) != ""){
                $file = $club->carregarFitxer($_FILES["img"],$_POST["tbName"]);
                if(trim($file) != "") $club->setUrlImg($file);
                else $club->setUrlImg(null);
            }else{
                $club->setUrlImg(null);
            }
            $club->validate($_POST["tbName"],$_POST["tbDescr"]);
            header("Location: ../organise.php");
        }else if($_POST["edit"]!=false){

            if(trim($_FILES['img']['name']) != ""){
                $file = $club->carregarFitxer($_FILES["img"],$_POST["tbName"]);
                if(trim($file) != "") $club->setUrlImg($file);
                else $club->setUrlImg(null);
            }else{
                $club->setUrlImg(null);
            }
            $club->validate($_POST["tbName"],$_POST["tbDescr"],$_POST["edit"]);
            header("Location: ../organise.php");


        }

}
}



