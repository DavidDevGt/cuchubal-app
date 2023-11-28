<?php
require_once __DIR__ . '/../db/database.php';

class Payment
{
    public $id;
    public $participantId;
    public $amount;
    public $paymentDate;
    public $status;  // Nuevo campo

    public $cuchubalId; // Nuevo campo

    public function __construct($id = 0, $participantId = 0, $amount = 0.0, $paymentDate = null, $cuchubalId = 0, $status = '')
    {
        $this->id = $id;
        $this->participantId = $participantId;
        $this->amount = $amount;
        $this->paymentDate = $paymentDate;
        $this->status = $status;
        $this->cuchubalId = $cuchubalId;
    }


    // Getters y Setters
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

    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    public function getCuchubalId()
    {
        return $this->cuchubalId;
    }

    public function setParticipantId($participantId)
    {
        $this->participantId = $participantId;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
    }

    public function setCuchubalId($cuchubalId)
    {
        $this->cuchubalId = $cuchubalId;
    }

    // Getters y Setters para status
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    // Métodos
    public function save()
    {
        if ($this->id == 0) {
            $sql = "INSERT INTO payments (participant_id, amount, date, cuchubal_id, status) VALUES (?, ?, ?, ?, ?)";
            $this->id = dbQueryPreparada($sql, [$this->participantId, $this->amount, $this->paymentDate, $this->cuchubalId, $this->status]);
        } else {
            $sql = "UPDATE payments SET participant_id = ?, amount = ?, date = ?, cuchubal_id = ?, status = ? WHERE id = ?";
            dbQueryPreparada($sql, [$this->participantId, $this->amount, $this->paymentDate, $this->cuchubalId, $this->status, $this->id]);
        }
    }

    public static function getById($id)
    {
        $sql = "SELECT * FROM payments WHERE id = ?";
        $result = dbQueryPreparada($sql, [$id]);
        if ($row = dbFetchAssoc($result)) {
            return new Payment($row['id'], $row['participant_id'], $row['amount'], $row['date'], $row['cuchubal_id']);
        }
        return null;
    }

    public static function getAllByCuchubalId($cuchubalId)
    {
        $sql = "SELECT * FROM payments WHERE cuchubal_id = ?";
        $result = dbQueryPreparada($sql, [$cuchubalId]);
        $payments = [];
        while ($row = dbFetchAssoc($result)) {
            $payments[] = new Payment($row['id'], $row['participant_id'], $row['amount'], $row['date'], $row['cuchubal_id']);
        }
        return $payments;
    }

    public function delete()
    {
        $sql = "DELETE FROM payments WHERE id = ?";
        dbQueryPreparada($sql, [$this->id]);
    }
}
