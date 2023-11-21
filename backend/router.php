<?php
require 'vendor/autoload.php';

$router = new AltoRouter();
$router->map('GET', '/participants', 'participantService#listParticipants');
$router->map('POST', '/participants', 'participantService#createParticipant');
$router->map('GET', '/contributions', 'contributionService#listContributions');
$router->map('POST', '/contributions', 'contributionService#addContribution');
$router->map('GET', '/payments', 'paymentService#listPayments');
$router->map('POST', '/payments', 'paymentService#processPayment');

// Handle the request
$match = $router->match();
if ($match) {
    list($controller, $action) = explode('#', $match['target']);
    if (is_callable(array($controller, $action))) {
        call_user_func_array(array($controller, $action), array($match['params']));
    } else {
        // Not found
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    }
} else {
    // No route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
?>
