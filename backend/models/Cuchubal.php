<?php

class Cuchubal
{
    public $id;
    public $userId;
    public $name;
    public $description;
    public $amount;       // Nuevo campo para el monto total del cuchubal
    public $startDate;    // Nuevo campo para la fecha de inicio del cuchubal

    public function __construct($id = 0, $userId = 0, $name = '', $description = '', $amount = 0.0, $startDate = '')
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->description = $description;
        $this->amount = $amount;
        $this->startDate = $startDate;
    }

    // Getters y Setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($value)
    {
        $this->userId = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    // Getters y Setters para los nuevos campos
    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($value)
    {
        $this->amount = $value;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($value)
    {
        $this->startDate = $value;
    }

    // Métodos
    public function save()
    {
        if ($this->id == 0) {
            $sql = "INSERT INTO cuchubales (user_id, name, description, amount, start_date) VALUES (?, ?, ?, ?, ?)";
            $this->id = dbQueryPreparada($sql, [$this->userId, $this->name, $this->description, $this->amount, $this->startDate]);
        } else {
            $sql = "UPDATE cuchubales SET user_id = ?, name = ?, description = ?, amount = ?, start_date = ? WHERE id = ?";
            dbQueryPreparada($sql, [$this->userId, $this->name, $this->description, $this->amount, $this->startDate, $this->id]);
        }
    }

    public static function getById($id)
    {
        $sql = "SELECT * FROM cuchubales WHERE id = ?";
        $result = dbQueryPreparada($sql, [$id]);
        if ($row = dbFetchAssoc($result)) {
            return new Cuchubal($row['id'], $row['user_id'], $row['name'], $row['description']);
        }
        return null;
    }

    public static function getAllByUserId($userId)
    {
        $sql = "SELECT * FROM cuchubales WHERE user_id = ?";
        $result = dbQueryPreparada($sql, [$userId]);
        $cuchubales = [];
        while ($row = dbFetchAssoc($result)) {
            $cuchubales[] = new Cuchubal($row['id'], $row['user_id'], $row['name'], $row['description']);
        }
        return $cuchubales;
    }

    public function delete()
    {
        $sql = "DELETE FROM cuchubales WHERE id = ?";
        dbQueryPreparada($sql, [$this->id]);
    }
}
