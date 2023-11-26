<?php
require_once __DIR__ . '/../models/Participant.php';

class ParticipantService
{
    // Crear un nuevo participante
    public function createParticipant($name, $contact, $address, $paymentMethod, $cuchubalId)
    {
        $participant = new Participant(0, $name, $contact, $address, $paymentMethod, $cuchubalId);
        $participant->save();
        return $participant->getId();
    }

    // Leer participantes (activos) de un cuchubal específico
    public function listActiveParticipantsByCuchubal($cuchubalId)
    {
        $sql = "SELECT * FROM participants WHERE active = 1 AND cuchubal_id = ?";
        $result = dbQueryPreparada($sql, [$cuchubalId]);
        $participants = [];
        while ($row = dbFetchAssoc($result)) {
            $participants[] = new Participant($row['id'], $row['name'], $row['contact'], $row['address'], $row['payment_method'], $row['cuchubal_id']);
        }
        return $participants;
    }

    // Actualizar un participante
    public function updateParticipant($id, $name, $contact, $address, $paymentMethod, $cuchubalId)
    {
        $participant = new Participant($id, $name, $contact, $address, $paymentMethod, $cuchubalId);
        $participant->save();
    }

    // Soft delete de un participante
    public function softDeleteParticipant($id)
    {
        $participant = Participant::getById($id);
        if ($participant) {
            $participant->delete();
        }
    }

    // Método para obtener un participante por su nombre o contacto dentro de un cuchubal específico
    public function getParticipantByNameOrContactInCuchubal($searchTerm, $cuchubalId)
    {
        $sql = "SELECT * FROM participants WHERE (name LIKE ? OR contact LIKE ?) AND active = 1 AND cuchubal_id = ?";
        $result = dbQueryPreparada($sql, ['%' . $searchTerm . '%', '%' . $searchTerm . '%', $cuchubalId]);
        $participants = [];
        while ($row = dbFetchAssoc($result)) {
            $participants[] = new Participant($row['id'], $row['name'], $row['contact'], $row['address'], $row['payment_method'], $row['cuchubal_id']);
        }
        return $participants;
    }

    // Activar un participante (en caso de que haya sido desactivado)
    public function activateParticipant($id)
    {
        $sql = "UPDATE participants SET active = 1 WHERE id = ?";
        dbQueryPreparada($sql, [$id]);
    }

    // Desactivar un participante (sin eliminarlo)
    public function deactivateParticipant($id)
    {
        $sql = "UPDATE participants SET active = 0 WHERE id = ?";
        dbQueryPreparada($sql, [$id]);
    }

    // Obtener la información detallada de un participante
    public function getParticipantDetails($id)
    {
        return Participant::getById($id);
    }
}
