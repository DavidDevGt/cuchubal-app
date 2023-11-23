<?php
require_once __DIR__ . '/../models/User.php';

class userService {
    // Crear un nuevo usuario
    public function createUser($username, $password) {
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        return dbQueryPreparada($sql, [$username, $hash_password]);
    }

    // Obtener un usuario por su username
    public function getUserByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $result = dbQueryPreparada($sql, [$username]);
        if ($row = dbFetchAssoc($result)) {
            return new User($row['id'], $row['username'], $row['password']);
        }
        return null;
    }

    // Actualizar la contraseña de un usuario
    public function updateUserPassword($id, $newPassword) {
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        return dbQueryPreparada($sql, [$newPassword, $id]);
    }

    // Obtener todos los usuarios
    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $result = dbQuery($sql);
        $users = [];
        while ($row = dbFetchAssoc($result)) {
            $users[] = new User($row['id'], $row['username'], $row['password']);
        }
        return $users;
    }

    // Soft delete de un usuario
    public function softDeleteUser($id) {
        $sql = "UPDATE users SET active = 0 WHERE id = ?";
        return dbQueryPreparada($sql, [$id]);
    }
}