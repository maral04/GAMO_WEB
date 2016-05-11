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
            $(".l2").attr("class", "l2 link link--kukuri currentL");
            $(".l3").attr("class", "l3 link link--kukuri");
        });
    </script>
    <div class="content" id="loginContent">
        <div class="container_12">
            <div class="formRegistre block3">
                <div id="login">
                    <form class="form-horizontal" method="post" action="actions/validateUser.php">
                        <fieldset>
                            <!-- Form Name -->
                            <h3 class="registre">Login</h3>

                            <!-- Text input-->
                            <div class="form-group">

                                <label class="col-md-4 control-label" for="tbEmail">Email</label>
                                <div class="col-md-6">
                                    <input id="tbEmail" name="tbEmail" type="email" placeholder="" class="form-control input-md" required="" tabindex="0" autofocus>

                                </div>
                            </div>

                            <!-- Password input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="tbPassword">Password</label>
                                <div class="col-md-6">
                                    <input id="tbPassword" name="tbPassword" type="password" placeholder="" class="form-control input-md" required="" tabindex="0">

                                </div>
                            </div>


                            <div class="btns">
                                <input type="submit" name="submitLogin" class="btn btnM" value="Submit" tabindex="0"/>
                            </div>

                            <?php
                            if(isset($_GET['error'])){
                                echo "<div class='error'><img src='images/icons/error.png'/>".$_GET['error']."</div>";
                            }
                            ?>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
</body>
<footer><?php include_once "footer.html"; ?></footer>