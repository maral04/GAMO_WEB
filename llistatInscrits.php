<head>
<?php
/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 22/05/2016
 * Time: 17:14
 */

include_once "classes/DataBase.php";
include_once "head.php";
include_once "classes/DataBase.php";

$db = new DataBase();
$conn = $db->connect();
?>
</head>
<body>
<div class="main">

    <?php include_once "header.php"; ?>

    <div class="container_12">
        <div class="block3 grid_12"
        <?php

            if(isset($_GET['idProva']) ) {
                $idProva = $_GET['idProva'];
                $sql = "SELECT prova.nom as nomProva, usuari.nom, usuari.cNom, (SELECT nom FROM club WHERE usuari.FK_id_club = club.Id) as nomClub FROM inscripcio INNER JOIN prova on Fk_Id_prova = prova.Id INNER JOIN usuari on id_Participant = usuari.id  WHERE prova.Id =" . $idProva;

                $result = $db->getConn()->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table style='border:1px solid '>";
                    echo "<tr><th>Name</th><th>Lastname</th><th>Sex</th><th>Club</th></tr>";

                    while ($arrayEvent = mysqli_fetch_assoc($result)) {

                        echo "<tr><td>".$arrayEvent['nom']."</td><td>".$arrayEvent['cNom']."</td><td></td><td>".$arrayEvent['nomClub']."</td></tr>";
                    }
                    echo "</table>";
                }
            }else{
                header("Location: index.php");
            }

        ?>
        </div>
        </div>
<div class="clear"></div>
</div>
</body>
<footer><?php include_once "footer.html"; ?></footer>
