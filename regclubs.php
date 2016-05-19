<head>
<<<<<<< HEAD
    <?php
    include_once "head.php";
    include_once "classes/DataBase.php";
    include_once  "classes/club.php";
    $arrayDades;
    $_POST["edit"]=false;
        if(isset($_POST["idclub"])){
            $_POST["edit"]=true;
           $db= new DataBase();
           if( $conn=$db->connect()){
               $sql = "SELECT * From club WHERE Id =".$_POST["idclub"];
               $result = $conn->query($sql);
=======
    <?php include_once "head.php";
>>>>>>> origin/master

               //var_dump($result);

               if(is_object($result)) {
                   if ($result->num_rows > 0) {
                       $arrayDades=mysqli_fetch_assoc($result);
                     //  var_dump($arrayDades);

                   } else {
                       echo "id invalida";
                   }
               }
           }


    }
    ?>
</head>

<body class="" id="top">

<div class="main">
    <?php include_once "header.php"; ?>
    <div class="content" id="registerContent">
        <div class="container_12">
            <div class="formRegistre block3">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="actions/validateClub.php">
                    <fieldset>
                        <!-- Form Name -->
                        <h3 class="registre">Club register</h3>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbName">Name<?php if(isset($_POST["idclub"]))echo ": ".$arrayDades["nom"]; ?></label>
                            <div class="col-md-6">
                                <input id="tbNom" name="tbName" type="text" placeholder="" class="form-control input-md" required="" tabindex="0" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbName">Description</label>
                            <div class="col-md-6">
                                <textarea id="tbDescripcio" name="tbDescr" class="form-control input-md" required="" tabindex="0" autofocus>
                                    <?php if(isset($_POST["idclub"]))echo $arrayDades["descripcio"]; ?>
                                </textarea>
                            </div>
                        </div>
                        <!-- File Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="filebutton">Logo</label>
                            <div class="col-md-4">
                                <input id="imatge" name="img" class="input-file" type="file">
                            </div>

                            <?php if(isset($_POST["idclub"]))echo '<img src="images/club/"'.$arrayDades["imatges"].'>';?>
                        </div>
                        <div>
                            <input type="submit" name="submitClub" class="btn btnM" value="Submit" tabindex="5"/>
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
<footer><?php include_once "footer.html"; ?></footer>