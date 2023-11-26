<?php
require_once __DIR__ . '/../db/database.php';

class PaymentSchedule
{
    public $id;
    public $cuchubalId;
    public $participantId;
    public $scheduledDate;
    public $amount;
    public $status;

    // Constructor
    public function __construct($id = 0, $cuchubalId = 0, $participantId = 0, $scheduledDate = '', $amount = 0.0, $status = '')
    {
        $this->id = $id;
        $this->cuchubalId = $cuchubalId;
        $this->participantId = $participantId;
        $this->scheduledDate = $scheduledDate;
        $this->amount = $amount;
        $this->status = $status;
    }

    // Getters y setters

    public function getId()
    {
        return $this->id;
    }

    public function getCuchubalId()
    {
        return $this->cuchubalId;
    }

    public function getParticipantId()
    {
        return $this->participantId;
    }

    public function getScheduledDate()
    {
        return $this->scheduledDate;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function setCuchubalId($value)
    {
        $this->cuchubalId = $value;
    }

    public function setParticipantId($value)
    {
        $this->participantId = $value;
    }

    public function setScheduledDate($value)
    {
        $this->scheduledDate = $value;
    }

    public function setAmount($value)
    {
        $this->amount = $value;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    // Métodos
    public function save()
    {
        if ($this->id == 0) {
            // Crear nueva programación de pago
            $sql = "INSERT INTO payment_schedule (cuchubal_id, participant_id, scheduled_date, amount, status) VALUES (?, ?, ?, ?, ?)";
            $this->id = dbQueryPreparada($sql, [$this->cuchubalId, $this->participantId, $this->scheduledDate, $this->amount, $this->status]);
        } else {
            // Actualizar programación de pago existente
            $sql = "UPDATE payment_schedule SET cuchubal_id = ?, participant_id = ?, scheduled_date = ?, amount = ?, status = ? WHERE id = ?";
            dbQueryPreparada($sql, [$this->cuchubalId, $this->participantId, $this->scheduledDate, $this->amount, $this->status, $this->id]);
        }
    }

    public static function getById($id)
    {
        $sql = "SELECT * FROM payment_schedule WHERE id = ?";
        $result = dbQueryPreparada($sql, [$id]);
        if ($row = dbFetchAssoc($result)) {
            return new PaymentSchedule($row['id'], $row['cuchubal_id'], $row['participant_id'], $row['scheduled_date'], $row['amount'], $row['status']);
        }
        return null;
    }

    public function delete()
    {
        $sql = "DELETE FROM payment_schedule WHERE id = ?";
        dbQueryPreparada($sql, [$this->id]);
    }
}
