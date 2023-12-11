<?php
require_once '../backend/vendor/autoload.php';

$router = new AltoRouter();

// Configurar la base del path si es necesario
$router->setBasePath('/cuchubal-app/frontend');

// Definir rutas
$router->map('GET', '/', function() {
    require __DIR__ . '/pages/dashboard.php';
});

$router->map('GET', '/login', function() {
    require __DIR__ . '/pages/login.php';
});

$router->map('GET', '/registro', function() {
    require __DIR__ . '/pages/register.php';
});

$router->map('GET', '/cuchubales', function() {
    require __DIR__ . '/pages/cuchubales.php';
});

$router->map('GET', '/usuarios', function() {
    require __DIR__ . '/pages/users.php';
});

$router->map('GET', '/participantes', function() {
    require __DIR__ . '/pages/participants.php';
});

$router->map('GET', '/calendario', function() {
    require __DIR__ . '/pages/calendar.php';
});

// ... más rutas ...

$match = $router->match();

// Llamar a la función de la ruta correspondiente
if($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']); 
} else {
    // No se encontró la ruta
    http_response_code(404);
    require __DIR__ . '/pages/error.php';
}