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
            $(".l1").attr("class", "l1 link link--kukuri currentL");
            $(".l2").attr("class", "l2 link link--kukuri");
            $(".l3").attr("class", "l3 link link--kukuri");
        });
    </script>
    <div class="content container_12" >
        <div class="grid_12 block3 form-user" id="profile" >
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="actions/validateUser.php">
                <input type="text" name="idUser" class="idUser" value="<?php if($arrayUser != false) echo $arrayUser['Id']?>">
                <input type="text" name="idLocal" class="idLocal" value="<?php if($arrayUser != false) echo $arrayUser['FK_Id_Localitzacio']?>">

                <div class="grid_2">
                    <div class="profile-img">

                        <img src="images/page2_img6.jpg" alt="Submit" width="150" >
                        <div id="upload" class="btn">Upload</div>
                        <input id="input-upload" type="file" name="img"/>
                    </div>
                </div>
                <div class="grid_4">
                    <!-- Form Name -->
                    <h3 class="registre">New Event</h3>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbName">Name</label>
                        <div class="col-md-6">
                            <input id="tbNom" name="tbName" type="text"  value="<?php if($arrayUser != false) echo $arrayUser['nom'] ?>" required="">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbBirth">From</label>
                        <div class="col-md-6">
                            <input id="date" name="dateini" type="date" >

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbBirth">To</label>
                        <div class="col-md-6">
                            <input id="date" name="dateFin" type="date" >

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbBirth">Desc</label>
                        <div class="col-md-6">
                        <textarea >

                        </textarea>
                        </div>
                    </div>

                <div class="grid_12">
                    <div class="btns">
                        <input type="submit" name="submitProfile" class="btn" value="Submit"/>
                    </div>

                    <?php
                    if(isset($_GET['error'])){
                        echo "<div class='error'><img src='images/icons/error.png'/>".$_GET['error']."</div>";
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
    <div class="clear"></div>
</div>
</div>
</div>
</body>
<footer><?php include_once "footer.html"; ?></footer>