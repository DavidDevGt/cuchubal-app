<?php
require_once __DIR__ . '/../models/Payment.php';

class PaymentService
{

    // Crear un nuevo pago
    public function createPayment($participantId, $amount, $paymentDate, $cuchubalId)
    {
        $payment = new Payment(0, $participantId, $amount, $paymentDate, $cuchubalId);
        $payment->save();
        return $payment->getId();
    }

    // Obtener un pago por ID
    public function getPaymentById($id)
    {
        return Payment::getById($id);
    }

    // Actualizar un pago existente
    public function updatePayment($id, $participantId, $amount, $paymentDate, $cuchubalId)
    {
        $payment = new Payment($id, $participantId, $amount, $paymentDate, $cuchubalId);
        $payment->save();
    }

    // Eliminar un pago
    public function deletePayment($id)
    {
        $payment = Payment::getById($id);
        if ($payment) {
            $payment->delete();
        }
    }

    // Listar todos los pagos de un cuchubal específico
    public function listPaymentsByCuchubal($cuchubalId)
    {
        return Payment::getAllByCuchubalId($cuchubalId);
    }

    // Métodos adicionales según la lógica de negocio
    // Consultar el total de pagos realizados en un cuchubal específico
    public function getTotalPaymentsByCuchubal($cuchubalId)
    {
        $sql = "SELECT SUM(amount) as total FROM payments WHERE cuchubal_id = ?";
        $result = dbQueryPreparada($sql, [$cuchubalId]);
        if ($row = dbFetchAssoc($result)) {
            return $row['total'];
        }
        return 0;
    }

    // Método para consultar pagos pendientes o completados
    public function getPaymentsStatusByCuchubal($cuchubalId, $status)
    {
        $sql = "SELECT * FROM payments WHERE cuchubal_id = ? AND status = ?";
        $result = dbQueryPreparada($sql, [$cuchubalId, $status]);
        $payments = [];
        while ($row = dbFetchAssoc($result)) {
            $payments[] = new Payment($row['id'], $row['participant_id'], $row['amount'], $row['date'], $row['cuchubal_id']);
        }
        return $payments;
    }

    // Método para consultar los pagos realizados por un participante específico
    public function getPaymentsByParticipant($participantId)
    {
        $sql = "SELECT * FROM payments WHERE participant_id = ?";
        $result = dbQueryPreparada($sql, [$participantId]);
        $payments = [];
        while ($row = dbFetchAssoc($result)) {
            $payments[] = new Payment($row['id'], $row['participant_id'], $row['amount'], $row['date'], $row['cuchubal_id']);
        }
        return $payments;
    }
}
