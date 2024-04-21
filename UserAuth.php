<?php
require_once 'config.php';

class User {
    protected $username;
    private $password;
    private $email;

    public function __construct($username, $email, $password) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        //e lidh me databaze
    }

    public function __destruct() {
        unset($this->username);
        unset($this->password);
        unset($this->email);
    }

    public function getUsername() { return $this->username; }
    public function setUsername($username) { $this->username = $username; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    protected function hashPassword() { $this->password = password_hash($this->password, PASSWORD_DEFAULT); }
    public function verifyPassword($password) { return password_verify($password, $this->password); }
}

class UserAuth extends User {
    private $db;

    public function __construct($username, $email, $password) {
        parent::__construct($username, $email, $password);
        //$this->db = Database::getConnection();
        $this->hashPassword();
    }

    public function login() {
        $stmt = $this->db->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->execute(['username' => $this->username]);
        $user = $stmt->fetch();
        if ($user && $this->verifyPassword($user['password'])) {
            $_SESSION['username'] = $this->username;
            setcookie("user_background", "white", time() + (86400 * 30), "/"); // 30 days expiration
            return true;
        }
        return false;
    }

    public function signup() {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute(['username' => $this->username, 'email' => $this->email, 'password' => $this->password]);
        return $this->db->lastInsertId() ? true : false;
    }
}
?>
