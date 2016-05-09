<?php
/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 25/04/2016
 * Time: 12:53
 */
include_once "DataBase.php";

class User
{
    private $id;
    private $name;
    private $lastname;
    private $email;
    private $password;
    private $phone1;
    private $phone2;
    private $sport;
    private $birth;
    private $tshirt;
    private $club;
    private $idLocalitzacio;
    private $country;
    private $region;
    private $city;
    private $address;
    private $postalCode;
    private $db;


    public function _construct(){
        $this->db = new DataBase();

    }

    public function init($name, $lastname, $email, $password1, $password2)
    {
        $error = "";
        if(!$this->setName($name)) $error = "Required field names";
        if(!$this->setLastname($lastname))$error = "Required field lastname";
        $errorpsw = $this->setPassword($password1,$password2);

        if ($errorpsw === true)$error = "";
        else $error = $errorpsw;
        if (!$this->setEmail($email))$error = "Required field email";

        if(trim($error) == "")return true;
        else return $error;
    }

    public function load($id = null){
        if($this->db == null){
            $this->db = new DataBase();
        }

        $conn = $this->db->connect();

        if($id != null){
            $sql = "SELECT * FROM usuari INNER JOIN localitzacio
                    ON FK_Id_Localitzacio = localitzacio.id
                    INNER JOIN club ON Fk_Id_Club = club.id WHERE usuari.id = ".trim($id);
            $result = $conn->query($sql);
        }

        if ($result->num_rows > 0) {
            $arrayUser = mysqli_fetch_assoc($result);
            $this->setId($arrayUser['Id']);
            $this->setEmail($arrayUser['email']);
            $this->setName($arrayUser['nom']);
            $this->setLastname($arrayUser['cNom']);
            $this->setPassword($arrayUser['contrasenya']);
            return $arrayUser;
        } else {
            $sql = "SELECT * FROM usuari WHERE id = '".trim($id)."'";
            $result2 = $conn->query($sql);

            if ($result2->num_rows > 0) {
                $arrayUser = mysqli_fetch_assoc($result2);
                $this->setId($arrayUser['Id']);
                $this->setEmail($arrayUser['email']);
                $this->setName($arrayUser['nom']);
                $this->setLastname($arrayUser['cNom']);
                $this->setPassword($arrayUser['contrasenya']);
                return $arrayUser;
            }else return false;
        }
    }

    public function loadByEmail($email){
        if($this->db == null){
            $this->db = new DataBase();
        }
        echo $email;
        $conn = $this->db->connect();

        if($email != null){
            $sql = "SELECT usuari.*, club.Nom, localitzacio.cp, localitzacio.estat, localitzacio.regio,
                    localitzacio.poblacio, localitzacio.direccio, localitzacio.coordenades
                    FROM usuari INNER JOIN localitzacio ON FK_Id_Localitzacio = localitzacio.id
                    INNER JOIN club ON Fk_Id_Club = club.id WHERE usuari.email = '".trim($email)."'";
            echo $sql;
            $result = $conn->query($sql);
        }

        if ($result->num_rows > 0) {
            $arrayUser = mysqli_fetch_assoc($result);
            var_dump($arrayUser);
            $this->setId($arrayUser['Id']);
            $this->setEmail($arrayUser['email']);
            $this->setName($arrayUser['nom']);
            $this->setLastname($arrayUser['cNom']);
            $this->setPassword($arrayUser['contrasenya']);
            return $arrayUser;
        } else {
            $sql = "SELECT * FROM usuari WHERE email = '".trim($email)."'";
            $result2 = $conn->query($sql);

            if ($result2->num_rows > 0) {
                $arrayUser = mysqli_fetch_assoc($result2);
                $this->setId($arrayUser['Id']);
                $this->setEmail($arrayUser['email']);
                $this->setName($arrayUser['nom']);
                $this->setLastname($arrayUser['cNom']);
                $this->setPassword($arrayUser['contrasenya']);
                return $arrayUser;
            }else return false;
        }
    }

    public function validate ($email = null, $password = null){
        if($this->db == null){
            $this->db = new DataBase();
        }

        $conn = $this->db->connect();

        if($email != null && $password != null){
            $sql = "SELECT * FROM usuari WHERE email = '".trim($email)."' AND contrasenya = '".trim($password)."'";
        }else{
            $sql = "SELECT * FROM usuari WHERE email = '".trim($this->email)."' AND contrasenya = '".trim($this->password)."'";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }

        $conn->close();
    }

