<?php
/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 19/05/2016
 * Time: 12:13
 */
include_once "../classes/User.php";
include_once "../classes/Prova.php";
$db = new DataBase();
$conn = $db->connect();
if(isset($_GET['idProva']) && isset($_GET['idUser'])){
    $error = "";

    if ($conn != null) {

        $mysql = mysqli_prepare($conn, "INSERT INTO inscripcio (FK_id_prova, id_participant, data_hora)  VALUES (?,?,?)");
        $data = date_parse ("".getdate());
        mysqli_stmt_bind_param($mysql, "sss", $_GET['idProva'] ,$_GET['idUser'], $data );

        if (mysqli_stmt_execute($mysql)) return true;
        else die(mysqli_stmt_error($mysql));
    }
}