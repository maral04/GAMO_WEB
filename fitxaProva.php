<?php
if(!isset($_GET['id']))header("Location: index.php");
?>
<head>
    <?php include_once "head.php";
    include_once "classes/DataBase.php";

    $db = new DataBase();
    $prova = $db->recuperarProva($_GET['id']);

    ?>
<!--
    <script type="text/javascript"
            src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js">
    </script>-->
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
                        else $img = "images/proves/Captura.png";
                            echo "<div class='grid_4'>
                                <img class='imgFitxa' src='".$img."' alt=''>
                                <div class='grid_11'>
                                    <!--Mapa amb la ruta de la prova.-->
                                    <div id='map' idprova='".$prova['Id']."'>
                                </div>
                            </div>
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
                                    <div class='grid_3 campsFitxa'><img class='icoFitxa' src='images/icons/slopeUP.png' alt='Positive Slope'> Positive Slope: ".$prova['desnivellPositiu']."mts</div>
                                    <div class='grid_3 campsFitxa'><img class='icoFitxa' src='images/icons/slopeDOWN.png' alt='Negative Slope'> Negative Slope: ".$prova['desnivellNegatiu']."mts</div>
                                    <div class='grid_3 campsFitxa'><img class='icoFitxa' src='images/icons/slopeSUM.png' alt='Accumulated Slope'>Accumulated Slope: ".$desnivellAcumulat."mts</div>
                                    <div class='grid_3 campsFitxa'><img class='icoFitxa' src='images/icons/mPpl.png' alt='Max. Participants'>Max. Participants: ".$prova['limit_inscrits']."</div>
                                    <div class='grid_3 campsFitxa'><img class='icoFitxa' src='images/icons/www.png' alt='Organization'><a href='http://".$prova['pagina_organitzacio']."' class='gran'>Organization Page</a></div>
                                    <!-- 8digits+km o queda malament. -->
                                    <div class='grid_2 gran campsFitxa'><img class='icoFitxa' src='images/icons/distance.png' alt='Distance'>".$prova['distancia']."Km</div>
                                    <!-- Canviar el link per un unir-se amb el token de la prova -->
                                    <div class='grid_1 gran campsFitxa joinBtn link--kukuri l3'><a href='http://".$prova['pagina_organitzacio']."' class='gran'>JOIN</a></div>
                                </div>
                            </div>";
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