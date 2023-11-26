<?php
require_once __DIR__ . '/../db/database.php';

class Participant
{
    public $id;
    public $name;
    public $contact;
    public $address;
    public $paymentMethod;
    public $cuchubalId; // Nuevo campo para asociar el participante a un cuchubal


    // Constructor
    public function __construct($id = 0, $name = '', $contact = '', $address = '', $paymentMethod = '', $cuchubalId = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->contact = $contact;
        $this->address = $address;
        $this->paymentMethod = $paymentMethod;
        $this->cuchubalId = $cuchubalId;
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

    // Setters

    public function setName($value)
    {
        $this->name = $value;
    }

    public function setContact($value)
    {
        $this->contact = $value;
    }

    public function setAddress($value)
    {
        $this->address = $value;
    }

    public function setPaymentMethod($value)
    {
        $this->paymentMethod = $value;
    }

    public function setCuchubalId($value)
    {
        $this->cuchubalId = $value;
    }

    // Métodos
    public function save()
    {
        if ($this->id == 0) {
            // Crear nuevo participante
            $sql = "INSERT INTO participants (name, contact, address, payment_method, cuchubal_id) VALUES (?, ?, ?, ?, ?)";
            $this->id = dbQueryPreparada($sql, [$this->name, $this->contact, $this->address, $this->paymentMethod, $this->cuchubalId]);
        } else {
            // Actualizar participante existente
            $sql = "UPDATE participants SET name = ?, contact = ?, address = ?, payment_method = ?, cuchubal_id = ? WHERE id = ?";
            dbQueryPreparada($sql, [$this->name, $this->contact, $this->address, $this->paymentMethod, $this->cuchubalId, $this->id]);
        }
    }

    public static function getById($id)
    {
        $sql = "SELECT * FROM participants WHERE id = ?";
        $result = dbQueryPreparada($sql, [$id]);
        if ($row = dbFetchAssoc($result)) {
            return new Participant($row['id'], $row['name'], $row['contact'], $row['address'], $row['payment_method'], $row['cuchubal_id']);
        }
        return null;
    }

    public function delete()
    {
        $sql = "DELETE FROM participants WHERE id = ?";
        dbQueryPreparada($sql, [$this->id]);
    }
}
