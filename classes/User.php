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
            echo $sql;
            $result = $conn->query($sql);
        }

        if ($result->num_rows > 0) {
            $arrayUser = mysqli_fetch_assoc($result);
            $this->setEmail($arrayUser['email']);
            $this->setName($arrayUser['nom']);
            $this->setLastname($arrayUser['cNom']);
            $this->setPassword($arrayUser['contrasenya']);

            return $arrayUser;
        } else {
            return false;
        }
    }

    public function loadByEmail($email){
        if($this->db == null){
            $this->db = new DataBase();
        }

        $conn = $this->db->connect();

        if($email != null){
            $sql = "SELECT * FROM usuari INNER JOIN localitzacio
                    ON FK_Id_Localitzacio = localitzacio.id
                    INNER JOIN club ON Fk_Id_Club = club.id WHERE usuari.email = '".trim($email)."'";
            echo $sql;
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
            return false;
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

        if(!$update) {
            $error = "";
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
            if($this->idLocalitzacio != null){
                $mysql = mysqli_prepare($conn, "UPDATE localitzacio SET estat=?, regio=?, poblacio=?, direccio=?, cp=? WHERE Id = ".$this->idLocalitzacio)or die(mysqli_error($conn));
                //var_dump($mysql);
                echo $this->country ." ". $this->region ." ". $this->city ." ". $this->address ." ". $this->postalCode;
                mysqli_stmt_bind_param($mysql, "ssssi", $this->country , $this->region, $this->city, $this->address, $this->postalCode );

                if (mysqli_stmt_execute($mysql)) echo "Insert local" ;
                else echo mysqli_stmt_error($mysql);
            }else{
                $mysql = mysqli_prepare($conn, "INSERT INTO localitzacio (estat, regio, poblacio, direccio, cp)  VALUES (?,?,?,?,?)");

                mysqli_stmt_bind_param($mysql, "ssssi", $this->country , $this->region, $this->city, $this->address, $this->postalCode );

                if (mysqli_stmt_execute($mysql)) echo "Update local" ;
                else echo mysqli_stmt_error($mysql);
            }
            echo "UPDATE usuari SET nom=?, cNom=?, email=?, esport=?, talla=?, tel1=?, tel2=?, FK_id_club =?, FK_Id_Localitzacio=? WHERE Id = ".$this->id;
            $mysql = mysqli_prepare($conn, "UPDATE usuari SET nom=?, cNom=?, email=?, esport=?, talla=?, tel1=?, tel2=?, FK_id_club =?, FK_Id_Localitzacio=? WHERE Id = ".$this->id) or die(mysqli_error($conn));

            echo $this->phone1." ".$this->phone2;

            mysqli_stmt_bind_param($mysql, "sssssiiii", $this->name , $this->lastname, $this->email, $this->sport, $this->tshirt, $this->phone1, $this->phone2, $this->club, $this->idLocalitzacio);

            if (mysqli_stmt_execute($mysql)) echo "Usuari actualitzat correctament";
            else echo mysqli_stmt_error($mysql);
        }

        //return $error;
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

    /**
     * @param mixed $id
     */
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

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        if($lastname != null && $lastname != "") {
            $this->lastname = $lastname;
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mixed $email
     */
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

    /**
     * @param mixed $phone1
     */
    public function setPhone1($phone1)
    {
        $this->phone1 = $phone1;
    }

    /**
     * @param mixed $phone2
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;
    }

    /**
     * @param mixed $birth
     */
    public function setBirth($birth)
    {
        if( strtotime($birth) < strtotime('now') )$this->birth = $birth;
        else return false;
    }

    /**
     * @param mixed $tshirt
     */
    public function setTshirt($tshirt)
    {
        $this->tshirt = $tshirt;
    }

    /**
     * @param mixed $club
     */
    public function setClub($club)
    {
        $this->club = $club;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @param mixed $postalCode
     */
    public function setPostalCode($postalCode)
    {
        if(is_numeric ($postalCode))
        $this->postalCode = intval($postalCode);
        else return false;
    }

    /**
     * @param mixed $idLocalitzacio
     */
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