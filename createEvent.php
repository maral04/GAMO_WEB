<head>
    <?php include_once "head.php";
    include_once "classes/DataBase.php";
    include_once "classes/User.php";
    include_once "classes/Event.php";

    $db = new DataBase();
    $usuari = new User();
    $arrayUser = Array();
    if(isset($_SESSION['idUser'])) {
        $arrayUser = $usuari->load($_SESSION['idUser']);
    }else{
        header("Location: login.php");
    }
    if(isset($_GET['eventId'])){
        $event = new Event();
        $arrayEvent = $event->load($_GET['eventId']);
        if($arrayEvent['idOrganitzador'] != $_SESSION['idUser'])header("Location: organize.php");
    }else{
        $arrayEvent = false;
    }
    ?>
</head>

<body class="" id="top">

<div class="main">
    <?php include_once "header.php"; ?>
    <div class="content container_12" >
        <div class="grid_10">
            <h3 class="registre h3__head1">New multiple event</h3>
        </div>
        <div class="grid_10 block3 form-user" id="profile" >
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="actions/validateEvent.php">
                <input type="text" name="idUser" class="idUser" >
                <?php if($arrayEvent != false ) echo "<input type=\"text\" name=\"idEvent\" class=\"idEvent\" value='".$arrayEvent['Id']."' >"?>

                <div class="grid_3">
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbName">Name</label>
                        <div class="col-md-6">
                            <input id="tbName" name="tbName" type="text" required="" value="<?php if($arrayEvent != false)echo $arrayEvent['titol']?>">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbDescription">Description</label>
                        <div class="col-md-6">
                            <input id="tbDescription" name="tbDescription" type="text" value="<?php if($arrayEvent != false)echo $arrayEvent['descripcio']?>" class="form-control input-md"  >

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbIniDate">Initial date</label>
                        <div class="col-md-6">
                            <input id="tbIniDate" name="tbIniDate" type="date" value="<?php if($arrayEvent != false)echo $arrayEvent['dataInici']?>">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbFinDate">Final date</label>
                        <div class="col-md-6">
                            <input id="tbFinDate" name="tbFinDate" type="date" value="<?php if($arrayEvent != false)echo $arrayEvent['dataFinal']?>">
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
                            <select id="tbCountry" name="tbCountry" style="width:173px;">
                                <option></option>
                                <?php
                                $result = $db->recuperarPaisos();

                                while ($pais = mysqli_fetch_assoc($result)) {
                                    if($arrayEvent != false) {
                                        if (trim($pais['country_name']) == trim($arrayEvent['estat'])) {
                                            echo "<option value='" . $pais['country_name'] . "' selected>" . $pais['country_name'] . "</option>";
                                        } else {
                                            echo "<option value='" . $pais['country_name'] . "'>" . $pais['country_name'] . "</option>";
                                        }
                                    }else{
                                        echo "<option value='" . $pais['country_name'] . "'>" . $pais['country_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbRegion">Region</label>
                        <div class="col-md-6">
                            <input id="tbRegion" name="tbRegion" type="text" value="<?php if($arrayEvent != false)echo $arrayEvent['regio']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbCity">City</label>
                        <div class="col-md-6">
                            <input id="tbCity" name="tbCity" type="text" value="<?php if($arrayEvent != false)echo $arrayEvent['poblacio']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbAddress">Address</label>
                        <div class="col-md-6">
                            <input id="tbAddress" name="tbAddress" type="text" value="<?php if($arrayEvent != false)echo $arrayEvent['direccio']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbCp">Postal code</label>
                        <div class="col-md-6">
                            <input id="tbCp" name="tbCp" type="text" value="<?php if($arrayEvent != false)echo $arrayEvent['cp']?>">
                        </div>
                    </div>
                </div>
                <div class="grid_3">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbImages">Images</label></br>
                        <div class="fileUpload btn btn-primary">
                            <img class='icoFitxa' src='images/icons/upImg.png' alt='Upload Image'><span class="spanUpload">Upload</span>
                            <input id="tbImages" name="tbImages" type="file" class="upload" accept="image/*" value="<?php if($arrayEvent != false)echo $arrayEvent['imatges']?>">
                        </div>
                        <div class="grid_3">
                            <img id="prevImg" src="<?php if($arrayEvent != false)echo "imatges/events/".$arrayEvent['Id']."/".$arrayEvent['imatges']?>" alt="" />
                        </div>
                    </div>
                </div>
                <div class="grid_12">
                    <div class="fileUpload btn btn-primary grid_2">
                        <span class="spanSubmit3">Submit</span>
                        <?php
                        if(!$arrayEvent) echo "<input  type='submit' name='submitEvent' class='btn upload' class='upload' value='Submit'/>";
                        else echo "<input  type=\"submit\" name=\"updateEvent\" class=\"btn upload\" class=\"upload\" value=\"Submit\"/>"
                        ?>
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
