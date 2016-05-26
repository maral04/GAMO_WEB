<head>
<?php include_once "head.php";
?>
</head>

<body class="" id="top">

<div class="main">
    <?php include_once "header.php"; ?>
    <!--Funció canvi Color depenent CurrentL-->
    <script type="text/javascript">
        $(document).ready(function () {
            //Remou current de tots i inclou a l'actual.
            $(".l1").attr("class", "l1 link link--kukuri");
            $(".l2").attr("class", "l2 link link--kukuri");
            $(".l3").attr("class", "l3 link link--kukuri");
            $(".l4").attr("class", "l3 link link--kukuri currentL");
        });
    </script>
    <div class="content" id="registerContent">
        <div class="container_12">
            <div class="formRegistre block3">
                <form class="form-horizontal" method="post" action="actions/validateUser.php">
                    <fieldset>
                        <!-- Form Name -->
                        <h3 class="registre h3__head1">Join</h3>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbName">Name</label>
                            <div class="col-md-6">
                                <input id="tbNom" name="tbName" type="text" placeholder="Jack" class="form-control input-md" required="" tabindex="0" autofocus
                                    <?php
                                    if(isset($_SESSION['nomTMP'])){
                                        echo "value='".$_SESSION['nomTMP']."'";
                                    }
                                    ?>
                                >
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbLastName">Last name</label>
                            <div class="col-md-6">
                                <input id="tbCognoms" name="tbLastName" type="text" placeholder="Sparrow" class="form-control input-md" required="" tabindex="0"
                                    <?php
                                    if(isset($_SESSION['lastTMP'])){
                                        echo "value='".$_SESSION['lastTMP']."'";
                                    }
                                    ?>
                                >
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbEmail">Email</label>
                            <div class="col-md-6">
                                <input id="tbEmail" name="tbEmail" type="email" placeholder="captain@blackpearl.com" class="form-control input-md" required="" tabindex="0"
                                    <?php
                                    if(isset($_SESSION['mailTMP'])){
                                        echo "value='".$_SESSION['mailTMP']."'";
                                    }
                                    ?>
                                >
                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbPassword">Password</label>
                            <div class="col-md-6">
                                <input id="tbPassword" name="tbPassword" type="password" placeholder="" class="form-control input-md" required="" tabindex="0">
                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbPasswordConfirm">Password confirmation</label>
                            <div class="col-md-6">
                                <input id="tbPasswordConfirm" name="tbPasswordConfirm" type="password" placeholder="" class="form-control input-md" required="" tabindex="0">
                            </div>
                        </div>
                        <div>
                            <input type="submit" name="submitUser" class="btn btnM" value="Submit" tabindex="0"/>
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