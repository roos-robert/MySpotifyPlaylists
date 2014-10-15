<?php

namespace model;

require_once("./src/model/UserModel.php");
require_once("./src/model/Repository.php");

class UserRepository extends Repository {

    private static $username = "Username";
    private static $password = "Password";
    private static $key = "LoginToken";
    private static $email = "Email";
    private $user;

    public function __construct() {
        $this->dbTable = "user";
       //$this->user = $user;
    }

    public function add($username, $password, $email) {
        $randomKey = md5(time());
        $db = $this->connection();
        $sql = "INSERT INTO $this->dbTable(" . self::$username . ", " . self::$password . ", " . self::$key . ", " . self::$email . ") VALUES (?, ?, ?, ?)";
        $params = array($username, md5($password), $randomKey, $email);
        $query = $db->prepare($sql);
        $query->execute($params);
    }

    public function get($username) {
        $db = $this->connection();
        $sql = "SELECT * FROM $this->dbTable WHERE " . self::$username . " = ?";
        $params = array($username);
        $query = $db->prepare($sql);
        $query->execute($params);
        $result = $query->fetch();
        if($result)
        {
            //$this->user->setUser($result[self::$username], $result[self::$password], $result[self::$key]);
            return $result;
        }
        return NULL;
    }

    public function getKey($key) {
        $db = $this->connection();
        $sql = "SELECT * FROM $this->dbTable WHERE " . self::$key . " = ?";
        $params = array($key);
        $query = $db->prepare($sql);
        $query->execute($params);
        $result = $query->fetch();
        if($result)
        {
            $this->user->setUser($result[self::$username], $result[self::$password], $result[self::$key]);
            return $result;
        }
        return NULL;
    }
}