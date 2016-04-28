<head>
<?php include_once "head.html"; ?>
</head>

<body class="" id="top">

<div class="main">
    <?php include_once "header.html"; ?>
    <div class="content">
        <div class="container_12">
            <div class="formRegistre block3">
                <form class="form-horizontal" method="post" action="actions/validateUser.php">
                    <fieldset>
                        <!-- Form Name -->
                        <h3 class="registre">Registre</h3>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbName">Name</label>
                            <div class="col-md-6">
                                <input id="tbNom" name="tbName" type="text" placeholder="" class="form-control input-md" required="">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbLastName">Last name</label>
                            <div class="col-md-6">
                                <input id="tbCognoms" name="tbLastName" type="text" placeholder="" class="form-control input-md" required="">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbEmail">Email</label>
                            <div class="col-md-6">
                                <input id="tbEmail" name="tbEmail" type="email" placeholder="" class="form-control input-md" required="">

                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbPassword">Password</label>
                            <div class="col-md-6">
                                <input id="tbPassword" name="tbPassword" type="password" placeholder="" class="form-control input-md" required="">

                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tbPasswordConfirm">Password confirmation</label>
                            <div class="col-md-6">
                                <input id="tbPasswordConfirm" name="tbPasswordConfirm" type="password" placeholder="" class="form-control input-md" required="">

                            </div>
                        </div>
                        <div class="btns">
                            <input type="submit" name="submitUser" class="btn" value="Submit"/>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
</body>
<footer><?php include_once "footer.html"; ?></footer>