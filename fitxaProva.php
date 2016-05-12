<?php
if(!isset($_GET['id']))header("Location: index.php");
?>
<head>
    <?php include_once "head.php";
    include_once "classes/DataBase.php";

    $db = new DataBase();
    $prova = $db->recuperarProva($_GET['id']);

    ?>
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
                            echo "<div class='grid_4'><img class='imgFitxa' src='images/page1_img8.jpg' alt=''>
                            <div class='grid_4 desFitxa'>
                                <div class='grid_3 campsFitxa'><img class='icoFitxa' src='images/icons/slopeUP.png' alt='Positive Slope'> Positive Slope: ".$prova['desnivellPositiu']."mts</div>
                                <div class='grid_3 campsFitxa'><img class='icoFitxa' src='images/icons/slopeDOWN.png' alt='Negative Slope'> Negative Slope: ".$prova['desnivellNegatiu']."mts</div>
                                <div class='grid_3 campsFitxa'>Accumulated Slope: ".$prova['desnivellAcumulat']."mts</div>
                                <div class='grid_2 campsFitxa'>Max. Participants: ".$prova['limit_inscrits']."</div>
                                <div class='grid_1 gran campsFitxa'>".$prova['distancia']."Km</div>
                            </div>
                            </div>";
                            // , tipus sport, club
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
                                    <a>".$prova['descripcio']." FD</a>
                                </div>
                                <a>asd</a>
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