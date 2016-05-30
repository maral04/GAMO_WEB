<header>
    <div class="container_12">
        <div class="grid_12">
            <div class="grid_2 menuUser">
                <?php if(isset($_SESSION['idUser'])){ ?>
                    <img class='icoFitxa2'
                    <?php if($_SESSION['imgUser'] == null){
                        echo "src='images/icons/profileDefault.png'";
                        echo "alt='Profile Image'>";
                    } else{
                        if(is_file("images/profile/".$_SESSION['idUser']."/".$_SESSION['imgUser']))
                        echo "src='images/profile/".$_SESSION['idUser']."/".$_SESSION['imgUser']."'";
                        else echo "src='images/icons/profileDefault.png'";
                        echo "alt='Profile Image'>";
                    } ?>
                    <a class="link link--kukuri l1" data-letters="<?php echo $_SESSION['nameUser']; ?>" href="profile.php"><?php echo $_SESSION['nameUser'];?></a>
                <?php }?>
            </div>
            <div class="grid_2 menuUser">
                <?php
                if(isset($_SESSION['idUser'])){
                    echo "<img class='icoFitxa2' src='images/icons/organize.png' alt='Organize'>";
                    echo "<a class='link link--kukuri l2' data-letters='Organize' href='organize.php'>Organize</a>";
                 } ?>
            </div>
                <?php
                echo "<div class='grid_2 menuUser fRight'>";
                    if(!isset($_SESSION['idUser'])){
                        echo "<a class='link link--kukuri l3' data-letters='Log In' href='login.php'>Log In</a>";
                    }else{
                        echo "<img class='icoFitxa2' src='images/icons/logout.png' alt='Logout'><a class='link link--kukuri l3' data-letters='Log Out' href='logout.php'> Log Out</a>";
                    }
                    echo "</div>";
                ?>
            <div class="grid_2 menuUser fRight"><a class="link link--kukuri l4" data-letters="Join" href="register.php"><?php if(!isset($_SESSION['idUser'])) echo "Join";?></a></div>
        </div>
        <div class="grid_12">
            <h1>
                <a href="index.php">
                    <img src="images/logo.png" alt="GAMO">
                </a>
            </h1>
            <div class="menu_block">
                <nav class="horizontal-nav full-width horizontalNav-notprocessed">
                    <ul class="sf-menu">
                        <!--<li class="li1"><a href="eliminaralPUBLICAR/index.php">Home</a></li>-->
                        <li class="li2"><a href="index.php">Event List</a></li>
                        <li class="li3"><a href="raceCalendar.php">Race Calendar</a></li>
                    </ul>
                </nav>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <script>
        //Si estem a join o login, no mostra el menú lateral.
        $(document).ready(function () {
            if(window.location.href.indexOf("register.php") != -1 || window.location.href.indexOf("login.php") != -1) {
                //No mostra el menu lateral.
            }else{
                //Mostra el menu lateral
                $('#menuLateral').fadeIn(335);
            }
        });
    </script>
    <?php
        echo "<div id='menuLateral'>";
            if(!isset($_SESSION['idUser'])){
    ?>
                </br>
                <a class="link link--kukuri l4" data-letters="Join" href="register.php"><?php if(!isset($_SESSION['idUser'])) echo "Join";?></a>
                </br>
            <?php
                echo "<a class='link link--kukuri l3' data-letters='Log In' href='login.php'>Log In</a>";
            }else{
            ?>
                <a class="link link--kukuri l1" data-letters="<?php echo $_SESSION['nameUser']; ?>" href="profile.php"><?php echo $_SESSION['nameUser'];?></a>
                <a class="link link--kukuri l2" data-letters="Organize" href="organize.php"><?php if(isset($_SESSION['idUser'])) echo "Organize";?></a>
                <?php
                echo "<a class='link link--kukuri l3' data-letters='Log Out' href='logout.php'>Log Out</a>";
            }
        echo "</div>";
                ?>
</header>