<?php
require_once __DIR__ . '/../models/Contribution.php';

class ContributionService
{
    // Crear una nueva contribución
    public function addContribution($participantId, $amount, $date)
    {
        $sql = "INSERT INTO contributions (participant_id, amount, date) VALUES (?, ?, ?)";
        return dbQueryPreparada($sql, [$participantId, $amount, $date]);
    }

    // Leer contribuciones (activas)
    public function listActiveContributions()
    {
        $sql = "SELECT * FROM contributions WHERE active = 1";
        $result = dbQuery($sql);
        $contributions = [];
        while ($row = dbFetchAssoc($result)) {
            $contributions[] = $row;
        }
        return $contributions;
    }

    // Actualizar una contribución
    public function updateContribution($id, $participantId, $amount, $date)
    {
        $sql = "UPDATE contributions SET participant_id = ?, amount = ?, date = ? WHERE id = ?";
        return dbQueryPreparada($sql, [$participantId, $amount, $date, $id]);
    }

    // Soft delete de una contribución
    public function softDeleteContribution($id)
    {
        $sql = "UPDATE contributions SET active = 0 WHERE id = ?";
        return dbQueryPreparada($sql, [$id]);
    }

    // Total de contribuciones
    public function getTotalContributions()
    {
        $sql = "SELECT SUM(amount) AS total FROM contributions WHERE active = 1";
        $result = dbQuery($sql);
        if ($row = dbFetchAssoc($result)) {
            return $row['total'];
        }
        return 0;
    }
}
