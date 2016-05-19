<head>
    <?php include_once "head.php";

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
                            <label class="col-md-4 control-label" for="tbName">Name</label>
                            <div class="col-md-6">
                                <input id="tbNom" name="tbName" type="text" placeholder="" class="form-control input-md" required="" tabindex="0" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbName">Description</label>
                            <div class="col-md-6">
                                <textarea id="tbDescripcio" name="tbDescr" class="form-control input-md" required="" tabindex="0" autofocus>

                                </textarea>
                            </div>
                        </div>
                        <!-- File Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="filebutton">Logo</label>
                            <div class="col-md-4">
                                <input id="imatge" name="img" class="input-file" type="file">
                            </div>
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