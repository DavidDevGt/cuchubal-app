<?php
require_once __DIR__ . '/../db/database.php';

class User {
    public $id;
    public $username;
    public $password;

    public function __construct($id = 0, $username = '', $password = '') {
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

    // Setters
    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Métodos de Base de Datos
    public function save() {
        if ($this->id == 0) {
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $this->id = dbQueryPreparada($sql, [$this->username, $this->password]);
        } else {
            $sql = "UPDATE users SET username = ?, password = ? WHERE id = ?";
            dbQueryPreparada($sql, [$this->username, $this->password, $this->id]);
        }
    }

    public static function getById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $result = dbQueryPreparada($sql, [$id]);
        if ($row = dbFetchAssoc($result)) {
            return new User($row['id'], $row['username'], $row['password']);
        }
        return null;
    }

    public static function getAll() {
        $sql = "SELECT * FROM users";
        $result = dbQuery($sql);
        $users = [];
        while ($row = dbFetchAssoc($result)) {
            $users[] = new User($row['id'], $row['username'], $row['password']);
        }
        return $users;
    }

    public function delete() {
        $sql = "UPDATE users SET active = 0 WHERE id = ?";
        dbQueryPreparada($sql, [$this->id]);
    }
}
