<?php

/*Creat per Marçal Bordoy Fàbregas.
Date: 11/05/2016 Time: 12:49 */
include_once "DataBase.php";

class Event
{
    private $id;
    private $Name;
    private $Description;
    private $IniDate;
    private $FinalDate;
    private $Country;
    private $Region;
    private $City;
    private $postalCode;
    private $Address;
    private $idOrganitzador;
    private $img;
    private $db;


    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function init( $idOrganitzador, $Name, $Description , $IniDate, $FinalDate , $Country, $Region, $City, $Address,$cp)
    {
        $this->setIdOrganitzador($idOrganitzador);
        $this->setName($Name);
        $this->setDescription($Description);
        $this->setIniDate($IniDate);
        $this->setFinalDate($FinalDate);
        $this->setCountry($Country);
        $this->setRegion($Region);
        $this->setCity($City);
        $this->setAddress($Address);
        $this->setPostalCode($cp);
    }

    public function save($update = false){
        if($this->db == null)$this->db = new DataBase();
        $conn = $this->db->connect();
        $error = "";

        if(!$update) {

            //if (!$this->exist()) {
            echo "update";
            if ($conn != null) {
                $mysql1 = mysqli_prepare($conn, "INSERT INTO event (idOrganitzador,titol,dataInici,dataFinal,descripcio,cp,
                                                    estat,regio,poblacio,direccio)
                                                    VALUES (?,?,?,?,?,?,?,?,?,?)");
                //die(mysqli_error($conn));

                mysqli_stmt_bind_param($mysql1, "isssssssss", $this->idOrganitzador,$this->Name, $this->IniDate, $this->IniDate, $this->Description,
                    $this->postalCode, $this->Country, $this->Region, $this->City,$this->Address);

                if (mysqli_stmt_execute($mysql1));
                else echo mysqli_stmt_error($mysql1);

                $id = mysqli_insert_id($conn);
                $this->setId($id);
                return $id;
            }
            $error = "Error with register ";
        }

        return $error;
    }

    public function load($id = null){
        if($this->db == null){
            $this->db = new DataBase();
        }

        $conn = $this->db->connect();

        if($id != null) {
            $sql = "SELECT * FROM event WHERE event.id = " . trim($id);
            $result = $conn->query($sql);


            if ($result->num_rows > 0) {
                $arrayEvent = mysqli_fetch_assoc($result);
                $this->setId($arrayEvent['Id']);
                $this->setName($arrayEvent['titol']);
                $this->setIdOrganitzador($arrayEvent['idOrganitzador']);
                $this->setDescription($arrayEvent['descripcio']);
                $this->setIniDate($arrayEvent['dataInici']);
                $this->setFinalDate($arrayEvent['dataFinal']);
                $this->setCountry($arrayEvent['estat']);
                $this->setRegion($arrayEvent['regio']);
                $this->setCity($arrayEvent['poblacio']);
                $this->setAddress($arrayEvent['direccio']);
                $this->setPostalCode($arrayEvent['cp']);
                $this->setImg($arrayEvent['imatges']);
                return $arrayEvent;
            }
        }
        return false;
    }

    public function updateImg(){
        if($this->db == null)$this->db = new DataBase();
        $conn = $this->db->connect();
        echo "Update img ".$this->img;
        $mysql = mysqli_prepare($conn, "UPDATE event SET imatges=? WHERE Id = ".$this->id) or die(mysqli_error($conn));
        mysqli_stmt_bind_param($mysql, "s", $this->img);

        if (mysqli_stmt_execute($mysql)) echo "IMG actualitzat correctament";
        else $error = mysqli_stmt_error($mysql);
    }

    public function getIdOrganitzador()
    {
        return $this->idOrganitzador;
    }


    public function setIdOrganitzador($idOrganitzador)
    {
        $this->idOrganitzador = intval($idOrganitzador);
    }


    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($Name)
    {
        $this->Name = $Name;
    }


    public function setDescription($Description)
    {
        $this->Description = $Description;
    }

    public function setIniDate($IniDate)
    {
        $this->IniDate = $IniDate;
    }

    public function setFinalDate($finalDate)
    {
        $this->FinalDate = $finalDate;
    }

    public function setCountry($Country)
    {
        $this->Country = $Country;
    }

    public function setRegion($Region)
    {
        $this->Region = $Region;
    }

    public function setCity($City)
    {
        $this->City = $City;
    }

    public function setAddress($Address)
    {
        $this->Address = $Address;
    }


    public function setManager($Manager)
    {
        $url = trim($Manager);

        $disallowed = array('http://', 'https://', 'ftp://');
        foreach($disallowed as $d) {
            if(strpos($url, $d) === 0) {
                $this->Manager = str_replace($d, '', $url);
                return true;
            }
        }
        $this->Manager = $Manager;
    }



    public function getImg()
    {
        return $this->img;
    }


    public function setImg($img)
    {
        $this->img = $img;
    }




}