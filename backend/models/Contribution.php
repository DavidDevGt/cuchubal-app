<?php
require_once __DIR__ . '/../db/database.php';

class Contribution
{
    public $id;
    public $participantId;
    public $amount;
    public $date;
    public $status;
    public $cuchubalId;

    // Constructor
    public function __construct($id = 0, $participantId = 0, $amount = 0.0, $date = '', $status = 'No pagado', $cuchubalId = 0)
    {
        $this->id = $id;
        $this->participantId = $participantId;
        $this->amount = $amount;
        $this->date = $date;
        $this->status = $status;
        $this->cuchubalId = $cuchubalId;
    }

    // Getters y setters
    public function getId()
    {
        return $this->id;
    }

    public function getParticipantId()
    {
        return $this->participantId;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function setParticipantId($value)
    {
        $this->participantId = $value;
    }

    public function setAmount($value)
    {
        $this->amount = $value;
    }

    public function setDate($value)
    {
        $this->date = $value;
    }

    public function setCuchubalId($value)
    {
        $this->cuchubalId = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    // Métodos
    public function save()
    {
        if ($this->id == 0) {
            // Crear nueva contribución
            $sql = "INSERT INTO contributions (participant_id, amount, date, status, cuchubal_id) VALUES (?, ?, ?, ?, ?)";
            $this->id = dbQueryPreparada($sql, [$this->participantId, $this->amount, $this->date, $this->status, $this->cuchubalId]);
        } else {
            // Actualizar contribución existente
            $sql = "UPDATE contributions SET participant_id = ?, amount = ?, date = ?, status = ?, cuchubal_id = ? WHERE id = ?";
            dbQueryPreparada($sql, [$this->participantId, $this->amount, $this->date, $this->status, $this->cuchubalId, $this->id]);
        }
    }

    public static function getById($id)
    {
        $sql = "SELECT * FROM contributions WHERE id = ?";
        $result = dbQueryPreparada($sql, [$id]);
        if ($row = dbFetchAssoc($result)) {
            return new Contribution($row['id'], $row['participant_id'], $row['amount'], $row['date'], $row['cuchubal_id']);
        }
        return null;
    }

    public function delete()
    {
        $sql = "DELETE FROM contributions WHERE id = ?";
        dbQueryPreparada($sql, [$this->id]);
    }
}
