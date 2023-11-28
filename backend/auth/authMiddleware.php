<?php
function isAuthenticated()
{
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Acceso no autorizado']);
        exit;
    }

    $tiempoMaximoInactividad = 15 * 60; // 15 minutos
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $tiempoMaximoInactividad)) {
        // Si la sesión ha expirado, limpiar y destruir la sesión
        session_unset();
        session_destroy();

        http_response_code(401); // No autorizado
        echo json_encode(['error' => 'Sesión expirada']);
        exit;
    }

    // Actualizar el tiempo de actividad
    $_SESSION['last_activity'] = time();
}
