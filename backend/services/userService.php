<?php
require_once __DIR__ . '/../models/User.php';

class UserService
{
    public function createUser($username, $password)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->save();
        return $user->getId();
    }

    public function getUserById($id)
    {
        return User::getById($id);
    }

    public function getAllUsers()
    {
        return User::getAll();
    }

    public function updateUser($id, $username, $password)
    {
        $user = User::getById($id);
        if ($user) {
            $user->setUsername($username);
            $user->setPassword($password);
            $user->save();
        }
    }

    public function deleteUser($id)
    {
        $user = User::getById($id);
        if ($user) {
            $user->delete();
        }
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $result = dbQueryPreparada($sql, [$username]);
        if ($row = dbFetchAssoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user'] = ['id' => $row['id'], 'username' => $row['username']];
                return true;
            }
        }
        return false;
    }
}
