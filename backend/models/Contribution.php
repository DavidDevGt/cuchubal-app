<?php
require_once('../db/database.php');

class Contribution {
    public $id;
    public $participantId;
    public $amount;
    public $date;

    // Constructor
    public function __construct($id, $participantId, $amount, $date) {
        $this->id = $id;
        $this->participantId = $participantId;
        $this->amount = $amount;
        $this->date = $date;
    }

    // Getters y setters
    public function getId() {
        return $this->id;
    }

    public function getParticipantId() {
        return $this->participantId;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getDate() {
        return $this->date;
    }
}
