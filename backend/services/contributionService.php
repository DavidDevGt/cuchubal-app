<?php
class ContributionService {
    // Crear una nueva contribución
    public function addContribution($data) {
        // SQL para insertar una nueva contribución
    }

    // Leer contribuciones (activas)
    public function listActiveContributions() {
        // SQL para seleccionar contribuciones donde active = 1
    }

    // Actualizar una contribución
    public function updateContribution($id, $data) {
        // SQL para actualizar una contribución por id
    }

    // Soft delete de una contribución
    public function softDeleteContribution($id) {
        // SQL para actualizar el campo 'active' a 0
    }
}