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
            /*$(".l1").attr("class", "l1 link link--kukuri currentL");*/
            $(".l2").attr("class", "l2 link link--kukuri");
            $(".l3").attr("class", "l3 link link--kukuri");
        });
    </script>
    <div class="container_12">
        <div class="grid_10">
            <h3 class="registre">Organise</h3>
        </div>
        <div class="grid_11 block3">
            <div class="grid_3">
                <div class="form-group">
                    <a href="createEvent.php" class="spanUpload">
                        <div class="fileUpload fuv2 btn btn-primary prImg" >
                            <img class="cpImg" href="createEvent.php" src="images/icons/eventCalendar.png"/>
                                Create Event
                        </div>
                    </a>
                </div>
            </div>
            <div class="grid_3">
                <div class="form-group">
                    <a href="createEvent.php" class="spanUpload">
                        <div class="fileUpload fuv2 btn btn-primary prImg" >
                            <img class="cpImg" href="createProva.php" src="images/icons/provaDud.png"/>
                            Create Prova
                        </div>
                    </a>
                </div>
            </div>

            <?php
            $sql = "SELECT event.*, poblacio FROM event WHERE idOrganitzador = ".$_SESSION['idUser'];

            if($db == null)$db = new DataBase();
            $conn = $db->connect();

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Name</th><th>Description</th><th>Date</th><th>City</th></tr>";
                while($event = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>".$event['titol']."</td>";
                    echo "<td>".$event['descripcio']."</td>";
                    $data=date_create($event['dataInici']);
                    echo "<td>".date_format($data, 'd-m-Y')."</td>";
                    echo "<td>".$event['poblacio']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            ?>
        </div>



    </div>
    <div class="clear"></div>
</div>
</body>
<footer><?php include_once "footer.html"; ?></footer>