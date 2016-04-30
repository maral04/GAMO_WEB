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

    /**
     * @return mysqli
     */
    public function getConn()
    {
        return $this->conn;
    }




}