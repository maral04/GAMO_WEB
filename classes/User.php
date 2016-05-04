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
    private $name;
    private $lastname;
    private $email;
    private $password;
    private $phone1;
    private $phone2;
    private $birth;
    private $tshirt;
    private $club;
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
        echo "hola";
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

    /**
     * @param mixed $name
     */
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



}