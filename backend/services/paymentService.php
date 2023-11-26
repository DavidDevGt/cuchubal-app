<?php
require_once __DIR__ . '/../models/Payment.php';

class PaymentService {

    // Crear un nuevo pago
    public function createPayment($participantId, $amount, $paymentDate, $cuchubalId) {
        $payment = new Payment(0, $participantId, $amount, $paymentDate, $cuchubalId);
        $payment->save();
        return $payment->getId();
    }

    // Obtener un pago por ID
    public function getPaymentById($id) {
        return Payment::getById($id);
    }

    // Actualizar un pago existente
    public function updatePayment($id, $participantId, $amount, $paymentDate, $cuchubalId) {
        $payment = new Payment($id, $participantId, $amount, $paymentDate, $cuchubalId);
        $payment->save();
    }

    // Eliminar un pago
    public function deletePayment($id) {
        $payment = Payment::getById($id);
        if ($payment) {
            $payment->delete();
        }
    }

    // Listar todos los pagos de un cuchubal específico
    public function listPaymentsByCuchubal($cuchubalId) {
        return Payment::getAllByCuchubalId($cuchubalId);
    }

    // Métodos adicionales según la lógica de negocio pueden incluir:
    // - Validar los pagos según el cronograma de pagos
    // - Actualizar el estado del cronograma de pagos
    // - Consultar pagos pendientes o completados
    // - Etc.
}
