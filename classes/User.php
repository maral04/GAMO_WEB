<?php
include_once "DataBase.php";
/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 25/04/2016
 * Time: 12:53
 */
class User
{
    private $name;
    private $lastname;
    private $email;
    private $password;
    private $db;

    /**
     * User constructor.
     * @param $name
     * @param $lastname
     * @param $email
     * @param $password
     */

    public function _construct(){
        $this->db = new DataBase();
    }

    public function init($name, $lastname, $email, $password1, $password2)
    {
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->setPassword($password1,$password2);
    }

    public function validate ($email = null, $password = null){
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

    public function setPassword($password1,$password2)
    {
        if(trim($password1) != "" && trim($password2) != "" && $password2 ==  $password1 && strlen($password2) > 6 ){
            $this->password = $password1;
            return true;
        }else{
            return false;
        }

    }



}