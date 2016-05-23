<?php
if(!isset($_GET['id']))header("Location: index.php");
?>
<head>
    <?php include_once "head.php";
    include_once "classes/DataBase.php";

    $db = new DataBase();
    $prova = $db->recuperarProva($_GET['id']);

    if(!$prova) header("location: index.php");

    if(isset($_SESSION['idUser'])) {
        $idUser = $_SESSION['idUser'];
    }else{
        $idUser = false;
    }

    ?>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script src="js/loadgpx.js" type="text/javascript"></script>
    <script src="js/loadMap.js" type="text/javascript"></script>
</head>

<body class="" id="top">

<div class="main">
    <?php include_once "header.php"; ?>
    <div class="content">
        <div class="container_12">
            <div class="grid_8">
                <h3 class="h3__head1">Fitxa Prova</h3>
            </div>
            <div class="grid_12">
                <div class="block3">
                    <div class="block2">
                        <?php
                        $desnivellAcumulat = $prova['desnivellPositiu']+$prova['desnivellNegatiu'];
                        if(file_exists("images/proves/".$prova['Id']."/".$prova['Imatges'])) $img = "images/proves/".$prova['Id']."/".$prova['Imatges'];
                        else $img = "images/proves/default.png";
                        echo "<div class='grid_4'>
                                <div style='height:365px;'>";
                        echo"<img class='imgFitxa' src='".$img."' alt=''>";
                        echo "<div class='sportsSobre'>";
                            foreach(explode(',', $prova['esports'])as $sport){
                                if($prova['esports'] != null){
                                    echo "<img class='icoFitxa' src='images/icons/".$sport.".png'>";
                                }
                            }
                        echo"</div>";
                        echo"</div>
                                <div class='grid_11'>
                                    <!--Mapa amb la ruta de la prova.-->
                                    ";
                        if($prova['recorregut'] != null && (strpos($prova['recorregut'], ".gpx")!==false) || (strpos($prova['recorregut'], ".xml")!==false)){
                            echo "<div id='map' idprova='".$prova['Id']."' nomgpx='".$prova['recorregut']."'>";

                        }else{
                            echo "<div>";
                        }
                        echo "</div>";
                            echo "
                            <a href='llistatInscrits.php?idProva=".$prova['Id']."'>
                                <div class='fileUpload btn btn-primary download'>
                                    <img class='cpImg' src='images/icons/mPplW.png'/>
                                    <span class='spanUpload'>Participants List</span>
                                </div></a>
                            ";
                            if($prova['recorregut'] != null && (strpos($prova['recorregut'], ".gpx")!==false) || (strpos($prova['recorregut'], ".xml")!==false)){
                                echo "
                                <a href='track/".$prova['Id']."/".$prova['recorregut']."'>
                                <div class='fileUpload btn btn-primary download fRight'>
                                    <img class='cpImg' src='images/icons/download.png'/>
                                    <span class='spanUpload'>Download</span>
                                </div></a>";
                                }
                            echo " </div>
                            </div>";
                            echo "
                            <div class='grid_7'>
                                <!-- nom (prova) -->
                                <h1 class='eventTitle'>
                                    ".$prova['nom']."
                                </h1>
                                <!-- Població (localitzacio)) -->
                                <a>".$prova['poblacio'].", ".$prova['regio']." (".$prova['estat'].")</a>
                                <div class='fRight'>
                                    <!-- data_hora_inici (prova) -->
                                    <a>Start: ".$prova['data_hora_inici']."</a>
                                </div>
                                <div class='descripcioFitxaProva'>
                                    <!-- Descripció (prova) -->
                                    <a>".$prova['descripcio']." </a>
                                </div>
                                <div class='grid_7 desFitxa'>
                                    <div class='grid_3 campsFitxa'><img class='icoFitxa' src='images/icons/slopeUP.png' alt='Positive Slope'>Positive Slope: ".$prova['desnivellPositiu']."mts</div>
                                    <div class='grid_3 campsFitxa'><img class='icoFitxa' src='images/icons/slopeDOWN.png' alt='Negative Slope'>Negative Slope: ".$prova['desnivellNegatiu']."mts</div>
                                    <div class='grid_3 campsFitxa'><img class='icoFitxa' src='images/icons/slopeSUM.png' alt='Accumulated Slope'>Accumulated Slope: ".$desnivellAcumulat."mts</div>
                                    <a href='llistatInscrits.php?idProva=".$prova['Id']."'><div class='grid_3 campsFitxa'><img class='icoFitxa' src='images/icons/mPpl.png' alt='Participants'>Participants: ".$prova['inscrits']." / ".$prova['limit_inscrits']." <img class='icoFitxa2' src='images/icons/listInscrits.png' alt='Participant List'>(List)</div></a>
                                    <div class='grid_3 campsFitxa'><img class='icoFitxa' src='images/icons/www.png' alt='Organization'><a href='http://".$prova['pagina_organitzacio']."' class='gran'>Organization Page</a></div>
                                    <!-- 8digits+km o queda malament. -->
                                    <div class='grid_2 gran campsFitxa'><img class='icoFitxa' src='images/icons/distance.png' alt='Distance'>".$prova['distancia']."Km</div>";
                                    if($idUser) {
                                        $sql = "SELECT count(*) FROM inscripcio WHERE FK_id_prova = " . $prova['Id'] . " AND id_participant = " . $idUser;
                                        $conn = $db->connect();

                                        $result = $conn->query($sql);
                                        $inscrit = mysqli_fetch_assoc($result);
                                        if($inscrit['count(*)'] < 1){
                                            echo "<a href='actions/validateInscripcio.php?idProva=".$prova['Id']."&idUser=".$idUser."' class='gran'><div class='grid_1 gran campsFitxa joinBtn link--kukuri l3'>JOIN</div></a>";
                                        }else{
                                            echo "<a href='actions/validateInscripcio.php?leave=true&idProva=".$prova['Id']."&idUser=".$idUser."' class='gran'><div class='grid_1 gran campsFitxa leaveBtn link--kukuri l3'>LEAVE</div></a>";
                                        }
                                    }
                                    echo "
                                </div>
                            </div>
                            ";
                        ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
</body>
<footer><?php include_once "footer.html"; ?></footer>