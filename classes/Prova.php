<?php

/*Creat per Marçal Bordoy Fàbregas.
Date: 11/05/2016 Time: 12:49 */
include_once "DataBase.php";

class Prova
{
    private $id;
    private $idEvent;
    private $Name;
    private $Description;
    private $IniDate;
    private $IniTime;
    private $Distance;
    private $Positive;
    private $Negtive;
    private $Checkpoints;
    private $TimeLimit;
    private $sport;
    private $Country;
    private $Region;
    private $City;
    private $postalCode;
    private $Address;
    private $Manager;
    private $Price;
    private $InscripcionsIni;
    private $InscripcionsFin;
    private $InscripcionsLimit;
    private $idOrganitzador;
    private $img;
    private $track;
    private $db;


    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function init( $idOrganitzador, $Name, $Description , $IniDate, $IniTime  ,$Distance, $Positive, $Negtive, $Checkpoints, $TimeLimit, $sport, $Country, $Region, $City, $Address,$cp, $Manager, $Price,  $InscripcionsIni, $InscripcionsFin, $limitInscripcions)
    {
        $this->setIdOrganitzador($idOrganitzador);
        $this->setName($Name);
        $this->setDescription($Description);
        $this->setIniDate($IniDate);
        $this->setIniTime($IniTime);
        $this->setDistance($Distance);
        $this->setPositive($Positive);
        $this->setNegtive($Negtive);
        $this->setCheckpoints($Checkpoints);
        $this->setTimeLimit($TimeLimit);
        $this->setsport($sport);
        $this->setCountry($Country);
        $this->setRegion($Region);
        $this->setCity($City);
        $this->setAddress($Address);
        $this->setManager($Manager);
        $this->setPrice($Price);
        $this->setInscripcionsIni($InscripcionsIni);
        $this->setInscripcionsFin($InscripcionsFin);
        $this->setPostalCode($cp);
        $this->setInscripcionsLimit($limitInscripcions);
    }
    public function load($id = null){
        if($this->db == null){
            $this->db = new DataBase();
        }

        $conn = $this->db->connect();

        if($id != null) {
            $sql = "SELECT * FROM prova WHERE prova.id = " . trim($id);
            $result = $conn->query($sql);


            if ($result->num_rows > 0) {
                $arrayProva = mysqli_fetch_assoc($result);
                //$this->setId($arrayProva['Id']);
                $this->setName($arrayProva['nom']);
                $this->setDescription($arrayProva['descripcio']);
                //$this->setIniDate($arrayProva['dataInici']);
                $this->setTimeLimit($arrayProva['temps_limit']);
                $this->setCountry($arrayProva['estat']);
                $this->setRegion($arrayProva['regio']);
                $this->setCity($arrayProva['poblacio']);
                $this->setAddress($arrayProva['direccio']);
                $this->setPostalCode($arrayProva['cp']);
                //$this->setImg($arrayProva['imatges']);
                return $arrayProva;
            }
        }
        return false;
    }

    public function save($idEvent = false, $update = false){
        if($this->db == null)$this->db = new DataBase();
        $conn = $this->db->connect();
        $error = "";

        if ($conn != null) {
            if($idEvent == false) {
                $mysql1 = mysqli_prepare($conn, "INSERT INTO event (idOrganitzador,titol,dataInici,dataFinal,descripcio,cp,
                                                    estat,regio,poblacio,direccio)
                                                    VALUES (?,?,?,?,?,?,?,?,?,?)");
                //die(mysqli_error($conn));

                mysqli_stmt_bind_param($mysql1, "isssssssss", $this->idOrganitzador, $this->Name, $this->IniDate, $this->IniDate, $this->Description,
                    $this->postalCode, $this->Country, $this->Region, $this->City, $this->Address);

                if (mysqli_stmt_execute($mysql1)) ;
                else echo mysqli_stmt_error($mysql1);

                $id = mysqli_insert_id($conn);
                $this->setIdEvent($id);
            }else{
                $this->setIdEvent($idEvent);
            }

            $mysql2 = mysqli_prepare($conn, "INSERT INTO prova (FK_Id_event,preu,distancia,desnivellPositiu,desnivellNegatiu,
                                                    num_avituallaments,nom,pagina_organitzacio,esports,
                                                    descripcio,data_hora_inici,obertura_inscripcions,tancament_inscripcionts,
                                                    temps_limit,limit_inscrits,cp,estat,regio,poblacio,direccio)
                                                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            //die(mysqli_error($conn));
            mysqli_stmt_bind_param($mysql2, "iddiiissssssssisssss", $this->idEvent, $this->Price, $this->Distance, $this->Positive,
                $this->Negtive, $this->Checkpoints, $this->Name, $this->Manager, $this->sport, $this->Description,
                $this->IniDate, $this->InscripcionsIni, $this->InscripcionsFin, $this->TimeLimit,$this->InscripcionsLimit, $this->postalCode,
                $this->Country, $this->Region, $this->City, $this->Address);

            if (mysqli_stmt_execute($mysql2)){
                $this->id = mysqli_insert_id($conn);

                if(trim($error) == "") return $this->id;
            } else echo mysqli_stmt_error($mysql2);
        }
        $error = "Error with register ";

        return $error;
    }

    public function updateImg(){
        if($this->db == null)$this->db = new DataBase();
        $conn = $this->db->connect();
        echo "Update img ".$this->img;
        $mysql = mysqli_prepare($conn, "UPDATE prova SET Imatges=? WHERE Id = ".$this->id) or die(mysqli_error($conn));
        mysqli_stmt_bind_param($mysql, "s", $this->img);

        if (mysqli_stmt_execute($mysql)) echo "IMG actualitzat correctament";
        else $error = mysqli_stmt_error($mysql);
    }

    public function updateGpx(){
        if($this->db == null)$this->db = new DataBase();
        $conn = $this->db->connect();
        echo "Update track ".$this->track;

        $mysql = mysqli_prepare($conn, "UPDATE prova SET recorregut=? WHERE Id = ".$this->id) or die(mysqli_error($conn));
        mysqli_stmt_bind_param($mysql, "s", $this->track);

        if (mysqli_stmt_execute($mysql)) echo "Track actualitzat correctament";
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


    public function setInscripcionsLimit($InscripcionsLimit)
    {
        $this->InscripcionsLimit = $InscripcionsLimit;
    }


    public function setIdEvent($idEvent)
    {
        $this->idEvent = $idEvent;
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

    public function setIniTime($IniTime)
    {
        $this->IniTime = $IniTime;
    }

    public function setDistance($Distance)
    {
        $this->Distance = $Distance;
    }

    public function setPositive($Positive)
    {
        $this->Positive = $Positive;
    }

    public function setNegtive($Negtive)
    {
        $this->Negtive = $Negtive;
    }


    public function setCheckpoints($Checkpoints)
    {
        $this->Checkpoints = $Checkpoints;
    }

    public function setTimeLimit($TimeLimit)
    {
        $this->TimeLimit = $TimeLimit;
    }

    public function setSport($sport)
    {
        if(is_array($sport)){
            foreach($sport as $s){
                $this->sport .= $s.",";
            }
        }else{
            $this->sport = $sport;
        }

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


    public function setPrice($Price)
    {
        $this->Price = $Price;
    }


    public function setInscripcionsIni($InscripcionsIni)
    {
        $this->InscripcionsIni = $InscripcionsIni;
    }


    public function setInscripcionsFin($InscripcionsFin)
    {
        $this->InscripcionsFin = $InscripcionsFin;
    }



    public function getTrack()
    {
        return $this->track;
    }


    public function setTrack($track)
    {
        $this->track = $track;
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