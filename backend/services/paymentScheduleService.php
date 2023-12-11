<?php
require_once __DIR__ . '/../models/PaymentSchedule.php';

class PaymentScheduleService
{
    // Crear nueva programación de pago
    public function createPaymentSchedule($cuchubalId, $participantId, $scheduledDate, $amount, $status, $notes, $paymentDate, $paymentReference, $paymentMethod, $paymentConfirmed)
    {
        $schedule = new PaymentSchedule(0, $cuchubalId, $participantId, $scheduledDate, $amount, $status, $notes, $paymentDate, $paymentReference, $paymentMethod, $paymentConfirmed);
        $schedule->save();
        return $schedule->getId();
    }

    // Actualizar programación de pago existente
    public function updatePaymentSchedule($id, $cuchubalId, $participantId, $scheduledDate, $amount, $status, $notes, $paymentDate, $paymentReference, $paymentMethod, $paymentConfirmed)
    {
        $schedule = new PaymentSchedule($id, $cuchubalId, $participantId, $scheduledDate, $amount, $status, $notes, $paymentDate, $paymentReference, $paymentMethod, $paymentConfirmed);
        $schedule->save();
    }

    // Eliminar programación de pago
    public function deletePaymentSchedule($id)
    {
        $schedule = PaymentSchedule::getById($id);
        if ($schedule) {
            $schedule->delete();
        }
    }

    // Obtener programación de pago por ID
    public function getPaymentScheduleById($id)
    {
        return PaymentSchedule::getById($id);
    }

    // Listar programaciones de pago de un cuchubal específico
    public function listPaymentSchedulesByCuchubal($cuchubalId)
    {
        return PaymentSchedule::getAllByCuchubalId($cuchubalId);
    }

    // Actualizar el estado de una programación
    public function updatePaymentScheduleStatus($id, $newStatus)
    {
        $schedule = PaymentSchedule::getById($id);
        if ($schedule) {
            $schedule->setStatus($newStatus);
            $schedule->save();
        }
    }

    // Métodos adicionales según la lógica de negocio
    // Listar pagos programados por estado
    public function listPaymentSchedulesByStatus($cuchubalId, $status)
    {
        $sql = "SELECT * FROM payment_schedule WHERE cuchubal_id = ? AND status = ?";
        $result = dbQueryPreparada($sql, [$cuchubalId, $status]);
        $schedules = [];
        while ($row = dbFetchAssoc($result)) {
            $schedules[] = new PaymentSchedule(
                $row['id'],
                $row['cuchubal_id'],
                $row['participant_id'],
                $row['scheduled_date'],
                $row['amount'],
                $row['status'],
                $row['notes'],
                $row['payment_date'],
                $row['payment_reference'],
                $row['payment_method'],
                $row['payment_confirmed']
            );
        }
        return $schedules;
    }

    // Resumen de pagos por cuchubal
    public function getPaymentsSummaryByCuchubal($cuchubalId)
    {
        $sql = "SELECT status, COUNT(*) as count, SUM(amount) as total FROM payment_schedule WHERE cuchubal_id = ? GROUP BY status";
        $result = dbQueryPreparada($sql, [$cuchubalId]);
        $summary = [];
        while ($row = dbFetchAssoc($result)) {
            $summary[$row['status']] = ['count' => $row['count'], 'total' => $row['total']];
        }
        return $summary;
    }

    // Historial de pagos de un participante
    public function getPaymentHistoryByParticipant($participantId)
    {
        $sql = "SELECT * FROM payment_schedule WHERE participant_id = ?";
        $result = dbQueryPreparada($sql, [$participantId]);
        $history = [];
        while ($row = dbFetchAssoc($result)) {
            $history[] = new PaymentSchedule(
                $row['id'],
                $row['cuchubal_id'],
                $row['participant_id'],
                $row['scheduled_date'],
                $row['amount'],
                $row['status'],
                $row['notes'],
                $row['payment_date'],
                $row['payment_reference'],
                $row['payment_method'],
                $row['payment_confirmed']
            );
        }
        return $history;
    }

    // Función para obtener programaciones de pago de los cuchubales de un usuario
    public function listPaymentSchedulesByUser($userId)
    {
        $sql = "SELECT ps.* FROM payment_schedule ps 
                    JOIN cuchubales c ON ps.cuchubal_id = c.id 
                    WHERE c.user_id = ? AND ps.active = 1";
        $result = dbQueryPreparada($sql, [$userId]);
        $schedules = [];
        while ($row = dbFetchAssoc($result)) {
            $schedules[] = new PaymentSchedule(
                $row['id'],
                $row['cuchubal_id'],
                $row['participant_id'],
                $row['scheduled_date'],
                $row['amount'],
                $row['status'],
                $row['notes'],
                $row['payment_date'],
                $row['payment_reference'],
                $row['payment_method'],
                $row['payment_confirmed']
            );
        }
        return $schedules;
    }
}
