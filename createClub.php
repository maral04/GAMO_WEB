<head>
    <?php
    include_once "head.php";
    include_once "classes/DataBase.php";
    include_once "classes/User.php";
    include_once "classes/Club.php";
    $arrayDades;
    $_POST["edit"]=false;
        if(isset($_POST["idclub"])){
            $_POST["edit"]=true;
           $db= new DataBase();
           if( $conn=$db->connect()){
               $sql = "SELECT * From club WHERE Id =".$_POST["idclub"];
               $result = $conn->query($sql);

               if(is_object($result)) {
                   if ($result->num_rows > 0) {
                       $arrayDades=mysqli_fetch_assoc($result);
                   } else {
                       echo "id invalida";
                   }
               }
           }
    }

    $usuari = new User();

    if (isset($_SESSION['idUser'])) {
        $arrayUser = $usuari->load($_SESSION['idUser']);
        //var_dump($arrayUser);
    } else {
        header("Location: login.php");
    }

    ?>
</head>
<body>
<div class="main">
    <?php include_once "header.php"; ?>
    <div class="content" id="registerContent">
        <div class="container_12">
            <div class="formRegistre block3">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="actions/validateClub.php">
                    <fieldset>
                        <!-- Form Name -->
                        <h3 class="registre h3__head1">Club Creation</h3>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbName">Name<?php if(isset($_POST["idclub"]))echo ": ".$arrayDades["nom"]; ?></label>
                            <div class="col-md-6">
                                <input id="tbNom" name="tbName" type="text" placeholder="" class="form-control input-md" required="" tabindex="0" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbName">Description</label>
                            <div class="col-md-6 grid_4">
                                <textarea id="tbDescripcio" name="tbDescr" class="form-control input-md" required="" tabindex="0">
                                    <?php if(isset($_POST["idclub"]))echo $arrayDades["descripcio"]; ?>
                                </textarea>
                            </div>
                        </div>
                        <!-- File Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="filebutton">Logo</label></br>
                            <div class="fileUpload btn btn-primary club">
                                <img class='icoFitxa' src='images/icons/upImg.png' alt='Upload Logo'><span class="spanUpload">Upload</span>
                                <input id="tbImages" name="img" type="file" class="upload" accept="image/*">
                            </div>
                            <div class="grid_3">
                                <img id="prevImg" src="#" alt="" />
                            </div>

                            <?php if(isset($_POST["idclub"]))echo '<img src="images/club/"'.$arrayDades["imatges"].'>';?>
                        </div>

                        <div class="fileUpload btn btn-primary grid_3">
                            <span class="spanSubmit2">Submit</span>
                            <input type="submit" name="submitClub" class="btn btnM upload" value="Submit" tabindex="5"/>
                        </div>
                        <?php
                        if(isset($_GET['error'])){
                            echo "<div class='error'><img src='images/icons/error.png'/>".$_GET['error']."</div>";
                        }
                        ?>
                    </fieldset>
                </form>
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