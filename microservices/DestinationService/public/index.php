<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/DestinationService.php';

$config = require __DIR__ . '/../config/config.php';


$destinationService = new DestinationService($config['db']);

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

// Parse URL to get path and query parameters
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path'];
$queryParams = [];
if (isset($parsedUrl['query'])) {
    parse_str($parsedUrl['query'], $queryParams);
}

switch ($path) {
     case '/destinations':
        if ($requestMethod == 'GET') {
            $response = $destinationService->readAll();
            echo json_encode($response);
        } elseif ($requestMethod == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $response = $destinationService->create($data['name'], $data['description'], $data['picture']);
            echo json_encode($response);
        }
        break;

    case '/destination':
        if ($requestMethod == 'GET' && isset($queryParams['id'])) {
            $response = $destinationService->read($queryParams['id']);
            echo json_encode($response);
        } elseif ($requestMethod == 'PUT' && isset($queryParams['id'])) {
            $data = json_decode(file_get_contents('php://input'), true);
            $response = $destinationService->update($queryParams['id'], $data['name'], $data['description'], $data['picture']);
            echo json_encode($response);
        } elseif ($requestMethod == 'DELETE' && isset($queryParams['id'])) {
            $response = $destinationService->delete($queryParams['id']);
            echo json_encode($response);
        }
        break;

    case '/destinations':
        if ($requestMethod == 'GET') {
            $response = $destinationService->readAll();
            echo json_encode($response);
        } elseif ($requestMethod == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $response = $destinationService->create($data['name'], $data['description'], $data['picture']);
            echo json_encode($response);
        }
        break;

    case '/destination':
        if ($requestMethod == 'GET' && isset($queryParams['id'])) {
            $response = $destinationService->read($queryParams['id']);
            echo json_encode($response);
        } elseif ($requestMethod == 'PUT' && isset($queryParams['id'])) {
            $data = json_decode(file_get_contents('php://input'), true);
            $response = $destinationService->update($queryParams['id'], $data['name'], $data['description'], $data['picture']);
            echo json_encode($response);
        } elseif ($requestMethod == 'DELETE' && isset($queryParams['id'])) {
            $response = $destinationService->delete($queryParams['id']);
            echo json_encode($response);
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;
}
