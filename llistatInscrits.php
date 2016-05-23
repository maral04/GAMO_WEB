<head>
    <?php

    include_once "head.php";
    include_once "classes/DataBase.php";

    $db = new DataBase();
    $conn = $db->connect();
    ?>
</head>
<body>
<div class="main">
    <?php include_once "header.php"; ?>

    <div class="content container_12" >
        <?php
        if (isset($_GET['idProva'])) {
            $idProva = $_GET['idProva'];
            $sql = "SELECT prova.nom as nomProva, usuari.nom, usuari.cNom, usuari.gender, (SELECT nom FROM club WHERE usuari.FK_id_club = club.Id) as nomClub FROM inscripcio INNER JOIN prova on Fk_Id_prova = prova.Id INNER JOIN usuari on id_Participant = usuari.id  WHERE prova.Id =" . $idProva;

            $result = $db->getConn()->query($sql);

            echo "<div class='grid_12'>";
                echo "<h3 class='registre h3__head1'></h3>";
            echo "</div>";
            echo "<div class='grid_11 block3'>";
                if ($result->num_rows > 0) {
                    echo "<table class='taulaintro'>";
                    echo "<tr>
                        <th>Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Club</th></tr>
                        ";
                    $i = 0;
                    while ($arrayEvent = mysqli_fetch_assoc($result)) {
                    if($i == 0){
                        $i=1;
                        ?>
                        <script>
                            $( document ).ready(function() {
                                $('.registre').text("List of Participants in <?php echo $arrayEvent['nomProva'] ?>");
                            });
                        </script>
                        <?php
                    }
                        echo "<tr><td>" . $arrayEvent['nom'] . "</td><td>" . $arrayEvent['cNom'] . "</td><td>" . $arrayEvent['gender'] . "</td><td>" . $arrayEvent['nomClub'] . "</td></tr>";
                    }
                    echo "</table>";
                }
            } else {
                header("Location: index.php");
            }
            ?>
        </div>
    </div>
<div class="clear"></div>
</div>
</body>
<footer><?php include_once "footer.html"; ?></footer>
