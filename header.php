<header>
    <?php if (isset($_SESSION['idUser']))echo $_SESSION['idUser'];?>
    <div class="container_12">
        <div class="grid_12">
            <div class="grid_2 menuUser"><a class="link link--kukuri l1" data-letters="Profile" href="profile.php"><?php if(isset($_SESSION['idUser'])) echo "Profile";?></a></div>
            <div class="grid_2 menuUser fRight"><a class="link link--kukuri l2" data-letters="Log In" <?php if(!isset($_SESSION['idUser'])) echo "href=\"login.php\"" ;else echo "href=\"logout.php\"" ?>><?php if(!isset($_SESSION['idUser'])) echo "Log in" ;else echo "Log out" ?></a></div>
            <div class="grid_2 menuUser fRight"><a class="link link--kukuri l3" data-letters="Join" href="register.php"><?php if(!isset($_SESSION['idUser'])) echo "Join";?></a></div>
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
                        <li class="li1"><a href="index.php">Home</a></li>
                        <li class="li2"><a href="eventList.php">Event List</a></li>
                        <li class="li3"><a href="raceCalendar.php">Race Calendar</a></li>
                    </ul>
                </nav>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</header>