    public function save($update = false){
        if($this->db == null)$this->db = new DataBase();
        $conn = $this->db->connect();
        $error = "";

        if(!$update) {

            if (!$this->exist()) {
                if ($conn != null) {

                    $mysql = mysqli_prepare($conn, "INSERT INTO usuari (nom, cNom, email, contrasenya)  VALUES (?,?,?,?)");

                    mysqli_stmt_bind_param($mysql, "ssss", $this->name , $this->lastname, $this->email, $this->password );

                    if (mysqli_stmt_execute($mysql)) return true;
                    else echo mysqli_stmt_error($mysql);
                }
                $error = "Error with register ";
            } else {

                $error = "Email already registered";
            }
        }else{

            if($this->idLocalitzacio != null || trim($this->idLocalitzacio) != ""){
                $mysql = mysqli_prepare($conn, "UPDATE localitzacio SET estat=?, regio=?, poblacio=?, direccio=?, cp=? WHERE Id = ".$this->idLocalitzacio)or die(mysqli_error($conn));
                //var_dump($mysql);
                echo $this->country ." ". $this->region ." ". $this->city ." ". $this->address ." ". $this->postalCode;
                mysqli_stmt_bind_param($mysql, "ssssi", $this->country , $this->region, $this->city, $this->address, $this->postalCode );

                if (mysqli_stmt_execute($mysql)) echo "Update local" ;
                else $error = mysqli_stmt_error($mysql);
            }else{
                var_dump($this);
                $mysql = mysqli_prepare($conn, "INSERT INTO localitzacio (estat, regio, poblacio, direccio, cp)  VALUES (?,?,?,?,?)");

                mysqli_stmt_bind_param($mysql, "ssssi", $this->country , $this->region, $this->city, $this->address, $this->postalCode );

                if (mysqli_stmt_execute($mysql)) {
                    $this->idLocalitzacio = mysqli_insert_id($conn);
                    echo "Insert local";
                }
                else $error = mysqli_stmt_error($mysql);
            }
            $mysql = mysqli_prepare($conn, "UPDATE usuari SET nom=?, cNom=?, email=?, esport=?, talla=?, tel1=?, tel2=?, dataNaix=?, FK_id_club =?, FK_Id_Localitzacio=? WHERE Id = ".$this->id) or die(mysqli_error($conn));

            echo $this->phone1." ".$this->phone2;

            mysqli_stmt_bind_param($mysql, "sssssiisii", $this->name , $this->lastname, $this->email, $this->sport, $this->tshirt, $this->phone1, $this->phone2, $this->birth, $this->club, $this->idLocalitzacio);

            if (mysqli_stmt_execute($mysql)) echo "Usuari actualitzat correctament";
            else $error = mysqli_stmt_error($mysql);
        }

        return $error;
    }

    private function exist(){
        if($this->db == null)$this->db = new DataBase();
        $conn = $this->db->connect();

        $sql = "SELECT email FROM usuari WHERE email ='".trim($this->email)."'";

        $result = $conn->query($sql);

        if(is_object($result)) {
            if ($result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setSport($sport)
    {
        $this->sport = $sport;
    }



    public function setName($name)
    {
        if($name != null && $name != "") {
            $this->name = $name;
            return true;
        }else{
            return false;
        }
    }

    public function setLastname($lastname)
    {
        if($lastname != null && $lastname != "") {
            $this->lastname = $lastname;
            return true;
        }else{
            return false;
        }
    }

    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
            return true;
        }else return false;
    }

    public function setPassword($password1,$password2 = null)
    {
        if($password2!= null) {
            if (trim($password1) != "" && trim($password2) != "" && strlen($password2) >= 6) {
                if($password2 == $password1) {
                    $this->password = $password1;
                    return true;
                }else{
                    return "Passwords doesn't match";
                }
            } else {
                return "Passwords incorrects";
            }
        }else{
            if (strlen($password2) > 6) {
                $this->password = $password1;
                return true;
            } else {
                return false;
            }
        }

    }

    public function setPhone1($phone1)
    {
        $this->phone1 = $phone1;
    }

    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;
    }

    public function setBirth($birth)
    {

        if( strtotime($birth) < strtotime('now') )$this->birth = $birth;
        else return false;
    }

    public function setTshirt($tshirt)
    {
        $this->tshirt = $tshirt;
    }

    public function setClub($club)
    {
        $this->club = $club;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function setRegion($region)
    {
        $this->region = $region;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }


    public function setAddress($address)
    {
        $this->address = $address;
    }


    public function setPostalCode($postalCode)
    {
        if(is_numeric ($postalCode))
        $this->postalCode = intval($postalCode);
        else return false;
    }


    public function setIdLocalitzacio($idLocalitzacio)
    {
        $this->idLocalitzacio = $idLocalitzacio;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}