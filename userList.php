<head>
    <?php

    include_once "head.php";
    include_once "classes/DataBase.php";

    $db = new DataBase();
    $conn = $db->connect();
    ?>
    <title>GAMO: List of Users</title>
</head>
<body>
<div class="main">
    <?php include_once "header.php"; ?>

    <div class="content container_12" >
        <?php

            $sql = "SELECT * FROM usuari";

            $result = $db->getConn()->query($sql);
            echo "<div class='grid_12'>";
            echo "<h3 class='registre h3__head1'>List of Users</h3>";
            echo "</div>";
            echo "<div class='grid_11 block3'>";
            if(is_object($result)){

                if ($result->num_rows > 0) {
                    echo "<table class='taulaintro'>";
                    echo "<tr>
                            <th>Name</th>
                            <th>Last Name</th>
                            <th>Disabled</th></tr>
                            ";
                    while ($arrayEvent = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $arrayEvent['nom'] . "</td><td>" . $arrayEvent['cNom'] . "</td><td>

                        <div class='slideTwo'>
                            <input type='checkbox' value='None' id='slideTwo' name='check' />
                            <label for='slideTwo'></label>
                        </div>
                        </td></tr>";
                    }
                    echo "</table>";

                } else {
                }
            }else{

            }

        ?>
    </div>
</div>
<div class="clear"></div>
</div>
</body>
<footer><?php include_once "footer.html"; ?></footer>
