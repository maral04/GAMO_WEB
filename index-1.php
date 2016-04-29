<!--==============================head=================================-->
<head>
    <?php
    include_once 'head.html';
    ?>
    <title>GAMO: Event List</title>
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

                if ($numProves <= 1) {
                    echo "<div class='block3'>";
                } else {
                //Si l'event té més d'una prova, es preparen events desplegables.
                echo "<div class='block3 accordion'>";
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
                        <img class="click" src="images/page1_img10.jpg" alt="">
                    </div>
                    <div class="grid_4">
                        <!-- afegir HREF A L'H1 -->
                        <!-- Titol (event) -->
                        <h1 class="eventTitle click"><?php echo $event['titol'] ?></h1>
                <!-- Població (localitzacio)) -->
                <a><?php echo $event['poblacio'] ?></a>
                <div class="fRight">
                    <!-- Data Inicial (event) -->
                    <a><?php echo date("Y-m-d", strtotime($event['dataInici'])) ?></a>
                </div>
                <div class="descripcio">
                    <!-- Descripció (event) -->
                    <p><?php echo $event['descripcio'] ?></p>
                </div>
                <?php
                //Si l'event només té una prova, mostra més informació d'aquesta.
                if ($numProves['COUNT(*)'] == 1) {
                    $prova = $db->recuperarProves($event['Id']);
                    echo "<a class='click'>Màx. Participants " . $prova['limit_inscrits'] . "</a>
                            <div class='grid_1 fRight'>
                                <a class='gran fRight'>" . $prova['distancia'] . "Km</a>
                            </div>";
                }
                ?>
            </div>
        </div>

    </div>
            <?php
            //POSAR IF.
            echo "<div class='panel'>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>";

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
<script type="text/javascript" src="js/jquery.calendario.js"></script>
<script type="text/javascript" src="js/data.js"></script>

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

<!--<script type="text/javascript">
    $(function() {
        $( ".desplegable" ).accordion();
    });
</script>-->


<!--<script type="text/javascript">
    $(function() {
        var cal = $( '#calendar' ).calendario( {
            onDayClick : function( $el, $contentEl, dateProperties ) {
                for( var key in dateProperties ) {
                    console.log( key + ' = ' + dateProperties[ key ] );
                }
            },
            caldata : codropsEvents
        } ),
        $month = $( '#custom-month' ).html( cal.getMonthName() ),
        $year = $( '#custom-year' ).html( cal.getYear() );
        $( '#custom-next' ).on( 'click', function() {
            cal.gotoNextMonth( updateMonthYear );
        } );
        $( '#custom-prev' ).on( 'click', function() {
            cal.gotoPreviousMonth( updateMonthYear );
        } );
        $( '#custom-current' ).on( 'click', function() {
            cal.gotoNow( updateMonthYear );
        } );
        function updateMonthYear() {
            $month.html( cal.getMonthName() );
            $year.html( cal.getYear() );
        }
    });
</script>-->
</body>
</html>