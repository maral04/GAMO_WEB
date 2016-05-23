<?php

/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 02/05/2016
 * Time: 9:44
 */
include_once "../classes/User.php";
include_once "../classes/Prova.php";
include_once "../classes/DataBase.php";

$db = new DataBase();
$conn = $db->connect();

if(isset($_GET['leave']) && isset($_GET['idUser']) && isset($_GET['idProva'])){
    if ($conn != null) {

        $mysql = mysqli_prepare($conn, "DELETE FROM inscripcio WHERE  id_participant = ".$_GET['idUser']." AND FK_id_prova= ".$_GET['idProva']);

        if (mysqli_stmt_execute($mysql)) header("Location: ../fitxaProva.php?id=".$_GET['idProva']);
        else die(mysqli_stmt_error($mysql));
    }
}else {
    if (isset($_GET['idProva']) && isset($_GET['idUser'])) {
        $error = "";

        if ($conn != null) {

            $mysql = mysqli_prepare($conn, "INSERT INTO inscripcio (FK_id_prova, id_participant, data_hora)  VALUES (?,?,?)");
            $data = date("d-m-Y");
            mysqli_stmt_bind_param($mysql, "sss", $_GET['idProva'], $_GET['idUser'], $data);

            if (mysqli_stmt_execute($mysql)) header("Location: ../fitxaProva.php?id=".$_GET['idProva']);
            else die(mysqli_stmt_error($mysql));
        }
    }
}