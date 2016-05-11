<head>
    <?php include_once "head.php";
    include_once "classes/DataBase.php";

    $db = new DataBase();

    $prova = $db->recuperarProva(2);

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
                            echo "<div class='grid_4'><img class='' src='images/page1_img8.jpg' alt=''></div>";
                            echo "
                            <div class='grid_7'>
                                <!-- nom (prova) -->
                                <h1 class='eventTitle'>
                                    ".$prova['nom']."
                                </h1>
                                <!-- Població (localitzacio)) -->
                                <a>NOOOOOOOOOOFUNCIONA</a>
                                <div class='fRight'>
                                    <!-- data_hora_inici (prova) -->
                                    <a>".$prova['data_hora_inici']."</a>
                                </div>
                                <div>
                                    <!-- Descripció (prova) -->
                                    <a>".$prova['descripcio']." FD</a>
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