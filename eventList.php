<!--==============================head=================================-->
<head>
    <?php
    include_once 'head.php';
    ?>
    <title>GAMO: Event List</title>
    <script>
        $(document).ready(function(){
            $(".accordion").on("click", function() {
                //Si troba la class "active", no fa la funció.
                if($(this).hasClass("active")){

                    //Netejar Panel.
                    //S'ha de fer.

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

                            //Afegeixo l'ID de l'event al panel obert amb un atribut "especial".
                            $(".panel.show").attr("eventpanelid"+idDiv, idDiv);

                            //Eliminem el contingut del panel.
                            $("[eventpanelid"+idDiv+"='"+idDiv+"']").empty();

                            for(var i = 0; i < json.length;i++){

                                $("[eventpanelid"+idDiv+"='"+idDiv+"']").append("<div>AH</div>");

                                console.log(json[i].Id);


                                //$("[eventid='"+idDiv+"']").append("<div class='panel'>Cosa</div>");

                                //$(this).getElementsByClassName('panel');


                                //<div class='panel'>asdasd</div>


                                //console.log(json[i]);


                                //console.log(idDiv);


                                //console.log($("[eventid=idDiv]"));

                                //$("[eventid='"+idDiv+"']").append("<div>AH</div>");
                                //$("[eventid='"+idDiv+"']").find('panel').append("<div>AH</div>");
                                //$("[eventid=2]").append("<div>AH</div>");


                                //$('')
                                    /*
                                <div class='block3'>
                                    <div class='block2'>
                                        <div class='grid_2'>
                                            <!-- Imatges (prova) -->
                                            <img class='' src='images/page1_img6.jpg' alt=''>
                                        </div>
                                        <div class='grid_4'>
                                        <!-- nom (prova) -->
                                            <h4>Ultra Second TrailRaceMasterPum</h4>

                                            <!-- FK_Id_Localitzacio (prova) poblacio (localitzacio) -->
                                            <a>Barcelinonino</a>
                                            <div class='fRight'>
                                                <!-- data_hora_inici (prova) -->
                                                <a>2016-04-05 13:30:00</a>
                                            </div>
                                            <div class='descripcioProva'>
                                                <!-- descripcio (prova) -->
                                                <a>SDIASJDA LALALALASD</a>
                                            </div>
                                            <a></a>
                                            <div class='grid_1 fRight'>
                                                <!-- SIDA Max Members, desnivellPositiu, Distancia -->
                                            </div>
                                        </div>
                                    </div>
                                </div>*/
                            }
                        },

                        // código a ejecutar si la petición falla;
                        // son pasados como argumentos a la función
                        // el objeto de la petición en crudo y código de estatus de la petición
                        error: function (request, status, error) {
                            alert(request.responseText);
                            console.log(error);
                        },

                        // código a ejecutar sin importar si la petición falló o no
                        complete: function (xhr, status) {
                        }
                    });
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
    <!--Funció canvi Current-->
    <script type="text/javascript">
        $(document).ready(function () {
            //Remou current de tots i inclou a l'actual.
            $(".li1").attr("class", "li1");
            $(".li2").attr("class", "li2 current");
            $(".li3").attr("class", "li3");
        });
    </script>
    <!--==============================Content=================================-->
    <div class="content">
        <div class="container_12">
            <div class="grid_8">
                <h3 class="h3__head1">Events</h3>
                <!-- RecuperarEvents -->
                <?php
                include_once 'classes\DataBase.php';
                $db = new DataBase();
                $result = $db->recuperarEvent();
                while ($event = mysqli_fetch_assoc($result)) {
                $numProves = $db->recuperarNumProves($event['Id']);

                if ($numProves['COUNT(*)'] <= 1) {
                    echo "<div class='block3'>";
                } else {
                    //Si l'event té més d'una prova, es preparen events desplegables.
                    echo "<div class='block3 accordion click' eventid='".$event['Id']."'>";
                }
                echo "
                <div class='block2'>
                    <div class='grid_3'>";
                //Si la prova té imatges, posa la primera. Sino, una per defecte.
                //Imatges (prova)
                /*if(){
                    //$prova['distancia']

                }else{


                }*/

                echo '<img class="" src="images/page1_img6.jpg" alt="">';
                ?>
            </div>
            <div class="grid_4">
                <!-- afegir HREF A L'H1 -->
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
                }
                ?>
            </div>
        </div>
    </div>
<?php
    if ($numProves['COUNT(*)'] > 1) {
        echo"<div class='panel'></div>";
    }
?>
<?php } ?>
</div>
<div class="grid_4">
    <h3 class="h3__head1">Something</h3>
    <ul class="list">
        <li>
            <div class="list_count">1</div>
            <div class="extra_wrapper">
                Bla, bla, bla.
            </div>
        </li>
        <li>
            <div class="list_count">2</div>
            <div class="extra_wrapper">
                BLA2 BLA.
            </div>
        </li>
    </ul>
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
<script>
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