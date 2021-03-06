<head>
    <?php include_once "head.php";
    include_once "classes/DataBase.php";
    include_once "classes/User.php";

    $db = new DataBase();
    $usuari = new User();

    if(isset($_SESSION['idUser'])) {
        $arrayUser = $usuari->load($_SESSION['idUser']);
        //var_dump($arrayUser);
    }else{
        header("Location: login.php");
    }
    ?>
</head>

<body class="" id="top">

<div class="main">
    <?php include_once "header.php"; ?>
    <!--Funció canvi Color depenent CurrentL-->
    <script type="text/javascript">
        $(document).ready(function () {
            //Remou current de tots i inclou a l'actual.
            $(".l1").attr("class", "l1 link link--kukuri");
            $(".l2").attr("class", "l2 link link--kukuri currentL");
            $(".l3").attr("class", "l3 link link--kukuri");
        });
    </script>
    <div class="container_12">
        <div class="grid_10">
            <h3 class="registre h3__head1">Organize</h3>
        </div>
        <div class="grid_11 block3">
            <div class='grid_3'>
                <div class='form-group'>
                    <a href='createEvent.php' class='spanUpload'>
                        <div style='width:180px;' class='fileUpload fuv2 btn btn-primary prImg' >
                            <img  class='cpImg' src='images/icons/eventCalendar.png'/>
                            Create MultiEvent
                        </div>
                    </a>
                </div>
            </div>
            <div class="grid_3">
                <div class="form-group">
                    <a href="createProva.php" class="spanUpload">
                        <div class="fileUpload fuv2 btn btn-primary prImg" >
                            <img class="cpImg" src="images/icons/provaDud.png"/>
                            Create Event
                        </div>
                    </a>
                </div>
            </div>
            <div class="grid_3">
                <div class="form-group">
                    <a href="createClub.php" class="spanUpload">
                        <div class="fileUpload fuv2 btn btn-primary prImg" >
                            <img class="cpImg" src="images/icons/shield.png"/>
                            Create Club
                        </div>
                    </a>
                </div>
            </div>
            </br></br></br></br>
            <?php
                $arrayEvent = false;

                $sql = "SELECT * FROM event WHERE idOrganitzador = ".$_SESSION['idUser'];

                $result = $db->getConn()->query($sql);

                if ($result->num_rows > 0) {
                   while( $arrayEvent = mysqli_fetch_assoc($result)){

                        if($arrayEvent != false){?>
                            <div class="grid_9">

                                <div class='block3 click eventDiv' onclick="location.href='createEvent.php?eventId=<?php echo $arrayEvent['Id'];?>'">
                                    <div class='block2'>
                                        <div class='grid_7'>
                                            <div class="grid_2">
                                                <?php

                                                if($arrayEvent['imatges'] == null) echo '<img class="" src="images/events/default.png" alt="">';
                                                else {
                                                    if(is_file("images/events/".$arrayEvent['Id']."/".$arrayEvent['imatges']))
                                                    echo "<img class='' src='images/events/".$arrayEvent['Id']."/".$arrayEvent['imatges']."' alt=''>";
                                                    else echo"<img class='' src='images/events/default.png' alt=''>";
                                                }
                                                ?>
                                                <!--<img class="" src="images/events/<?php echo $arrayEvent['Id']."/".$arrayEvent['imatges']?>" alt=""> -->
                                            </div>
                                            <div class="grid_4">
                                                <h1 class="eventTitle"><?php echo $arrayEvent['titol'] ?></h1>
                                                <a><?php echo $arrayEvent['poblacio'] ?></a>
                                                <div class="fRight">
                                                    <a><?php echo date("Y-m-d", strtotime($arrayEvent['dataInici'])) ?></a>
                                                </div>
                                                <div class="descripcioEvent">
                                                    <!-- Descripció (event) -->
                                                    <a><?php echo $arrayEvent['descripcio'] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="fRight deleteImg" disabled href="">
                                            <img class="cpImg" src="images/icons/delete.png"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        $proves = $db->recuperarProves($arrayEvent['Id'], true);
                        if($proves !== false) {
                            while ($prova = mysqli_fetch_assoc($proves)) {
                                ?>
                                <div class='grid_8'>
                                    <div class='block3 click' onclick="location.href='createProva.php?provaId=<?php echo $prova['Id'];?>'">
                                        <div class='block2'>
                                            <div class='grid_2'>
                                                <?php
                                                if($prova['Imatges'] == null) echo '<img class="" src="images/events/default.png" alt="">';
                                                else{
                                                    if(is_file("images/proves/".$prova['Id']."/".$prova['Imatges']))
                                                    echo "<img class='' src='images/proves/".$prova['Id']."/".$prova['Imatges']."' alt=''>";
                                                    else echo "<img class='' src='images/proves/default.png' alt=''>";

                                                }
                                                ?>
                                                <!--<img class="" src="images/proves/<?php echo $prova['Id']."/".$prova['Imatges']?>" alt="">-->
                                            </div>
                                            <div class='grid_4 g4Gran'>
                                                <h4><?php echo $prova['nom'] ?></h4>
                                                <a><?php echo $prova['poblacio'] ?></a>
                                                <div class='fRight'>
                                                    <a><?php echo $prova['data_hora_inici'] ?></a>
                                                </div>
                                                <div class='descripcioProva'>
                                                    <a><?php echo $prova['descripcio'] ?></a>
                                                </div>
                                                <a>Max. Participants: <?php echo $prova['limit_inscrits'] ?></a>
                                                <div class='gran grid_1 fRight'>
                                                    <?php echo $prova['distancia'] . "Km" ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }

                        }
                       echo "<div class='grid_8'>
                                <div class='block3 click campsFitxa' style='text-align: center; background-color: #DFFBDE ;' onclick=\"location.href='createProva.php?eventId=".$arrayEvent['Id']."'\">
                                    <div>
                                        <h2 class='h2v2'><img src='images/icons/add.png'>Add Event</h2>
                                    </div>
                                </div>
                              </div>";
                   }
                }
            ?>
            <?php

            ?>

        </div>
    </div>
    <div class="clear"></div>
</div>
</body>
<footer><?php include_once "footer.html"; ?></footer>