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
    <div class="content container_12" >
        <div class="grid_10">
            <h3 class="registre">New event</h3>
        </div>
        <div class="grid_10 block3 form-user" id="profile" >
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="actions/validateProva.php">
                <input type="text" name="idUser" class="idUser" value="<?php if($arrayUser != false) echo $arrayUser['Id']?>">

                <div class="grid_3">
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
                        <label class="col-md-4 control-label" for="tbFinDate">Final date</label>
                        <div class="col-md-6">
                            <input id="tbFinDate" name="tbFinDate" type="date" value="<?php if($arrayUser != false) echo $arrayUser['dataNaix'] ?>">

                        </div>
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
                <div class="grid_3">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbCountry">Country</label>
                        <div class="col-md-6">
                            <input id="tbCountry" name="tbCountry" type="text"  value="<?php if($arrayUser != false) echo $arrayUser['email'] ?>" required="">

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbRegion">Region</label>
                        <div class="col-md-6">
                            <input id="tbRegion" name="tbRegion" type="text" value="<?php if($arrayUser != false) echo $arrayUser['dataNaix'] ?>">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbCity">City</label>
                        <div class="col-md-6">
                            <input id="tbCity" name="tbCity" type="text" value="<?php if($arrayUser != false) echo $arrayUser['dataNaix'] ?>">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbAddress">Address</label>
                        <div class="col-md-6">
                            <input id="tbAddress" name="tbAddress" type="text" value="<?php if($arrayUser != false) echo $arrayUser['dataNaix'] ?>">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbCp">Postal code</label>
                        <div class="col-md-6">
                            <input id="tbCp" name="tbCp" type="text" value="<?php if($arrayUser != false) echo $arrayUser['dataNaix'] ?>">

                        </div>
                    </div>
                </div>
                <div class="grid_3">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbImages">Images</label></br>
                        <div class="fileUpload btn btn-primary">
                            <span class="spanUpload2">Upload Image</span>
                            <input id="tbImages" name="tbImages" type="file" class="upload" accept="image/*" value="<?php if($arrayUser != false) echo $arrayUser['email'] ?>" >
                        </div>
                        <div class="grid_3">
                            <img id="prevImg" src="#" alt="" />
                        </div>
                    </div>
                </div>
                <div class="grid_12">
                    <div class="fileUpload btn btn-primary grid_2">
                        <span class="spanSubmit">Submit</span>
                        <input  type="submit" name="submitEvent" class="btn upload" class="upload" value="Submit"/>
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
<!--Previsualitzar l'Imatge a pujar.-->
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#prevImg').attr('src', e.target.result);
                $('#prevImg').show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#tbImages").change(function(){
        readURL(this);
    });
</script>
<footer><?php include_once "footer.html"; ?></footer>
<!-- Text input-->
