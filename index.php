<!--==============================head=================================-->
<head>
    <?php
    include_once 'head.php';
    ?>
    <title>GAMO: Event List</title>
    <script src="js/ajaxIndex.js"></script>
</head>
<body class="" id="top">
<div class="main">
    <!--==============================header=================================-->
    <?php
    include_once 'header.php';
    ?>
    <!--==============================Content=================================-->
    <div class="content">
        <div class="container_12">
            <div class="grid_8">
                <div class="click" style ='display: flex;'><div id="titol" onclick="window.location.replace('index.php')">Events </div>
                <div id="sports" class="sports-filter">
                    <div>
                        <?php
                            if(isset($_GET['sport'])){
                                $esport = trim($_GET['sport']);
                            }else{
                                $esport = false;
                            }
                        ?>
                        <img id='img-bike' <?php if ($esport === "bike")echo "class='icon-selected'" ?>  src='images/icons/bike.png'/>
                    </div>
                    <div>
                        <img id='img-hiking' <?php if ($esport === "hiking")echo "class='icon-selected'" ?>  src='images/icons/hiking.png'/>
                    </div>
                    <div>
                        <img id='img-skiing' <?php if ($esport === "skiing")echo "class='icon-selected'" ?>  src="images/icons/skiing.png"/>
                    </div>
                    <div>
                        <img id='img-trail' <?php if ($esport === "trail")echo "class='icon-selected'" ?>  src="images/icons/trail.png"/>
                    </div>
                    <div>
                        <img id='img-climbing' <?php if ($esport === "climbing")echo "class='icon-selected'" ?>  src="images/icons/climbing.png"/>
                    </div>
                </div>
                    <div id="buscador">
                        <a href="index.php"><img id='btnCancel' class='icoFitxa2' src='images/icons/cancel.png' alt='Cancel'></a>
                        <input id='eventsSearch' type="text" placeholder="Search">
                        <img id='btnBuscar' class='icoFitxa2' src='images/icons/magnifier.png' alt='Search'>
                    </div>
                </div>
                <!-- RecuperarEvents -->
                <?php
                include_once 'classes/DataBase.php';
                $db = new DataBase();
                $filtres = array();

                if(isset($_GET['pag'])){
                    $pag = $_GET['pag']-1;
                    $filtres['from'] = ($pag*5);
                }else{
                    $filtres['from'] = 0;
                }

                if(isset($_GET['sport'])){
                    $filtres['sport']=$_GET['sport'];
                }

                if(isset($_GET['search'])){
                    $filtres['search']=$_GET['search'];
                }

                $result = $db->recuperarEvent(false,$filtres);
                $cont = 0;

                if ($result){
                while ($event = mysqli_fetch_assoc($result)) {
                $numProves = $db->recuperarNumProves($event['Id']);
                if($numProves['COUNT(*)'] <= 0) break;
                //Si té una prova es prepara el link directe a aquesta.
                if ($numProves['COUNT(*)'] <= 1) {

                    $conn = $db->connect();
                    $sql2 = "SELECT * FROM prova WHERE FK_Id_event = " . $event['Id'];
                    $result2 = $conn->query($sql2);

                    if ($result2->num_rows > 0) {
                        $proves = mysqli_fetch_assoc($result2);
                        echo "<div class='block3 click' onclick='location.href=\"fitxaProva.php?id=" . $proves['Id'] . "\"'>";
                    }
                } else {
                    //Si l'event té més d'una prova, es preparen events desplegables.
                    echo "<div class='block3 accordion click eventDiv' eventid='" . $event['Id'] . "'>";
                }

                if ($numProves['COUNT(*)'] <= 1) {
                    echo "
                    <div class='block2'>
                        <div class='grid_3'>";
                    if ($proves['Imatges'] == null) echo '<img class="imgIndex" src="images/events/default.png" alt="">';
                    else {
                        if (is_file("images/proves/" . $proves['Id'] . "/" . $proves['Imatges']))
                            echo "<img class='imgIndex' src='images/proves/" . $proves['Id'] . "/" . $proves['Imatges'] . "' alt=''>";
                        else {
                            echo '<img class="imgIndex" src="images/proves/default.png" alt="">';
                        }
                    }
                }else{
                    echo "
                    <div class='block2'>
                        <div class='grid_3'>";
                    if ($event['imatges'] == null) echo '<img class="imgIndex" src="images/events/default.png" alt="">';
                    else {
                        if (is_file("images/events/" . $event['Id'] . "/" . $event['imatges']))
                            echo "<img class='imgIndex' src='images/events/" . $event['Id'] . "/" . $event['imatges'] . "' alt=''>";
                        else {
                            echo '<img class="imgIndex" src="images/events/default.png" alt="">';
                        }
                    }
                }
                ?>
            </div>
            <div class="grid_4">
                <!-- Titol (event) -->
                <h1 class="eventTitle"><?php echo $event['titol'] ?></h1>
                <!-- Població (localitzacio)) -->
                <a><?php echo $event['poblacio'] ?></a>
                <div class="fRight">
                    <!-- Data Inicial (event) -->
                    <a><?php echo date("Y-m-d", strtotime($event['dataInici'])) ?></a>
                </div>
                <div class="descripcioEvent">
                    <!-- Descripció (event) -->
                    <a><?php echo $event['descripcio'] ?></a>
                </div>
                <?php
                //Si l'event només té una prova, mostra més informació d'aquesta.
                if ($numProves['COUNT(*)'] == 1) {
                    $prova = $db->recuperarProves($event['Id']);
                    echo "<a>Màx. Participants " . $prova['limit_inscrits'] . "</a>
                        <div class='grid_1 fRight'>
                            <a class='gran fRight'>" . $prova['distancia'] . "Km</a>
                        </div>";
                } else {
                    //Mostra que es pot expandir si té proves.
                    echo "<div class='cte''>
                    <img class='cteImg' src='images/icons/downArrow.png' alt=''>
                    <a>  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  </a>
                    <img class='cteImg' src='images/icons/downArrow.png' alt=''>
                    <a>  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  </a>
                    <img class='cteImg' src='images/icons/downArrow.png' alt=''>
                    </div>";
                }
                ?>
            </div>
        </div>
    </div>
<?php
//Si hi ha més d'una prova prepara el panell per a possar-les.
if ($numProves['COUNT(*)'] > 1) {
    echo "<div class='panel' eventpanelid='" . $event['Id'] . "'></div>";
}
?>
<?php
$cont++;
}

}
if($cont == 0) echo "<div id='div-noresults'><p>No events were found with the given filters.</p><img src='images/icons/mountains.png' id='img-noresults'></div>";
?>
</div>

