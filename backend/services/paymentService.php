<?php
require_once('../models/Payment.php');

class PaymentService
{
    // Procesar un nuevo pago
    public function processPayment($participantId, $amount, $paymentDate)
    {
        $sql = "INSERT INTO payments (participant_id, amount, payment_date) VALUES (?, ?, ?)";
        return dbQueryPreparada($sql, [$participantId, $amount, $paymentDate]);
    }

    // Leer pagos (activos)
    public function listActivePayments()
    {
        $sql = "SELECT * FROM payments WHERE active = 1";
        $result = dbQuery($sql);
        $payments = [];
        while ($row = dbFetchAssoc($result)) {
            $payments[] = $row;
        }
        return $payments;
    }

    // Actualizar un pago
    public function updatePayment($id, $participantId, $amount, $paymentDate)
    {
        $sql = "UPDATE payments SET participant_id = ?, amount = ?, payment_date = ? WHERE id = ?";
        return dbQueryPreparada($sql, [$participantId, $amount, $paymentDate, $id]);
    }

    // Soft delete de un pago
    public function softDeletePayment($id)
    {
        $sql = "UPDATE payments SET active = 0 WHERE id = ?";
        return dbQueryPreparada($sql, [$id]);
    }

    // Leer pagos por participante
    public function getPaymentsByParticipant($participantId)
    {
        $sql = "SELECT * FROM payments WHERE participant_id = ? AND active = 1";
        $result = dbQueryPreparada($sql, [$participantId]);
    }
}
