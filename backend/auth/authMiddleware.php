<?php
function isAuthenticated()
{
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Acceso no autorizado']);
        exit;
    }
}
