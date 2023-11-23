<?php
require 'vendor/autoload.php';

// Traer los servicios
require_once 'services/participantService.php';
require_once 'services/contributionService.php';
require_once 'services/paymentService.php';
require_once 'services/userService.php';

// Instancias de los servicios
$participantService = new ParticipantService();
$contributionService = new ContributionService();
$paymentService = new PaymentService();
$userService = new UserService();

// Crear el router
$router = new AltoRouter();

// Función para obtener los datos del request
function getRequestData() {
    return json_decode(file_get_contents('php://input'), true);
}

// Rutas para Participantes
$router->map('GET', '/participants', function() use ($participantService) {
    header('Content-Type: application/json');
    echo json_encode($participantService->listActiveParticipants());
});

$router->map('POST', '/participants', function() use ($participantService) {
    $data = getRequestData();
    // Utiliza $data para crear un participante
});

$router->map('PUT', '/participants/[i:id]', function($id) use ($participantService) {
    $data = getRequestData();
    // Utiliza $data para actualizar el participante
});

$router->map('DELETE', '/participants/[i:id]', function($id) use ($participantService) {
    $participantService->softDeleteParticipant($id);
    echo json_encode(['message' => 'Participant deleted']);
});

// Rutas para Usuarios
$router->map('GET', '/users', function() use ($userService) {
    header('Content-Type: application/json');
    echo json_encode($userService->getAllUsers());
});

$router->map('POST', '/users', function() use ($userService) {
    $data = getRequestData();
    // Utiliza $data para crear un usuario
});

$router->map('PUT', '/users/[i:id]', function($id) use ($userService) {
    $data = getRequestData();
    // Utiliza $data para actualizar el usuario
});

$router->map('DELETE', '/users/[i:id]', function($id) use ($userService) {
    $userService->softDeleteUser($id);
    echo json_encode(['message' => 'User deleted']);
});

// Rutas para Pagos
$router->map('GET', '/payments', function() use ($paymentService) {
    header('Content-Type: application/json');
    echo json_encode($paymentService->listActivePayments());
});

$router->map('POST', '/payments', function() use ($paymentService) {
    $data = getRequestData();
    // Utiliza $data para procesar un pago
});

$router->map('PUT', '/payments/[i:id]', function($id) use ($paymentService) {
    $data = getRequestData();
    // Utiliza $data para actualizar el pago
});

$router->map('DELETE', '/payments/[i:id]', function($id) use ($paymentService) {
    $paymentService->softDeletePayment($id);
    echo json_encode(['message' => 'Payment deleted']);
});

// Rutas para Contribuciones
$router->map('GET', '/contributions', function() use ($contributionService) {
    header('Content-Type: application/json');
    echo json_encode($contributionService->listActiveContributions());
});

$router->map('POST', '/contributions', function() use ($contributionService) {
    $data = getRequestData();
    // Utiliza $data para agregar una contribución
});

$router->map('PUT', '/contributions/[i:id]', function($id) use ($contributionService) {
    $data = getRequestData();
    // Utiliza $data para actualizar la contribución
});

$router->map('DELETE', '/contributions/[i:id]', function($id) use ($contributionService) {
    $contributionService->softDeleteContribution($id);
    echo json_encode(['message' => 'Contribution deleted']);
});

// Manejar la solicitud
$match = $router->match();
if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo json_encode(['error' => 'Not Found']);
}
