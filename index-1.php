<!--==============================head=================================-->
<head>
    <?php
    include_once 'head.html';
    ?>
    <title>GAMO: Event List</title>
    <script>
        $(document).ready(function() {
            $(".accordion").on("click", function () {
                //console.log("asd");

                 var id = $(this).attr('eventid');
                 $.ajax({
                 dataType: "json",
                 type: "GET",
                 url: "http://localhost/GAMO_WEB/api/events/getProves.php?eventId="+id,
                 success: function(data) {
                 console.log(data);
                 },
                 error: function(xhr, status){
                     alert(xhr+status);
                 },
                 complete: function(xhr, status){
                     alert(xhr+status);
                 }
                 /*default: function(){
                    console.log("tumamanofunka!");
                 }*/
                 });
            });
        });
    </script>
</head>
<body class="" id="top">
<div class="main">
	<!--==============================header=================================-->
    <?php
    include_once 'header.html';
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
                ?>
                <div class="block2">
                    <div class="grid_3">
                        <!--<div class="tag">
                            <ul class="list">
                                <li>
                                    <div class="list_count">1</div>
                                </li>
                            </ul>
                        </div>-->
                        <img src="images/page1_img10.jpg" alt="">
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
            if($numProves['COUNT(*)'] > 1){
                echo "<div class='panel'>
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
                                    <!--  -->
                                    <a>SDIASJDA</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
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