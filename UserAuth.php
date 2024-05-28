<?php
require_once 'config.php';  // Ensure this file has necessary configuration

class User {
    protected $firstname;
    protected $lastname;
    protected $username;
    protected $password;
    private $email;
    protected $age;
    protected $student;
    protected $phone;

    public function __construct($firstname, $lastname, $username, $email, $password, $age, $student, $phone) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->age = $age;
        $this->student = $student;
        $this->phone = $phone;
        $this->hashPassword();
    }

    protected function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }
}

class UserAuth extends User {
    private $db;

    public function __construct($firstname, $lastname, $username, $email, $password, $age, $student, $phone) {
        parent::__construct($firstname, $lastname, $username, $email, $password, $age, $student, $phone);
        global $conn;  // Use the global connection
        $this->db = $conn;
    }

    public function signup() {
        $stmt = $this->db->prepare("INSERT INTO user (emri, mbiemri, email, username, passHash, mosha, student, telefoni) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            error_log("Prepare failed: " . $this->db->error);
            return false; // Prevent further execution if prepare failed
        }
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bind_param("sssssiis", $this->firstname, $this->lastname, $this->email, $this->username, $hashedPassword, $this->age, $this->student, $this->phone);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
        if ($stmt->affected_rows === 0) {
            error_log("No rows affected: " . $stmt->error);
            return false;
        }
        return true;
    }
    
    
    
}
?>
