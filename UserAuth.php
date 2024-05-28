<?php
require_once 'config.php';

class User {
    protected $firstname;
    protected $lastname;
    protected $username;
    private $password;
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

    public function __destruct() {
        unset($this->firstname);
        unset($this->lastname);
        unset($this->username);
        unset($this->password);
        unset($this->email);
        unset($this->age);
        unset($this->student);
        unset($this->phone);
    }

    public function getUsername() { return $this->username; }
    public function setUsername($username) { $this->username = $username; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getFirstname() { return $this->firstname; }
    public function setFirstname($firstname) { $this->firstname = $firstname; }

    public function getLastname() { return $this->lastname; }
    public function setLastname($lastname) { $this->lastname = $lastname; }

    public function getAge() { return $this->age; }
    public function setAge($age) { $this->age = $age; }

    public function isStudent() { return $this->student; }
    public function setStudent($student) { $this->student = $student; }

    public function getPhone() { return $this->phone; }
    public function setPhone($phone) { $this->phone = $phone; }

    protected function hashPassword() { $this->password = password_hash($this->password, PASSWORD_DEFAULT); }
    public function verifyPassword($password) { return password_verify($password, $this->password); }
}

class UserAuth extends User {
    private $db;

    public function __construct($firstname, $lastname, $username, $email, $password, $age, $student, $phone) {
        parent::__construct($firstname, $lastname, $username, $email, $password, $age, $student, $phone);
        $this->db = Database::getConnection();
    }

    public function signup() {
        $stmt = $this->db->prepare("INSERT INTO user (firstname, lastname, email, username, password, age, student, phone) VALUES (:firstname, :lastname, :email, :username, :password, :age, :student, :phone)");
        $stmt->execute([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password, // Directly use the hashed password
            'age' => $this->age,
            'student' => $this->student,
            'phone' => $this->phone
        ]);
        return $this->db->lastInsertId() ? true : false;
    }

    // ... Login method (ensure to update as necessary)
}
?>