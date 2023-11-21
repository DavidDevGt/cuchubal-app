<?php
require_once('../db/database.php');

class Participant
{
    public $id;
    public $name;
    public $contact;
    public $address;
    public $paymentMethod;

    // Constructor
    public function __construct($id, $name, $contact, $address, $paymentMethod)
    {
        $this->id = $id;
        $this->name = $name;
        $this->contact = $contact;
        $this->address = $address;
        $this->paymentMethod = $paymentMethod;
    }

    // Getters y setters
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getContact()
    {
        return $this->contact;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    // Método para verificar si el participante está activo
    public function isActive()
    {
        // Lógica para verificar si el participante está activo
    }
}
