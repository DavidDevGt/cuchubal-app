<?php
// Conexión a la base de datos
function dbConnect()
{
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'cuchubal_app';

    $mysqli = new mysqli($host, $user, $password, $database);

    if ($mysqli->connect_error) {
        die('Error en la conexión : ' . $mysqli->connect_errno . ' - ' . $mysqli->connect_error);
    }

    return $mysqli;
}

// Ejecutar una consulta SQL
function dbQuery($sql)
{
    $mysqli = dbConnect();
    $result = $mysqli->query($sql);

    if (!$result) {
        die('Error en la consulta SQL: ' . $mysqli->error);
    }

    $mysqli->close();
    return $result;
}

// Obtener una fila como array asociativo
function dbFetchAssoc($result)
{
    return $result->fetch_assoc();
}

// Insertar y obtener el ID del último registro insertado
function dbQueryInsert($sql)
{
    $mysqli = dbConnect();
    if ($mysqli->query($sql)) {
        $lastId = $mysqli->insert_id;
        $mysqli->close();
        return $lastId;
    } else {
        die('Error en la consulta SQL: ' . $mysqli->error);
    }
}

// Función para determinar los tipos de los parámetros de una consulta preparada
function detectParamTypes($params)
{
    $types = '';
    foreach ($params as $param) {
        if (is_int($param)) {
            $types .= 'i'; // Tipo entero
        } elseif (is_double($param)) {
            $types .= 'd'; // Tipo double
        } elseif (is_string($param)) {
            $types .= 's'; // Tipo string
        } else {
            $types .= 'b'; // Tipo blob y otros
        }
    }
    return $types;
}

// Consulta preparada con detección automática de tipos
function dbQueryPreparada($sql, $params)
{
    $mysqli = dbConnect();
    $types = detectParamTypes($params);
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        die('Error en la preparación de la consulta: ' . $mysqli->error);
    }

    $stmt->bind_param($types, ...$params);

    if (!$stmt->execute()) {
        die('Error en la ejecución de la consulta preparada: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    $stmt->close();
    $mysqli->close();

    return $result;
}
