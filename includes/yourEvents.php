<?php

include_once "classes/Prova.php";
include_once "classes/User.php";
include_once "classes/DataBase.php";
$usuari = new User();
$db = new DataBase();

if (isset($_SESSION['idUser'])) {
    $arrayUser = $usuari->load($_SESSION['idUser']);
} else {
    $arrayUser = false;
}
?>
<h3 class='h3__head1'>Your Events</h3>
<?php
if($arrayUser!= false) {
    $conn = $db->connect();
    $sql = "SELECT * FROM inscripcio INNER JOIN prova on FK_id_prova = prova.id WHERE id_participant = " . $arrayUser['Id']." AND data_hora_inici >= CURDATE()";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $i = 1;
        echo "<ul class='list sideList'>";
        while ($proves = mysqli_fetch_assoc($result)) {
            echo "<li>";
            echo "<div class='list_count'><a href='../fitxaProva.php?id=" .$proves['Id']."'>$i</a></div>";
            echo "<div class='extra_wrapper'><a href='../fitxaProva.php?id=" .$proves['Id']."'>" . $proves['nom'] . "</a></div>";
            echo "<div class='extra_wrapper'>" . date("Y-m-d", strtotime($proves['data_hora_inici'])) . "</div>";
            echo "</li>";
            $i++;
        }
        echo "<ul>";
    }else{
        echo "Events you joined will be displayed here";
    }
}else{
    echo "<p>Events you join will be displayed here.</p>";
    echo "<div id='loJoin'>";
    echo "<a class='link link--kukuri l4' data-letters='Log In' href='login.php'>Log In</a>";
    echo "&nbsp<img class='icoYourEvents' src='images/icons/rightLeft.png' alt='Choose'>&nbsp";
    echo "<a class='link link--kukuri l4' data-letters='Join' href='register.php'>Join</a>";
    echo "</div>";
}

?>


