<?php
require_once __DIR__ . '/../models/Cuchubal.php';

class CuchubalService
{

    // Crear un nuevo cuchubal
    public function createCuchubal($userId, $name, $description, $amount, $startDate)
    {
        $cuchubal = new Cuchubal(0, $userId, $name, $description, $amount, $startDate);
        $cuchubal->save();
        return $cuchubal->getId();
    }

    // Obtener un cuchubal por su ID
    public function getCuchubalById($id)
    {
        return Cuchubal::getById($id);
    }

    // Actualizar un cuchubal existente
    public function updateCuchubal($id, $userId, $name, $description, $amount, $startDate)
    {
        $cuchubal = new Cuchubal($id, $userId, $name, $description, $amount, $startDate);
        $cuchubal->save();
    }
    // Eliminar un cuchubal
    public function deleteCuchubal($id)
    {
        $cuchubal = Cuchubal::getById($id);
        if ($cuchubal) {
            $cuchubal->delete();
        }
    }

    // Listar todos los cuchubales de un usuario específico
    public function listCuchubalesByUser($userId)
    {
        return Cuchubal::getAllByUserId($userId);
    }
}