<div class="grid_3 sideGrid">
    <div  id="your-events">
    <?php include_once 'includes/yourEvents.php'; ?>
    </div>
    <div id="banner">
        <img src="images/events/banner/olla.jpg">
        <img src="images/events/banner/CamideCavalls360.jpg">
        <img src="images/events/banner/ultramontseny.png">
        <img src="images/events/banner/mtbrace.jpg">
    </div>
</div>

<div class="grid_8" style="text-align: center;">
    <ul class="pagination">
        <?php
            if(isset($filtres['sport']) || isset($filtres['search'])){
                $strFiltre = "&";
                if(isset($filtres['sport']))$strFiltre .= "sport=".$filtres['sport'];
                if(isset($filtres['search']))$strFiltre .= "search=".$filtres['search'];

                $numEvents = $db->recuperarNumEvents($filtres);
            }else{
                $numEvents = $db->recuperarNumEvents();
            }
            $tmp = $numEvents['count(*)']/5;
            $numPag = ceil($tmp);
            $i = 1;
            if($numPag > 1) {

                if(isset($strFiltre)) echo "<li><a href='?pag=1" . $strFiltre. "'> « </a></li>";
                else echo "<li><a href='index.php'>«</a></li>";

                while ($i <= $numPag) {
                    if ($i != 1){
                        //Si cliquen qualsevol pàg, menys la 1.
                        echo "<li><a ";
                        if(isset($_GET['pag'])){
                            if($i == $_GET['pag']){
                                echo "class='active'";
                            }
                        }
                        if(isset($strFiltre)) echo " href='?pag=" . $i . $strFiltre. "'>" . $i . "</a></li>";
                        else echo " href='?pag=" . $i . "'>" . $i . "</a></li>";
                    }else{
                        //Si cliquen a la pàg1.
                        echo "<li><a ";
                        if(!isset($_GET['pag'])){
                            echo "class='active'";
                        }else{
                            if($_GET['pag'] == 1)echo "class='active'";
                        }
                        if(isset($strFiltre)) echo " href='?pag=1" . $strFiltre. "'> " . $i . " </a></li>";
                        else echo "href='index.php'>" . $i . "</a></li>";
                        //echo "href='index.php'>" . $i . "</a></li>";
                    }
                    $i++;
                }
                echo "<li><a href='?pag=".$numPag."'>»</a></li>";
            }
        ?>
    </ul>
</div>
<div class="clear"></div>
</div>
</div>
</div>
<input type="text" id="ipServer" name="" value="<?php echo "$_SERVER[HTTP_HOST]" ?>">
</body>
<!--==============================footer=================================-->
<footer>
    <?php
    include_once 'footer.html';
    ?>
</footer>
<script type="text/javascript">
    <!-- Funció canvi Current Page -->
    $(document).ready(function () {
        //Remou current de tots i inclou l'actual.
        /*$(".li1").attr("class", "li1");*/
        $(".li2").attr("class", "li2 current");
        $(".li3").attr("class", "li3");

        $( "#eventsSearch" ).submit(function( event ) {
            alert( "Handler for .submit() called." );
            event.preventDefault();
        });

        $( "#btnBuscar" ).click(function() {
            window.location.href = "index.php?search="+$("#eventsSearch").val().trim();
        });

        $("#eventsSearch").bind("keypress", {}, keypressInBox);

        function keypressInBox(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13 && $("#eventsSearch").val().trim() != "") { //Enter keycode
                window.location.href = "index.php?search="+$("#eventsSearch").val().trim();
            }
        };
    });
    <!-- Funció D'accordion -->
    var acc = document.getElementsByClassName("accordion");
    var i;
    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function(){
            this.classList.toggle("active");
            this.nextElementSibling.classList.toggle("show");
        }
    }
</script>
</html>