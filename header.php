<header>
    <div class="container_12">
        <div class="grid_12">
            <div class="grid_2 menuUser"><a class="link link--kukuri l1" data-letters="Profile" href="profile.php"><?php if(isset($_SESSION['idUser'])) echo "Profile";?></a></div>

            <?php
                var_dump($_SESSION);
            ?>
            <div class="grid_2 menuUser"><a class="link link--kukuri l2" data-letters="Organise" href="organise.php"><?php if(isset($_SESSION['idUser'])) echo "Organise";?></a></div>
                <?php
                echo "<div class='grid_2 menuUser fRight'>";
                    if(!isset($_SESSION['idUser'])){
                        echo "<a class='link link--kukuri l3' data-letters='Log In' href='login.php' </a>Log In";
                    }else{
                        echo "<a class='link link--kukuri l3' data-letters='Log Out' href='logout.php' </a>Log Out";
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
</header>