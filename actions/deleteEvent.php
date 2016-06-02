<?php
if(isset($_SESSION['idUser'])) {
    $arrayUser = $usuari->load($_SESSION['idUser']);

}else{
    header("Location: login.php");
}