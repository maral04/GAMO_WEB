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

                <div class="grid_2">
                    <?php
                    if($arrayUser != false){
                        if(trim($arrayUser['img']) != "") echo "<img src='images/profile/".$arrayUser['Id']."/".$arrayUser['img']."' alt='Submit' width='150' >";
                        else  if(trim ($arrayUser['esport']) != "")echo"<img src='images/icons/".$arrayUser['esport'].".png' alt='Submit' width='150' >";
                        else echo "<img src='images/icons/hike.png' alt='Submit' width='150' >";
                    }else{
                        echo "<img src='images/icons/hike.png' alt='Submit' width='150' >";
                    }
                    ?>
                    <input id="input-upload" type="file" name="img"/>
                </div>
                <div class="grid_4">
                    <!-- Form Name -->
                    <h3 class="registre">New event</h3>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbName">Name</label>
                        <div class="col-md-6">
                            <input id="tbName" name="tbName" type="text"  value="<?php if($arrayUser != false) echo $arrayUser['nom'] ?>" required="">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbDescription">Description</label>
                        <div class="col-md-6">
                            <input id="tbDescription" name="tbDescription" type="text" placeholder="" class="form-control input-md" value="<?php if($arrayUser != false) echo $arrayUser['cNom'] ?>" >

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbIniDate">Initial date</label>
                        <div class="col-md-6">
                            <input id="tbIniDate" name="tbIniDate" type="date" value="<?php if($arrayUser != false) echo $arrayUser['dataNaix'] ?>">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbFinalDate">Final date</label>
                        <div class="col-md-6">
                            <input id="tbFinalDate" name="tbFinalDate" type="date" value="<?php if($arrayUser != false) echo $arrayUser['dataNaix'] ?>">

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbClub">Club</label>
                        <div class="col-md-6">
                            <select id="tbClub" name="tbClub" type="text" placeholder="" class="form-control input-md" >
                                <option></option>
                                <?php
                                $resultClubs = $db->recuperarClubs();

                                while ($clubs = mysqli_fetch_assoc($resultClubs)) {
                                    //var_dump($clubs);
                                    if(trim($clubs['Nom']) == trim($arrayUser['Nom'])){
                                        echo "<option value='".$clubs['Id']."' selected>".$clubs['Nom']."</option>";
                                    }else{
                                        echo "<option value='" . $clubs['Id'] . "' >" . $clubs['Nom'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <script>
                        /**/
                        $('#sports img').on('click',function(){
                            id = $(this).attr('id').replace('img','s');

                            if($(this).hasClass('icon-selected')){
                                $('#'+id).prop( "checked", false );

                                $(this).removeClass('icon-selected');
                            }else{
                                //$('#sports input').prop( "checked", false );
                                //$('#sports img').removeClass('icon-selected');

                                $('#'+id).prop( "checked", true );
                                $(this).addClass('icon-selected');

                            }
                        });

                    </script>

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