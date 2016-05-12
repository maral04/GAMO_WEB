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
        <div class="grid_10 block3">
            <div class="btn btn-primary click">
                <span>Create Cosa</span>


            </div>
            <div class="btn btn-primary click">
                <span>Create Asdasd</span>


            </div>
        </div>

    </div>
    <div class="clear"></div>
</div>
</body>
<footer><?php include_once "footer.html"; ?></footer>