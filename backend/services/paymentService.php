<?php
class PaymentService {
    // Procesar un nuevo pago
    public function processPayment($data) {
        // SQL para insertar un nuevo pago
    }

    // Leer pagos (activos)
    public function listActivePayments() {
        // SQL para seleccionar pagos donde active = 1
    }

    // Actualizar un pago
    public function updatePayment($id, $data) {
        // SQL para actualizar un pago por id
    }

    // Soft delete de un pago
    public function softDeletePayment($id) {
        // SQL para actualizar el campo 'active' a 0
    }
}