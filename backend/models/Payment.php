<?php
require_once __DIR__ . '/../db/database.php';

class Payment
{
    public $id;
    public $participantId;
    public $amount;
    public $paymentDate;

    // Constructor
    public function __construct($id, $participantId, $amount, $paymentDate)
    {
        $this->id = $id;
        $this->participantId = $participantId;
        $this->amount = $amount;
        $this->paymentDate = $paymentDate;
    }

    // Getters y Setters
    public function getId() {
        return $this->id;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getPaymentDate() {
        return $this->paymentDate;
    }
}
