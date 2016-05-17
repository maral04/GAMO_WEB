<?php

/**
 * Clase Base de Dades, encarregada de recuperar la informació de la base de dades necessaria per l'aplicació
 */
class DataBase
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct()
    {
        $this->servername = "127.0.0.1";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "gamodb";
        $this->conn = $this->connect();
    }

    function connect (){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        mysqli_query($conn,"SET NAMES 'utf8'");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }else{
            return $conn;
        }
    }

    public function getConn()
    {
        return $this->conn;
    }


    public function recuperarEvent ($id = false){

        if($id == false) {
            $sql = "SELECT * FROM event";

            //$sql = "SELECT event.*, event.poblacio, prova.Id as provaId FROM event INNER JOIN prova ON prova.FK_Id_event = event.Id";

            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                return $result;
            } else {
                return false;
            }
        }else{
            $sql = "SELECT * FROM event WHERE id =".$id;

            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                return $result;
            } else {
                return false;
            }
        }
    }

    public function recuperarPaisos (){

        $sql = "SELECT * FROM apps_countries;";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function recuperarClubs (){
        $sql = "SELECT * FROM club;";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function recuperarProves ($idEvent, $totes = false){

        $sql = "SELECT * FROM prova WHERE FK_Id_event = ".$idEvent;
        $result = $this->conn->query($sql);

        // if(!$totes) die(mysqli_error($this->conn));

        die(mysqli_error($this->conn));
/*
        if ($result->num_rows > 0) {
            //if(!$totes) return mysqli_fetch_assoc($result);
            //else return $result;
            return $result;
        } else {
            return false;
        }*/
    }

    public function recuperarNumProves ($idEvent){

        $sql = "SELECT COUNT(*) FROM prova WHERE FK_Id_event = ".$idEvent;

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    public function recuperarProva ($idProva){
        $sql = "SELECT * FROM prova WHERE Id = ".$idProva;

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }
}
?>