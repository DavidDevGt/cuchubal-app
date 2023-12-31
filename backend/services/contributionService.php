<?php
require_once __DIR__ . '/../models/Contribution.php';
require_once __DIR__ . '/../models/PaymentSchedule.php';

class ContributionService
{

    // Crear una nueva contribución
    public function createContribution($participantId, $amount, $date, $cuchubalId)
    {
        $contribution = new Contribution(0, $participantId, $amount, $date, $cuchubalId);
        $contribution->save();
        return $contribution->getId();
    }

    // Obtener una contribución por ID
    public function getContributionById($id)
    {
        return Contribution::getById($id);
    }

    // Actualizar una contribución existente
    public function updateContribution($id, $participantId, $amount, $date, $cuchubalId)
    {
        $contribution = new Contribution($id, $participantId, $amount, $date, $cuchubalId);
        $contribution->save();
    }

    // Eliminar una contribución
    public function deleteContribution($id)
    {
        $contribution = Contribution::getById($id);
        if ($contribution) {
            $contribution->delete();
        }
    }

    // Listar todas las contribuciones de un cuchubal específico
    public function listContributionsByCuchubal($cuchubalId)
    {
        $sql = "SELECT * FROM contributions WHERE cuchubal_id = ?";
        $result = dbQueryPreparada($sql, [$cuchubalId]);
        $contributions = [];
        while ($row = dbFetchAssoc($result)) {
            $contributions[] = new Contribution($row['id'], $row['participant_id'], $row['amount'], $row['date'], $row['cuchubal_id']);
        }
        return $contributions;
    }

    // Listar todas las contribuciones activas
    public function listActiveContributions()
    {
        $sql = "SELECT * FROM contributions WHERE active = 1";
        $result = dbQuery($sql);
        $contributions = [];
        while ($row = dbFetchAssoc($result)) {
            $contributions[] = new Contribution(
                $row['id'],
                $row['participant_id'],
                $row['amount'],
                $row['date'],
                $row['status'],
                $row['cuchubal_id']
            );
        }
        return $contributions;
    }


    // Métodos adicionales según la lógica de negocio

    // Validar contribuciones según el cronograma de pagos
    public function validateContributionsBySchedule($cuchubalId)
    {
        $contributions = $this->listContributionsByCuchubal($cuchubalId);
        $paymentSchedule = PaymentSchedule::getAllByCuchubalId($cuchubalId);

        foreach ($contributions as $contribution) {
            foreach ($paymentSchedule as $schedule) {
                if (
                    $contribution->getParticipantId() == $schedule->getParticipantId() &&
                    $contribution->getDate() <= $schedule->getScheduledDate() &&
                    $contribution->getAmount() >= $schedule->getAmount()
                ) {
                    $contribution->setStatus('Completado');
                    $contribution->save();
                }
            }
        }
    }

    // Actualizar el estado de las contribuciones
    public function updateContributionStatus($id, $newStatus)
    {
        $contribution = Contribution::getById($id);
        if ($contribution) {
            $contribution->setStatus($newStatus);
            $contribution->save();
        }
    }

    // Listar contribuciones pendientes por cuchubal
    public function listPendingContributions($cuchubalId)
    {
        $sql = "SELECT * FROM contributions WHERE cuchubal_id = ? AND status = 'No pagado'";
        $result = dbQueryPreparada($sql, [$cuchubalId]);
        $pendingContributions = [];
        while ($row = dbFetchAssoc($result)) {
            $pendingContributions[] = new Contribution($row['id'], $row['participant_id'], $row['amount'], $row['date'], $row['cuchubal_id']);
        }
        return $pendingContributions;
    }

    // Método para calcular el total de contribuciones por cuchubal
    public function calculateTotalContributions($cuchubalId)
    {
        $sql = "SELECT SUM(amount) as total FROM contributions WHERE cuchubal_id = ?";
        $result = dbQueryPreparada($sql, [$cuchubalId]);
        if ($row = dbFetchAssoc($result)) {
            return $row['total'];
        }
        return 0;
    }
}
