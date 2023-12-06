<?php
require_once __DIR__ . '/../db/database.php';

class User
{
    public $id;
    public $username;
    public $password;
    public $active;
    public $created_at;
    public $updated_at;


    public function __construct($id = 0, $username = '', $password = '', $active = 1, $created_at = null, $updated_at = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->active = $active; // Nuevo
        $this->created_at = $created_at; // Nuevo
        $this->updated_at = $updated_at; // Nuevo
    }

    // Getters y setters
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }


    // Setters
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    // Métodos de Base de Datos
    public function save()
    {
        if ($this->id == 0) {
            // Creación de un nuevo usuario
            $sql = "INSERT INTO users (username, password, active) VALUES (?, ?, ?)";
            $this->id = dbQueryPreparada($sql, [$this->username, $this->password, $this->active]);
        } else {
            // Actualización de un usuario existente
            $sql = "UPDATE users SET username = ?, password = ?, active = ? WHERE id = ?";
            dbQueryPreparada($sql, [$this->username, $this->password, $this->active, $this->id]);
        }
    }


    public static function getById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $result = dbQueryPreparada($sql, [$id]);
        if ($row = dbFetchAssoc($result)) {
            return new User($row['id'], $row['username'], $row['password']);
        }
        return null;
    }

    public static function getAll()
    {
        $sql = "SELECT * FROM users";
        $result = dbQuery($sql);
        $users = [];
        while ($row = dbFetchAssoc($result)) {
            $users[] = new User($row['id'], $row['username'], $row['password'], $row['active'], $row['created_at'], $row['updated_at']);
        }
        return $users;
    }

    public function delete()
    {
        $sql = "UPDATE users SET active = 0 WHERE id = ?";
        dbQueryPreparada($sql, [$this->id]);
    }
}
