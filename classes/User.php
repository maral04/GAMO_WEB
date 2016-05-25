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
    private $country;
    private $region;
    private $city;
    private $address;
    private $postalCode;
    private $img;
    private $gender;
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
            $sql = "SELECT usuari.*, club.nom as nomClub FROM usuari INNER JOIN club ON Fk_Id_Club = club.id WHERE usuari.id = ".trim($id);
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
            $sql = "SELECT usuari.*, club.Nom FROM usuari
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
                    else die(mysqli_stmt_error($mysql));
                }
                $error = "Error with register ";
            } else {
                $error = "Email already registered";
            }
        }else{
            if (!$this->exist(true)) {
                var_dump($this->phone2);
                if($this->img == null){
                    $mysql = mysqli_prepare($conn, "UPDATE usuari SET nom=?, cNom=?, email=?, esport=?, talla=?, tel1=?, tel2=?, dataNaix=?, FK_id_club =?, estat=?, regio=?, poblacio=?, direccio=?, cp=?, gender=? WHERE Id = ".$this->id) or die(mysqli_error($conn));
                    mysqli_stmt_bind_param($mysql, "ssssssssissssss", $this->name , $this->lastname, $this->email, $this->sport, $this->tshirt, $this->phone1, $this->phone2, $this->birth, $this->club, $this->country, $this->region, $this->city, $this->address, $this->postalCode, $this->gender);
                }else{
                    $mysql = mysqli_prepare($conn, "UPDATE usuari SET nom=?, cNom=?, email=?, esport=?, talla=?, tel1=?, tel2=?, dataNaix=?, FK_id_club =?, estat=?, regio=?, poblacio=?, direccio=?, cp=?, img=?, gender=? WHERE Id = ".$this->id) or die(mysqli_error($conn));
                    mysqli_stmt_bind_param($mysql, "ssssssssisssssss", $this->name , $this->lastname, $this->email, $this->sport, $this->tshirt, $this->phone1, $this->phone2, $this->birth, $this->club, $this->country, $this->region, $this->city, $this->address, $this->postalCode, $this->img, $this->gender);
                }

                if (mysqli_stmt_execute($mysql)) echo "Usuari actualitzat correctament";
                else $error = mysqli_stmt_error($mysql);
            } else {
                $error = "Email already registered";
            }
        }

        return $error;
    }

    private function exist($update = false){
        if($this->db == null)$this->db = new DataBase();
        $conn = $this->db->connect();

        if(!$update) $sql = "SELECT email FROM usuari WHERE email ='".trim($this->email)."'";
        else $sql = "SELECT email FROM usuari WHERE email ='".trim($this->email)."' AND Id != ".$this->id;

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

    public function getGender()
    {
        return $this->gender;
    }


    public function setGender($gender)
    {
        $this->gender = $gender;
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
                    return "Password Match Error";
                }
            } else {
                return "Password Format Error";
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
        if(is_numeric ($phone1)) {
            $this->phone1 = $phone1;
            return true;
        }else return false;
    }

    public function setPhone2($phone2)
    {
        if(is_numeric ($phone2)) {
            $this->phone2 = $phone2;
            return true;
        }else return false;
    }

    public function setBirth($birth)
    {

        if( strtotime($birth) < strtotime('now') ){$this->birth = $birth;return true;}
        else return false;
    }

    public function setTshirt($tshirt)
    {
        $this->tshirt = $tshirt;
    }



    public function setClub($club)
    {
        if(trim($club)!= "") $this->club = $club;
        else $this->club = null;
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
        if(is_numeric ($postalCode)) {
            $this->postalCode = $postalCode;
            return true;
        }
        else return false;
    }


    public function setImg($img)
    {
        $this->img = $img;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function getName()
    {
        return $this->name;
    }



}