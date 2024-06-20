<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/businesspartnerService.php';

$config = require __DIR__ . '/../config/config.php';
$userService = new BusinessPartnerService($config['db']);

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Parse URL to get path and query parameters
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path'];
$queryParams = [];
if (isset($parsedUrl['query'])) {
    parse_str($parsedUrl['query'], $queryParams);
}

switch ($path) {
    case '/register':
        if ($requestMethod == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $response = $userService->register($data['name'], $data['email'], $data['password']);
            echo json_encode($response);
        }
        break;
    case '/login':
        if ($requestMethod == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $response = $userService->login($data['email'], $data['password']);
            echo json_encode($response);
        }
        break;
    case '/profile':
        if ($requestMethod == 'GET') {
            if (isset($queryParams['id'])) {
                $userId = $queryParams['id'];
                $response = $userService->profile($userId);
                if ($response) {
                    echo json_encode($response);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'User not found']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'User ID is required']);
            }
        }
        break;

    case '/create-destinations':
        if  ($requestMethod == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $response = $userService->createDestination($data['ownerId'], $data['name'], $data['description'], $data['picture']);
            echo $response;
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;
}