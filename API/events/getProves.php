<?php
/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 02/05/2016
 * Time: 9:44
 */
include_once "../../classes/DataBase.php";
$db = new DataBase();
$conn = $db->connect();

if(isset($_GET['eventId'])){
    $sql = "SELECT * FROM prova WHERE FK_Id_event = ".$_GET['eventId'];

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while( $proves= mysqli_fetch_assoc($result)){
            echo json_encode($proves);
        }
    } else {
        return false;
    }
}

$conn->close();