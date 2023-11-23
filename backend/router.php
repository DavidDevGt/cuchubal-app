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

// Configurar la URL base si el proyecto está en un subdirectorio
$router->setBasePath('/cuchubal-app/backend');

// Función para obtener los datos del request
function getRequestData()
{
    return json_decode(file_get_contents('php://input'), true);
}

// Rutas para Participantes
$router->map('GET', '/participants', function () use ($participantService) {
    header('Content-Type: application/json');
    echo json_encode($participantService->listActiveParticipants());
});

$router->map('POST', '/participants', function () use ($participantService) {
    $data = getRequestData();
    $participantId = $participantService->createParticipant($data['name'], $data['contact'], $data['address'], $data['paymentMethod']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Participante creado', 'participantId' => $participantId]);
});

$router->map('PUT', '/participants/[i:id]', function ($id) use ($participantService) {
    $data = getRequestData();
    $participantService->updateParticipant($id, $data['name'], $data['contact'], $data['address'], $data['paymentMethod']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Participante actualizado']);
});

$router->map('DELETE', '/participants/[i:id]', function ($id) use ($participantService) {
    $participantService->softDeleteParticipant($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Participante eliminado']);
});

// Rutas para Usuarios
$router->map('GET', '/users', function () use ($userService) {
    header('Content-Type: application/json');
    echo json_encode($userService->getAllUsers());
});

$router->map('POST', '/users', function () use ($userService) {
    $data = getRequestData();
    $user = $userService->createUser($data['username'], $data['password']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Usuario creado', 'userId' => $user]);
});

$router->map('PUT', '/users/[i:id]', function ($id) use ($userService) {
    $data = getRequestData();
    $userService->updateUserPassword($id, $data['password']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'User password updated']);
});

$router->map('DELETE', '/users/[i:id]', function ($id) use ($userService) {
    $userService->softDeleteUser($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'User deleted']);
});

// Rutas para Pagos
$router->map('GET', '/payments', function () use ($paymentService) {
    header('Content-Type: application/json');
    echo json_encode($paymentService->listActivePayments());
});

$router->map('POST', '/payments', function () use ($paymentService) {
    $data = getRequestData();
    $paymentId = $paymentService->processPayment($data['participantId'], $data['amount'], $data['paymentDate']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Payment processed', 'paymentId' => $paymentId]);
});

$router->map('PUT', '/payments/[i:id]', function ($id) use ($paymentService) {
    $data = getRequestData();
    $paymentService->updatePayment($id, $data['participantId'], $data['amount'], $data['paymentDate']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Payment updated']);
});

$router->map('DELETE', '/payments/[i:id]', function ($id) use ($paymentService) {
    $paymentService->softDeletePayment($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Payment deleted']);
});

// Rutas para Contribuciones
$router->map('GET', '/contributions', function () use ($contributionService) {
    header('Content-Type: application/json');
    echo json_encode($contributionService->listActiveContributions());
});

$router->map('POST', '/contributions', function () use ($contributionService) {
    $data = getRequestData();
    $contributionId = $contributionService->addContribution($data['participantId'], $data['amount'], $data['date']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Contribution added', 'contributionId' => $contributionId]);
});

$router->map('PUT', '/contributions/[i:id]', function ($id) use ($contributionService) {
    $data = getRequestData();
    $contributionService->updateContribution($id, $data['participantId'], $data['amount'], $data['date']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Contribution updated']);
});

$router->map('DELETE', '/contributions/[i:id]', function ($id) use ($contributionService) {
    $contributionService->softDeleteContribution($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Contribution deleted']);
});

// Manejar la solicitud
$match = $router->match();
if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo json_encode(['error' => 'Le preguntamos a la luna y no nos dijo nada']);
}
