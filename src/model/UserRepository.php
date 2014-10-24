<?php
// Something to fix in this class if I have the time, is to add field-size validation to this model and usermodel.
namespace model;

require_once("./src/model/UserModel.php");
require_once("./src/model/Repository.php");

class UserRepository extends Repository {
    private static $username = "Username";
    private static $password = "Password";
    private static $key = "LoginToken";
    private static $email = "Email";
    private static $userSalt = "FDFsuf37474¤#23?0434sDDA"; // NOTE! This string is also present in the UserModel. If you change this here, you must change it there as well!

    public function __construct() {
        $this->dbTable = "user";
    }

    // Adds a new user to the database, on adding the user, the $userSalt string is added to the $password string
    // Then the whole string is hashed with sha1(). This to increase security for the user.
    // Another thing of note is that the uniqe auto-login token is generated here.
    public function add($username, $password, $email) {
        $randomKey = md5(time());
        $db = $this->connection();
        $sql = "INSERT INTO $this->dbTable(" . self::$username . ", " . self::$password . ", " . self::$key . ", " . self::$email . ") VALUES (?, ?, ?, ?)";
        $params = array($username, sha1($password . self::$userSalt), $randomKey, $email);
        $query = $db->prepare($sql);
        $query->execute($params);
    }

    // Function for retrieving a user from the database, returns an array (to fix here is to return a UserModel object)
    public function get($username) {
        $db = $this->connection();
        $sql = "SELECT * FROM $this->dbTable WHERE " . self::$username . " = ?";
        $params = array($username);
        $query = $db->prepare($sql);
        $query->execute($params);
        $result = $query->fetch();
        if($result)
        {
            return $result;
        }
        return NULL;
    }

    // This function retrieves the uniqe login-token for a user, for automatic login with cookies.
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