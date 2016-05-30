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


    public function recuperarEvent ($id = false, $filtres = false){

        if($id == false) {
            /*if(!isset($filtres['from']) || !isset($filtres['to'])){
                $sql = "SELECT * FROM event where Id IN (select FK_Id_event FROM prova where esports LIKE '%".$filtres['sport']."%') limit 0,5";
            }*/
            if(isset($filtres['search'])){
                $sql = "SELECT * FROM event WHERE Id IN (Select FK_Id_event FROM prova where nom LIKE '%".$filtres['search']."%' OR descripcio LIKE '%".$filtres['search']."%') OR titol LIKE '%".$filtres['search']."%' OR poblacio LIKE'%".$filtres['search']."%' limit ".$filtres['from'].",5";
            }else if(isset($filtres['sport'])){
                $sql = "SELECT * FROM event where Id IN (select FK_Id_event FROM prova where esports LIKE '%".$filtres['sport']."%') limit ".$filtres['from'].",5";
            }else $sql = "SELECT * FROM event ORDER BY dataInici DESC limit ".$filtres['from'].",5";

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
        //die(mysqli_error($this->conn));
        if(is_object($result)) {
            if ($result->num_rows > 0) {
                if (!$totes) return mysqli_fetch_assoc($result);
                else return $result;
                //return $result;
            } else {
                return false;
            }
        }else return false;
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

    public function recuperarNumEvents ($filtre = false){

        if(!$filtre)
            $sql = "SELECT count(*) FROM event WHERE 0 < (SELECT count(*) FROM prova where Fk_Id_Event = event.Id)";
        else{
            if(isset($filtre['sport']))
                $sql = "SELECT count(*) FROM event WHERE 0 < (SELECT count(*) FROM prova where Fk_Id_Event = event.Id AND esports LIKE '%".$filtre['sport']."%')";
            else if(isset($filtre['search']))
                $sql = "SELECT count(*) FROM event WHERE titol LIKE '%".$filtre['search']."%' OR poblacio LIKE '%".$filtre['search']."%'";
            else
                $sql = "SELECT count(*) FROM event WHERE 0 < (SELECT count(*) FROM prova where Fk_Id_Event = event.Id)";

        }

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    public function recuperarProva ($idProva){
        $sql = "SELECT *, (SELECT count(*) FROM inscripcio WHERE FK_id_prova = ".$idProva.") as inscrits FROM prova WHERE Id = ".$idProva;

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }
}
?>