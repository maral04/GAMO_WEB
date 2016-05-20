<?php
/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 20/05/2016
 * Time: 8:54
 */
if(isset($_POST['submitEvent'])) {
    $event = new Event();
    $event->init($idUser, $_POST['tbName'], $_POST['tbDescription'], $_POST['tbIniDate'], $_POST['tbFinDate'], $_POST['tbCountry'], $_POST['tbRegion'], $_POST['tbCity'], $_POST['tbAddress'], $_POST['tbCp']);
    $result = $event->save();
    echo "result " . $result;

    if (is_numeric($result)) {
        echo "Numeric";
        $_SESSION['idEvent'] = $result;
        if (trim($_FILES['tbImages']['name']) != "") {
            // echo "name ".$_FILES['tbImages'];
            $file = carregarFitxer($_FILES['tbImages'], $result, 3);
            if (trim($file) != "") $event->setImg($file);
            else $event->setImg(null);
        } else {
            echo "Null";
            $event->setImg(null);
        }
        $event->updateImg();
        header("Location: ../createProva.php");
    } else {
        header("Location: ../createEvent.php?error=" . $result);
    }

    var_dump($event);
}else if (isset($_POST['updateEvent'])){
    $event = new Event();
    $event->init($idUser, $_POST['tbName'], $_POST['tbDescription'], $_POST['tbIniDate'], $_POST['tbFinDate'], $_POST['tbCountry'], $_POST['tbRegion'], $_POST['tbCity'], $_POST['tbAddress'], $_POST['tbCp']);
    $result = $event->save();
    echo "result " . $result;

    if (is_numeric($result)) {
        echo "Numeric";
        $_SESSION['idEvent'] = $result;
        if (trim($_FILES['tbImages']['name']) != "") {
            // echo "name ".$_FILES['tbImages'];
            $file = carregarFitxer($_FILES['tbImages'], $result, 3);
            if (trim($file) != "") $event->setImg($file);
            else $event->setImg(null);
        } else {
            echo "Null";
            $event->setImg(null);
        }
        $event->updateImg();
        header("Location: ../createProva.php");
    } else {
        header("Location: ../createEvent.php?error=" . $result);
    }

    var_dump($event);

}