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
    <div class="container_12" >
        <div class="grid_10">
            <h3 class="registre">My profile</h3>
        </div>
        <div class="grid_8 block3 form-user" id="profile" >
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="actions/validateUser.php">
                <input type="text" name="idUser" class="idUser" value="<?php if($arrayUser != false) echo $arrayUser['Id']?>">

                <div class="grid_2">
                    <?php
                        echo "<label class='col-md-4 control-label' >Profile Image</label> ";
                        if($arrayUser != false){
                            if(trim($arrayUser['img']) != "") echo "<img src='images/profile/".$arrayUser['Id']."/".$arrayUser['img']."' alt='Submit' class='subImg' width='150' >";
                            else  if(trim ($arrayUser['esport']) != "")echo"<img src='images/icons/".$arrayUser['esport'].".png' alt='Submit' class='subImg' width='150' >";
                            else echo "<img src='images/icons/hike.png' alt='Submit' class='subImg' width='150' >";
                        }else{
                            echo "<img src='images/icons/hike.png' alt='Submit' class='subImg' width='150' >";
                        }
                    ?>
                    <div class="fileUpload btn btn-primary">
                        <span>Upload</span>
                        <input type="file" class="upload" name="img"/>
                    </div>
                </div>
                <div class="grid_3">
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbName">Name</label>
                        <div class="col-md-6">
                            <input id="tbNom" name="tbName" type="text"  value="<?php if($arrayUser != false) echo $arrayUser['nom'] ?>" required="">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbLastName">Last name</label>
                        <div class="col-md-6">
                            <input id="tbCognoms" name="tbLastName" type="text" placeholder="" class="form-control input-md" value="<?php if($arrayUser != false) echo $arrayUser['cNom'] ?>" >

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbEmail">Email</label>
                        <div class="col-md-6">
                            <input id="tbEmail" name="tbEmail" type="email"  value="<?php if($arrayUser != false) echo $arrayUser['email'] ?>" required="">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbBirth">Birthdate</label>
                        <div class="col-md-6">
                            <input id="tbBirth" name="tbBirth" type="date" value="<?php if($arrayUser != false) echo $arrayUser['dataNaix'] ?>">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbAddress">T-Shirt size</label>
                        <div>
                            <select id="idTshirt" name="tbTshirt" class="form-control input-md" >
                                <option></option>
                                <option <?php if($arrayUser['talla'] == 'XS') echo 'selected'?>>XS</option>
                                <option <?php if($arrayUser['talla'] == 'S') echo 'selected'?>>S</option>
                                <option <?php if($arrayUser['talla'] == 'M') echo 'selected'?>>M</option>
                                <option <?php if($arrayUser['talla'] == 'L') echo 'selected'?>>L</option>
                                <option <?php if($arrayUser['talla'] == 'XL') echo 'selected'?>>XL</option>
                                <option <?php if($arrayUser['talla'] == 'XXL') echo 'selected'?>>XXL</option>
                            </select>
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

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbLastName">Favourite sport</label>
                        <div id="sports">
                            <div>
                                <?php
                                if(trim($arrayUser['esport']) == 'bike') {
                                    echo "<img id='img-bike'  class='icon-selected' src=\"images/icons/bike.png\"/>";
                                    echo "<span>MTB</span>";
                                    echo "<input id='s-bike' checked type='radio' name='sport' value='bike'>";
                                }else{
                                    echo "<img id='img-bike'  src=\"images/icons/bike.png\"/>";
                                    echo "<span>MTB</span>";
                                    echo "<input id='s-bike' type='radio' name='sport' value='bike'>";
                                }
                                ?>
                            </div>
                            <div>
                                <?php
                                if(trim($arrayUser['esport']) == 'hiking') {
                                    echo "<img id='img-hike'  class='icon-selected' src=\"images/icons/hiking.png\"/>";
                                    echo "<span>Hiking</span>";
                                    echo "<input id='s-hike' checked type='radio' name='sport' value='hiking'>";
                                }else{
                                    echo "<img id='img-hike'  src=\"images/icons/hiking.png\"/>";
                                    echo "<span>Hiking</span>";
                                    echo "<input id='s-hike' type='radio' name='sport' value='hiking'>";
                                }
                                ?>

                            </div>
                            <div>
                                <?php
                                if(trim($arrayUser['esport']) == 'skiing') {
                                    echo "<img id='img-ski'  class='icon-selected' src=\"images/icons/skiing.png\"/>";
                                    echo "<span>Skiing</span>";
                                    echo "<input id='s-ski' checked type='radio' name='sport' value='skiing'>";
                                }else{
                                    echo "<img id='img-ski'  src=\"images/icons/skiing.png\"/>";
                                    echo "<span>Skiing</span>";
                                    echo "<input id='s-ski' type='radio' name='sport' value='skiing'>";
                                }
                                ?>

                            </div>
                            <div>
                                <?php
                                if(trim($arrayUser['esport']) == 'trail') {
                                    echo "<img id='img-trail' class='icon-selected' src=\"images/icons/trail.png\"/>";
                                    echo "<span>Trail</span>";
                                    echo "<input id='s-trail' checked type=\"radio\" name=\"sport\" value=\"trail\">";
                                }else{
                                    echo "<img id='img-trail' src=\"images/icons/trail.png\"/>";
                                    echo "<span>Trail</span>";
                                    echo "<input id='s-trail' type=\"radio\" name=\"sport\" value=\"trail\">";
                                }
                                ?>

                            </div>
                            <div>
                                <?php
                                if(trim($arrayUser['esport']) == 'climbing') {
                                    echo " <img id='img-climb' class='icon-selected' src=\"images/icons/climbing.png\"/>";
                                    echo "<span>Climbing</span>";
                                    echo "<input id='s-climb' checked type='radio' name='sport' value='climbing'>";
                                }else{
                                    echo "<img id='img-climb'  src=\"images/icons/climbing.png\"/>";
                                    echo "<span>Climbing</span>";
                                    echo "<input id='s-climb' type=\"radio\" name=\"sport\" value=\"climbing\">";
                                }
                                ?>
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
                                $('#sports input').prop( "checked", false );
                                $('#sports img').removeClass('icon-selected');

                                $('#'+id).prop( "checked", true );
                                $(this).addClass('icon-selected');

                            }
                        });

                    </script>
                </div>
                <div class="grid_2">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbCountry">Country</label>
                        <div class="col-md-6">
                            <select id="tbCountry" name="tbCountry" >
                                <option></option>
                                <?php
                                $result = $db->recuperarPaisos();

                                while ($pais = mysqli_fetch_assoc($result)) {
                                    if(trim($pais['country_name']) == trim($arrayUser['estat'])){
                                        echo "<option value='".$pais['country_name']."' selected>".$pais['country_name']."</option>";
                                    }else{
                                        echo "<option value='".$pais['country_name']."'>".$pais['country_name']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbRegion">Region</label>
                        <div class="col-md-6">
                            <input id="tbRegion" name="tbRegion" type="text" value="<?php if(isset($arrayUser['regio']) && $arrayUser != false) echo $arrayUser['regio'] ?>" >

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbCity">City</label>
                        <div class="col-md-6">
                            <input id="tbCity" name="tbCity" type="text" value="<?php if(isset($arrayUser['poblacio']) && $arrayUser != false) echo $arrayUser['poblacio'] ?>" >

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbAddress">Address</label>
                        <div class="col-md-6">
                            <input id="tbAddress" name="tbAddress" type="text" value="<?php if(isset($arrayUser['direccio']) && $arrayUser != false) echo $arrayUser['direccio'] ?>" >

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbPostalCode">Postal code</label>
                        <div class="col-md-6">
                            <input id="tbPostalCode" name="tbPostalCode" value="<?php if(isset($arrayUser['cp']) && $arrayUser != false) echo $arrayUser['cp'] ?>">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbPhone">Personal Phone</label>
                        <div class="col-md-6">
                            <input id="tbPhone" name="tbPhone" type="text" value="<?php if(isset($arrayUser['tel1']) && $arrayUser != false) echo $arrayUser['tel1'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tbPhone">Emergency Phone</label>
                        <div class="col-md-6">
                            <input id="tbPhone2" name="tbPhone2" type="text" value="<?php if(isset($arrayUser['tel2']) && $arrayUser != false) echo $arrayUser['tel2'] ?>">
                        </div>
                    </div>
                </div>
                <?php
                if(isset($_GET['error'])){
                    echo "<div class='grid_3 error'><img src='images/icons/error.png'/>".$_GET['error']."</div>";
                }
                ?>
                <div class="">
                    <input type="submit" name="submitProfile" class="grid_6 btn fRight" value="Submit"/>
                </div>
            </form>
        </div>
        <div class="grid_3">
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
    </div>
    <div class="clear"></div>
</div>
</div>
</div>
</body>
<footer><?php include_once "footer.html"; ?></footer>