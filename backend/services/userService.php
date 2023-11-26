<?php
require_once __DIR__ . '/../models/User.php';

class UserService {
    public function createUser($username, $password) {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->save();
        return $user->getId();
    }

    public function getUserById($id) {
        return User::getById($id);
    }

    public function getAllUsers() {
        return User::getAll();
    }

    public function updateUser($id, $username, $password) {
        $user = User::getById($id);
        if ($user) {
            $user->setUsername($username);
            $user->setPassword($password);
            $user->save();
        }
    }

    public function deleteUser($id) {
        $user = User::getById($id);
        if ($user) {
            $user->delete();
        }
    }
}
