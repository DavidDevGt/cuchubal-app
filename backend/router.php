<?php
require 'vendor/autoload.php';

// Traer los servicios
require_once 'services/participantService.php';
require_once 'services/contributionService.php';
require_once 'services/paymentService.php';
require_once 'services/userService.php';
require_once 'services/cuchubalService.php';
require_once 'services/paymentScheduleService.php';

// Instancias de los servicios
$participantService = new ParticipantService();
$contributionService = new ContributionService();
$paymentService = new PaymentService();
$userService = new UserService();
$cuchubalService = new CuchubalService();
$paymentScheduleService = new PaymentScheduleService();

// Crear el router
$router = new AltoRouter();

// Configurar la URL base si el proyecto está en un subdirectorio
$router->setBasePath('/cuchubal-app/backend');

// Función para obtener los datos del request
function getRequestData()
{
    return json_decode(file_get_contents('php://input'), true);
}

// *Rutas para Participantes* //
$router->map('GET', '/participants/cuchubal/[i:cuchubalId]', function ($cuchubalId) use ($participantService) {
    header('Content-Type: application/json');
    echo json_encode($participantService->listActiveParticipantsByCuchubal($cuchubalId));
});

$router->map('POST', '/participants', function () use ($participantService) {
    $data = getRequestData();
    $participantId = $participantService->createParticipant($data['name'], $data['contact'], $data['address'], $data['paymentMethod'], $data['cuchubalId']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Participante creado', 'participantId' => $participantId]);
});

$router->map('PUT', '/participants/[i:id]', function ($id) use ($participantService) {
    $data = getRequestData();
    $participantService->updateParticipant($id, $data['name'], $data['contact'], $data['address'], $data['paymentMethod'], $data['cuchubalId']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Participante actualizado']);
});

$router->map('DELETE', '/participants/[i:id]', function ($id) use ($participantService) {
    $participantService->softDeleteParticipant($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Participante eliminado']);
});

$router->map('PUT', '/participants/[i:id]/activate', function ($id) use ($participantService) {
    $participantService->activateParticipant($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Participante activado']);
});

$router->map('PUT', '/participants/[i:id]/deactivate', function ($id) use ($participantService) {
    $participantService->deactivateParticipant($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Participante desactivado']);
});

$router->map('GET', '/participants/[i:id]', function ($id) use ($participantService) {
    header('Content-Type: application/json');
    echo json_encode($participantService->getParticipantDetails($id));
});

$router->map('GET', '/participants/search', function () use ($participantService) {
    $data = getRequestData();
    header('Content-Type: application/json');
    echo json_encode($participantService->getParticipantByNameOrContactInCuchubal($data['searchTerm'], $data['cuchubalId']));
});

// *Rutas para Usuarios* //
$router->map('GET', '/users', function () use ($userService) {
    header('Content-Type: application/json');
    echo json_encode($userService->getAllUsers());
});

$router->map('GET', '/users/[i:id]', function ($id) use ($userService) {
    header('Content-Type: application/json');
    echo json_encode($userService->getUserById($id));
});

$router->map('POST', '/users', function () use ($userService) {
    $data = getRequestData();
    $userId = $userService->createUser($data['username'], $data['password']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Usuario creado', 'userId' => $userId]);
});

$router->map('PUT', '/users/[i:id]', function ($id) use ($userService) {
    $data = getRequestData();
    $userService->updateUser($id, $data['username'], $data['password']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Información de usuario actualizada']);
});

$router->map('DELETE', '/users/[i:id]', function ($id) use ($userService) {
    $userService->deleteUser($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Usuario eliminado']);
});

$router->map('POST', '/login', function () use ($userService) {
    $data = getRequestData();
    if ($userService->login($data['username'], $data['password'])) {
        echo json_encode(['message' => 'Login exitoso']);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Usuario o contraseña incorrectos']);
    }
});

// Ejemplo

// $router->map('GET', '/ruta-protegida', function () {
//     isAuthenticated();
//     // Resto del código...
// });

// *Rutas para Pagos por Cuchubal* //
$router->map('GET', '/payments/cuchubal/[i:cuchubalId]', function ($cuchubalId) use ($paymentService) {
    header('Content-Type: application/json');
    echo json_encode($paymentService->listPaymentsByCuchubal($cuchubalId));
});

$router->map('GET', '/payments/[i:id]', function ($id) use ($paymentService) {
    header('Content-Type: application/json');
    echo json_encode($paymentService->getPaymentById($id));
});

$router->map('GET', '/payments/cuchubal/[i:cuchubalId]', function ($cuchubalId) use ($paymentService) {
    header('Content-Type: application/json');
    echo json_encode($paymentService->listPaymentsByCuchubal($cuchubalId));
});

$router->map('GET', '/payments/participant/[i:participantId]', function ($participantId) use ($paymentService) {
    header('Content-Type: application/json');
    echo json_encode($paymentService->getPaymentsByParticipant($participantId));
});

$router->map('POST', '/payments', function () use ($paymentService) {
    $data = getRequestData();
    $paymentId = $paymentService->createPayment($data['participantId'], $data['amount'], $data['paymentDate'], $data['cuchubalId']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Pago procesado', 'paymentId' => $paymentId]);
});

$router->map('PUT', '/payments/[i:id]', function ($id) use ($paymentService) {
    $data = getRequestData();
    $paymentService->updatePayment($id, $data['participantId'], $data['amount'], $data['paymentDate'], $data['cuchubalId']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Pago actualizado']);
});

$router->map('DELETE', '/payments/[i:id]', function ($id) use ($paymentService) {
    $paymentService->deletePayment($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Pago eliminado']);
});

// *Rutas para Contribuciones* //
$router->map('GET', '/contributions', function () use ($contributionService) {
    header('Content-Type: application/json');
    echo json_encode($contributionService->listActiveContributions());
});

$router->map('GET', '/contributions/cuchubal/[i:cuchubalId]', function ($cuchubalId) use ($contributionService) {
    header('Content-Type: application/json');
    echo json_encode($contributionService->listContributionsByCuchubal($cuchubalId));
});

$router->map('GET', '/contributions/cuchubal/[i:cuchubalId]/pending', function ($cuchubalId) use ($contributionService) {
    header('Content-Type: application/json');
    echo json_encode($contributionService->listPendingContributions($cuchubalId));
});

$router->map('GET', '/contributions/cuchubal/[i:cuchubalId]/total', function ($cuchubalId) use ($contributionService) {
    header('Content-Type: application/json');
    echo json_encode(['total' => $contributionService->calculateTotalContributions($cuchubalId)]);
});

$router->map('POST', '/contributions', function () use ($contributionService) {
    $data = getRequestData();
    $contributionId = $contributionService->createContribution($data['participantId'], $data['amount'], $data['date'], $data['cuchubalId']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Contribution added', 'contributionId' => $contributionId]);
});

$router->map('PUT', '/contributions/[i:id]', function ($id) use ($contributionService) {
    $data = getRequestData();
    $contributionService->updateContribution($id, $data['participantId'], $data['amount'], $data['date'], $data['cuchubalId']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Contribution updated']);
});

$router->map('DELETE', '/contributions/[i:id]', function ($id) use ($contributionService) {
    $contributionService->deleteContribution($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Contribution deleted']);
});

$router->map('PUT', '/contributions/[i:id]/status', function ($id) use ($contributionService) {
    $data = getRequestData();
    $contributionService->updateContributionStatus($id, $data['status']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Contribution status updated']);
});

// *Rutas para Cuchubales* //
$router->map('GET', '/cuchubales', function () use ($cuchubalService) {
    header('Content-Type: application/json');
    echo json_encode($cuchubalService->listCuchubalesByUser($_GET['userId']));
});

$router->map('GET', '/cuchubales/[i:id]', function ($id) use ($cuchubalService) {
    header('Content-Type: application/json');
    echo json_encode($cuchubalService->getCuchubalById($id));
});

$router->map('POST', '/cuchubales', function () use ($cuchubalService) {
    $data = getRequestData();
    $cuchubalId = $cuchubalService->createCuchubal($data['userId'], $data['name'], $data['description'], $data['amount'], $data['startDate']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Cuchubal creado', 'cuchubalId' => $cuchubalId]);
});

$router->map('PUT', '/cuchubales/[i:id]', function ($id) use ($cuchubalService) {
    $data = getRequestData();
    $cuchubalService->updateCuchubal($id, $data['userId'], $data['name'], $data['description'], $data['amount'], $data['startDate']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Cuchubal actualizado']);
});

$router->map('DELETE', '/cuchubales/[i:id]', function ($id) use ($cuchubalService) {
    $cuchubalService->deleteCuchubal($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Cuchubal eliminado']);
});

// *Rutas para Programación de Pagos* //
$router->map('GET', '/payment-schedule/cuchubal/[i:cuchubalId]', function ($cuchubalId) use ($paymentScheduleService) {
    header('Content-Type: application/json');
    echo json_encode($paymentScheduleService->listPaymentSchedulesByCuchubal($cuchubalId));
});

$router->map('GET', '/payment-schedule/[i:id]', function ($id) use ($paymentScheduleService) {
    header('Content-Type: application/json');
    echo json_encode($paymentScheduleService->getPaymentScheduleById($id));
});

$router->map('POST', '/payment-schedule', function () use ($paymentScheduleService) {
    $data = getRequestData();
    $scheduleId = $paymentScheduleService->createPaymentSchedule(
        $data['cuchubalId'],
        $data['participantId'],
        $data['scheduledDate'],
        $data['amount'],
        $data['status']
    );
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Programación de pago creada', 'scheduleId' => $scheduleId]);
});

$router->map('PUT', '/payment-schedule/[i:id]', function ($id) use ($paymentScheduleService) {
    $data = getRequestData();
    $paymentScheduleService->updatePaymentSchedule(
        $id,
        $data['cuchubalId'],
        $data['participantId'],
        $data['scheduledDate'],
        $data['amount'],
        $data['status']
    );
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Programación de pago actualizada']);
});

$router->map('DELETE', '/payment-schedule/[i:id]', function ($id) use ($paymentScheduleService) {
    $paymentScheduleService->deletePaymentSchedule($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Programación de pago eliminada']);
});

$router->map('PUT', '/payment-schedule/[i:id]/status', function ($id) use ($paymentScheduleService) {
    $data = getRequestData();
    $paymentScheduleService->updatePaymentScheduleStatus($id, $data['newStatus']);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Estado de programación de pago actualizado']);
});

$router->map('GET', '/payment-schedule/cuchubal/[i:cuchubalId]/summary', function ($cuchubalId) use ($paymentScheduleService) {
    header('Content-Type: application/json');
    echo json_encode($paymentScheduleService->getPaymentsSummaryByCuchubal($cuchubalId));
});

$router->map('GET', '/payment-schedule/participant/[i:participantId]/history', function ($participantId) use ($paymentScheduleService) {
    header('Content-Type: application/json');
    echo json_encode($paymentScheduleService->getPaymentHistoryByParticipant($participantId));
});


// Manejar la solicitud
$match = $router->match();
if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo json_encode(['error' => 'Le preguntamos a la luna y no nos dijo nada']);
}
