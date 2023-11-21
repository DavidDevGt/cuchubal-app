<?php
class ParticipantService {
    // Crear un nuevo participante
    public function createParticipant($data) {
        // SQL para insertar un nuevo participante
    }

    // Leer participantes (activos)
    public function listActiveParticipants() {
        // SQL para seleccionar participantes donde active = 1
    }

    // Actualizar un participante
    public function updateParticipant($id, $data) {
        // SQL para actualizar un participante por id
    }

    // Soft delete de un participante
    public function softDeleteParticipant($id) {
        // SQL para actualizar el campo 'active' a 0
    }
}
