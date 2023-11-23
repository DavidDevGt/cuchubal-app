<?php
require_once __DIR__ . '/../db/database.php';

class User {
    public $id;
    public $username;
    public $password;

    // Constructor
    public function __construct($id, $username, $password) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    // Getters y setters
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }
}