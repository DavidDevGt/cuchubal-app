<?php
require_once('../models/Participant.php');

class ParticipantService
{
    // Crear un nuevo participante
    public function createParticipant($name, $contact, $address, $paymentMethod)
    {
        $sql = "INSERT INTO participants (name, contact, address, payment_method) VALUES (?, ?, ?, ?)";
        return dbQueryPreparada($sql, [$name, $contact, $address, $paymentMethod]);
    }

    // Leer participantes (activos)
    public function listActiveParticipants()
    {
        $sql = "SELECT * FROM participants WHERE active = 1";
        $result = dbQuery($sql);
        $participants = [];
        while ($row = dbFetchAssoc($result)) {
            $participants[] = $row;
        }
        return $participants;
    }

    // Actualizar un participante
    public function updateParticipant($id, $name, $contact, $address, $paymentMethod)
    {
        $sql = "UPDATE participants SET name = ?, contact = ?, address = ?, payment_method = ? WHERE id = ?";
        dbQueryPreparada($sql, [$name, $contact, $address, $paymentMethod, $id]);
    }

    // Soft delete de un participante
    public function softDeleteParticipant($id)
    {
        $sql = "UPDATE participants SET active = 0 WHERE id = ?";
        dbQueryPreparada($sql, [$id]);
    }

    // Método para obtener un participante por su nombre o contacto
    public function getParticipantByNameOrContact($searchTerm)
    {
        $sql = "SELECT * FROM participants WHERE (name LIKE ? OR contact LIKE ?) AND active = 1";
        return dbQueryPreparada($sql, ['%' . $searchTerm . '%', '%' . $searchTerm . '%']);
    }
}
