<head>
    <?php include_once "head.php";
    include_once "classes/DataBase.php";
    include_once "classes/User.php";
    include_once "classes/Event.php";

    $db = new DataBase();
    $event = new Event();
    $usuari = new User();

    if(isset($_SESSION['idUser'])) {
        $arrayUser = $usuari->load($_SESSION['idUser']);
    }else{
        header("Location: login.php");
    }
    if(isset($_SESSION['idEvent'])) {
        $arrayEvent = $event->load($_SESSION['idEvent']);

    }else $arrayEvent = false;?>
    </div>
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
        <?php if($arrayEvent != false){?>
            <div class="grid_9">
                <div class='block3 click eventDiv'>
                    <div class='block2'>
                        <div class='grid_7'>
                            <div class="grid_2">
                                <img class="" src="images/events/<?php echo $arrayEvent['Id']."/".$arrayEvent['imatges']?>" alt="">
                            </div>
                            <div class="grid_4">
                                <h1 class="eventTitle"><?php echo $arrayEvent['titol'] ?></h1>
                                <a><?php echo $arrayEvent['poblacio'] ?></a>
                                <div class="fRight">
                                    <a><?php echo date("Y-m-d", strtotime($arrayEvent['dataInici'])) ?></a>
                                </div>
                                <div class="descripcioEvent">
                                    <!-- Descripció (event) -->
                                    <a><?php echo $arrayEvent['descripcio'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        $proves = $db->recuperarProves($arrayEvent['Id'], true);
        if($proves !== false) {
            while ($prova = mysqli_fetch_assoc($proves)) {
                ?>
                <div class='grid_8'>
                    <div class='block3 click'>
                        <div class='block2'>
                            <div class='grid_2'>
                                <img class="" src="images/proves/<?php echo $prova['Id']."/".$prova['Imatges']?>" alt="">
                            </div>
                            <div class='grid_4 g4Gran'>
                                <h4><?php echo $prova['nom'] ?></h4>
                                <a><?php echo $prova['poblacio'] ?></a>
                                <div class='fRight'>
                                    <a><?php echo $prova['data_hora_inici'] ?></a>
                                </div>

                                <div class='descripcioProva'>
                                    <a><?php echo $prova['data_hora_inici'] ?></a>
                                </div>
                                <a>Max. Participants: <?php echo $prova['limit_inscrits'] ?></a>
                                <div class='gran grid_1 fRight'>
                                    <?php echo $prova['distancia'] . "Km" ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <div class="grid_10">
            <h3 class="registre">New prova</h3>
        </div>
        <div class="grid_10 block3 form-user" id="profile" >
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="actions/validateProva.php">
                <input type="text" name="idUser" class="idUser" value="<?php if($arrayUser != false) echo $arrayUser['Id']?>">
                <input type="text" name="idEvent" class="idEvent" value="<?php if($arrayEvent != false) echo $arrayEvent['Id']?>">

                <div class="grid_3">
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbName">Name</label>
                        <div class="col-md-6">
                            <input id="tbName" name="tbName" type="text"  value="<?php if($arrayEvent != false) echo $arrayEvent['titol'] ?>" required="">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbDescription">Description</label>
                        <div class="col-md-6">
                            <input id="tbDescription" name="tbDescription" type="text" placeholder="" class="form-control input-md" value="<?php if($arrayEvent != false) echo $arrayEvent['descripcio'] ?>" >

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbIniDate">Initial date</label>
                        <div class="col-md-6">
                            <input id="tbIniDate" name="tbIniDate" type="date" value="<?php if($arrayEvent != false) echo $arrayEvent['dataInici'] ?>">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbIniTime">Start time</label>
                        <div class="col-md-6">
                            <input id="tbIniTime" name="tbIniTime" type="time">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbDistance">Distance</label>
                        <div class="col-md-6">
                            <input id="tbDistance" name="tbDistance" type="number" step="0.1">


                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbPositive">Positive slope (m+)</label>
                        <div class="col-md-6">
                            <input id="tbPositive" name="tbPositive" type="number" value="<?php if($arrayUser != false) echo $arrayUser['dataNaix'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbNegtive">Negative slope (m-)</label>
                        <div class="col-md-6">
                            <input id="tbNegtive" name="tbNegtive" type="number" value="<?php if($arrayUser != false) echo $arrayUser['dataNaix'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbCheckpoints">Checkpoints</label>
                        <div class="col-md-6">
                            <input id="tbCheckpoints" name="tbCheckpoints" type="number">


                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbTimeLimit">Time limit</label>
                        <div class="col-md-6">
                            <input id="tbTimeLimit" name="tbTimeLimit" type="time" >

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbLastName">Sports</label>
                        <div id="sports">
                            <div>
                                <?php
                                if(trim($arrayUser['esport']) == 'bike') {
                                    echo "<img id='img-bike'  class='icon-selected' src=\"images/icons/bike.png\"/>";
                                    echo "<span>MTB</span>";
                                    echo "<input id='s-bike' checked type='checkbox' name='sport[]' value='bike'>";
                                }else{
                                    echo "<img id='img-bike'  src=\"images/icons/bike.png\"/>";
                                    echo "<span>MTB</span>";
                                    echo "<input id='s-bike' type='checkbox' name='sport[]' value='bike'>";
                                }
                                ?>
                            </div>
                            <div>
                                <?php
                                if(trim($arrayUser['esport']) == 'hiking') {
                                    echo "<img id='img-hike'  class='icon-selected' src=\"images/icons/hiking.png\"/>";
                                    echo "<span>Hiking</span>";
                                    echo "<input id='s-hike' checked type='checkbox' name='sport[]' value='hiking'>";
                                }else{
                                    echo "<img id='img-hike'  src=\"images/icons/hiking.png\"/>";
                                    echo "<span>Hiking</span>";
                                    echo "<input id='s-hike' type='checkbox' name='sport[]' value='hiking'>";
                                }
                                ?>
                            </div>
                            <div>
                                <?php
                                if(trim($arrayUser['esport']) == 'skiing') {
                                    echo "<img id='img-ski'  class='icon-selected' src=\"images/icons/skiing.png\"/>";
                                    echo "<span>Skiing</span>";
                                    echo "<input id='s-ski' checked type='checkbox' name='sport[]' value='skiing'>";
                                }else{
                                    echo "<img id='img-ski'  src=\"images/icons/skiing.png\"/>";
                                    echo "<span>Skiing</span>";
                                    echo "<input id='s-ski' type='checkbox' name='sport[]' value='skiing'>";
                                }
                                ?>
                            </div>
                            <div>
                                <?php
                                if(trim($arrayUser['esport']) == 'trail') {
                                    echo "<img id='img-trail' class='icon-selected' src=\"images/icons/trail.png\"/>";
                                    echo "<span>Trail</span>";
                                    echo "<input id='s-trail' checked type=\"checkbox\" name=\"sport[]\" value=\"trail\">";
                                }else{
                                    echo "<img id='img-trail' src=\"images/icons/trail.png\"/>";
                                    echo "<span>Trail</span>";
                                    echo "<input id='s-trail' type=\"checkbox\" name=\"sport[]\" value=\"trail\">";
                                }
                                ?>
                            </div>
                            <div>
                                <?php
                                if(trim($arrayUser['esport']) == 'climbing') {
                                    echo " <img id='img-climb' class='icon-selected' src=\"images/icons/climbing.png\"/>";
                                    echo "<span>Climbing</span>";
                                    echo "<input id='s-climb' checked type='checkbox' name='sport[]' value='climbing'>";
                                }else{
                                    echo "<img id='img-climb'  src=\"images/icons/climbing.png\"/>";
                                    echo "<span>Climbing</span>";
                                    echo "<input id='s-climb' type=\"checkbox\" name=\"sport[]\" value=\"climbing\">";
                                }
                                ?>

                            </div>
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

                            <input id="tbCountry" name="tbCountry" type="text"  value="<?php if($arrayEvent != false) echo $arrayEvent['estat'] ?>" required="">


                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbRegion">Region</label>
                        <div class="col-md-6">

                            <input id="tbRegion" name="tbRegion" type="text" value="<?php if($arrayEvent != false) echo $arrayEvent['regio'] ?>">


                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbCity">City</label>
                        <div class="col-md-6">

                            <input id="tbCity" name="tbCity" type="text" value="<?php if($arrayEvent != false) echo $arrayEvent['poblacio'] ?>">


                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbAddress">Address</label>
                        <div class="col-md-6">

                            <input id="tbAddress" name="tbAddress" type="text" value="<?php if($arrayEvent != false) echo $arrayEvent['direccio'] ?>">


                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbCp">Postal code</label>
                        <div class="col-md-6">

                            <input id="tbCp" name="tbCp" type="text" value="<?php if($arrayEvent != false) echo $arrayEvent['cp'] ?>">


                        </div>
                    </div>
                </div>
                <div class="grid_3">
                    <div class="form-group">
                        <div class="fileUpload btn btn-primary prImg">
                            <img class="cpImg" src='images/icons/picture.png'/>
                            <span class="spanUpload">Upload Images</span>
                            <input type="file" id="tbImages" name="tbImages" class="upload" accept="image/*"  />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fileUpload btn btn-primary prImg">
                            <img class="cpImg" src='images/icons/trackMap.png'/>
                            <span class="spanUpload">Upload Tracks</span>
                            <input id="tbTrack" class="upload" name="tbTrack" type="file" value="<?php if($arrayUser != false) echo $arrayUser['dataNaix'] ?>"/>
                        </div>
                    </div>

                </div>
                <div class="grid_5">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbManager">Manager web site</label>
                        <div class="col-md-6">
                            <input id="tbManager" name="tbManager" type="text" placeholder="http://olladenuria.cat/">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbPrice">Price</label>
                        <div class="col-md-6">
                            <input id="tbPrice" name="tbPrice" type="number"   >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbLimitInscrits">Limit enrollments</label>
                        <div class="col-md-6">
                            <input id="tbLimitInscrits" name="tbLimitInscrits" type="number" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbInscripcionsIni">Open registration date</label>
                        <div class="col-md-6">
                            <input id="tbInscripcionsIni" name="tbInscripcionsIni" type="date" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbInscripcionsFin">Final registration date</label>
                        <div class="col-md-6">
                            <input id="tbInscripcionsFin" name="tbInscripcionsFin" type="date" >
                        </div>
                    </div>

                </div>
                <div class="grid_12">
                    <div class="btns">
                        <input type="submit" name="submitProva" class="btn" value="Submit"/>
                        <?php if($arrayEvent != false)echo "<input type=\"submit\" name=\"submitProva\" class=\"btn\" value=\"New prova\"/>";?>
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
<!-- Text input-->
