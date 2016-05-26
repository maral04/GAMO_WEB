<!--==============================head=================================-->
<head>
    <?php
    include_once 'head.php';
    ?>
    <title>GAMO: Event List</title>
    <script>
        $(document).ready(function () {
            $('#sports img').on('click', function () {
                id = $(this).attr('id').replace('img-', '');
                if($(this).hasClass("icon-selected"))window.location.replace("index.php");
                else window.location.replace("index.php?sport="+id);
                /*if ($(this).hasClass('icon-selected')) {
                $('#' + id).prop("checked", false);

                $(this).removeClass('icon-selected');
            } else {
                $('#sports input').prop("checked", false);
                $('#sports img').removeClass('icon-selected');

                $('#' + id).prop("checked", true);
                $(this).addClass('icon-selected');
            }*/
            });
            $(".accordion").on("click", function () {
                //Si troba la class "active", no fa la funció.
                if ($(this).hasClass("active")) {

                    //Apunta fletxes amunt.
                    $('.cte', this).rotate({
                        duration: 1,
                        angle: 0,
                        animateTo: 180
                    })

                    var id = $(this).attr('eventid');

                    $.ajax({
                        // la URL para la petición
                        url: 'http://localhost/GAMO_WEB/api/events/getProves.php',

                        // la información a enviar
                        // (también es posible utilizar una cadena de datos)
                        data: {eventId: id},

                        // especifica si será una petición POST o GET
                        type: 'GET',

                        // el tipo de información que se espera de respuesta
                        dataType: 'json',

                        // código a ejecutar si la petición es satisfactoria;
                        // la respuesta es pasada como argumento a la función
                        success: function (json) {

                            //Recupero la primera prova per saber a quin event pertanyen totes les proves.
                            idDiv = json[0].FK_Id_event;

                            //Eliminem el contingut del panel.
                            $("[eventpanelid='" + idDiv + "']").empty();

                            for (var i = 0; i < json.length; i++) {

                                //El block general de cada prova redirigeix a la fitxa de la prova.
                                $("[eventpanelid='" + idDiv + "']").append("" +
                                    "<div class='block3 click' onclick='location.href=\"fitxaProva.php?id=" + json[i].Id + "\"'\>" +
                                    "<div class='block2'>" +
                                    "<div class='grid_2'>" +
                                        <!-- Imatges (prova) -->
                                    "<img class='' src='images/proves/"+json[i].Id+"/"+json[i].Imatges+"' alt=''>" +
                                    "</div>" +
                                    "<div class='grid_4 g4Gran'>" +
                                        <!-- nom (prova) -->
                                    "<h4>" + json[i].nom + "</h4>" +
                                        <!-- FK_Id_Localitzacio (prova) poblacio (localitzacio) -->
                                    "<a>" + json[i].poblacio + "</a>" +
                                    "<div class='fRight'>" +
                                        <!-- data_hora_inici (prova) -->
                                    "<a>" + json[i].data_hora_inici + "</a>" +
                                    "</div>" +

                                    "<div class='descripcioProva'>" +
                                        <!-- descripcio (prova) -->
                                    "<a>" + json[i].descripcio + "</a>" +
                                    "</div>" +
                                    "<a>Max. Participants: " + json[i].limit_inscrits + "</a>" +
                                    "<div class='gran grid_1 fRight'>" +
                                        <!-- Max Members, desnivellPositiu, Distancia -->
                                    json[i].distancia
                                    + "Km</div>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>" +
                                    "");
                            }
                        },
                        // código a ejecutar si la petición falla;
                        // son pasados como argumentos a la función
                        // el objeto de la petición en crudo y código de estatus de la petición
                        error: function (request, status, error) {
                            alert(request.responseText);
                        },

                        // código a ejecutar sin importar si la petición falló o no
                        complete: function (xhr, status) {
                        }
                    });
                } else {
                    //Apunta fletxes abaix.
                    $('.cte', this).rotate({
                        duration: 1,
                        angle: 0,
                        animateTo: 0
                    })
                }
            });
        });
    </script>
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
                <div  class="click" style ='display: inline-flex;'><div id="titol" onclick="window.location.replace('index.php')">Events </div>
                <div id="sports" >
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
                </div>
                <!-- RecuperarEvents -->
                <?php
                include_once 'classes/DataBase.php';
                $db = new DataBase();
                if(isset($_GET['sport'])){
                    $result = $db->recuperarEvent(false,$_GET['sport']);
                }else{
                    $result = $db->recuperarEvent();
                }


                if ($result){
                while ($event = mysqli_fetch_assoc($result)) {
                $numProves = $db->recuperarNumProves($event['Id']);
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
                echo "
                <div class='block2'>
                    <div class='grid_3'>";
                if($event['imatges'] == null) echo '<img class="" src="images/events/default.png" alt="">';
                else{
                    if(is_file("images/events/".$event['Id']."/".$event['imatges']))
                    echo "<img class='' src='images/events/".$event['Id']."/".$event['imatges']."' alt=''>";
                    else{
                        echo '<img class="" src="images/events/default.png" alt="">';
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
<?php }

} else {
    /*No hi ha cap event!!*/
} ?>
</div>

<div class="grid_4">
    <?php
    include_once 'yourEvents.php';
    ?>
</div>
<div class="clear"></div>
</div>
</div>
</div>
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
</body>
</html>