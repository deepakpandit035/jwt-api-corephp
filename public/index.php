<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/Database.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/UserController.php';
require_once '../middlewares/JWTMiddleware.php';

$database = new Database();
$db = $database->connect();

$auth = new AuthController($db);
$userController = new UserController();

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove '/index.php' from the request URI if it exists
if (strpos($requestUri, '/index.php') === 0) {
    $requestUri = substr($requestUri, strlen('/index.php'));
}

// Routing logic
if ($requestUri === '/login' && $requestMethod === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    echo $auth->login($data);
} elseif ($requestUri === '/register' && $requestMethod === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    echo $auth->register($data);
} elseif ($requestUri === '/profile' && $requestMethod === 'GET') {
    $user = JWTMiddleware::authenticate();
    $userController->getProfile($user);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Not Found']);
}
?>
