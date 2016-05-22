<?php
/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 22/05/2016
 * Time: 17:14
 */
if()
$sql = "SELECT prova.nom as nomProva, usuari.nom, usuari.cNom, (SELECT nom FROM club WHERE usuari.FK_id_club = club.Id) as nomClub FROM inscripcio INNER JOIN prova on Fk_Id_prova = prova.Id INNER JOIN usuari on id_Participant = usuari.id  WHERE prova.Id =".$idProva;

$result = $db->getConn()->query($sql);

if ($result->num_rows > 0) {
    while( $arrayEvent = mysqli_fetch_assoc($result)){