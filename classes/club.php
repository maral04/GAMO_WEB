<?php

/**
 * Created by PhpStorm.
 * User: cabre_000
 * Date: 18/5/2016
 * Time: 8:45
 */
class Club
{
    private $db;
    private $nom;
    private $urlImg;
    public function _construct()
    {
        $this->db = new DataBase();

    }
    public function validate($nom,$descr)
    {
        if($this->db == null){
            $this->db = new DataBase();
        }

        $conn = $this->db->connect();
        if( $descr != null &&  $nom!= null){


            $error = "";
            if (!$this->exist()) {

                if ($conn != null) {

                    $mysql = mysqli_prepare($conn, "INSERT INTO club (nom,descripcio,imatge)  VALUES (?,?,?)");

                    mysqli_stmt_bind_param($mysql, "sss", $this->nom,$descr,$this->urlImg );

                    if (mysqli_stmt_execute($mysql)) return true;
                    else echo mysqli_stmt_error($mysql);
                }
                $error = "Error with register ";
            } else {
                $error = "Club name already registered";
            }

        }$error = "The name and the description have to be";

        return $error;
    }



public    function carregarFitxer($f, $id) {
        $nomFitxer = "";
        var_dump($f);
        if ($f['error'] == 0) {
            if (!file_exists('../images/club/'.$id)) {
                mkdir('../images/club/'.$id, 0777, true);
            }
            echo '../images/club/'.$id. "/" . $f['name'];
            if (move_uploaded_file($f['tmp_name'], '../images/club/'.$id. "/" . $f['name'])) {
                $nomFitxer = $f['name'];
            } else {
                $nomFitxer = $f['name'];
                echo "Error en guardar el fitxer al servidor";
            }
        } else {
            echo "Error en carregar l'imatge";
        }
        return $nomFitxer;
    }

    public function setName($name)
    {
        if($name != null && $name != "") {
            $this->nom = $name;
            return true;
        }else{
            return false;
        }
    }
    public function setUrlImg($url)
    {
        if($url != null && $url != "") {
            $this->urlImg= $url;
            return true;
        }else{
            return false;
        }
    }
    public function exist(){
        if($this->db == null){
            $this->db = new DataBase();
        }

        $conn = $this->db->connect();
        $sql = "SELECT nom From club WHERE nom =".$this->nom;
        $result = $conn->query($sql);
        if(is_object($result)) {
            if ($result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
}
