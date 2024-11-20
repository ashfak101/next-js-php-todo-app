<?php
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$endpoint = $_GET['api'] ?? '';

echo 'Request Method: ' . $requestMethod . '<br>';
switch ($api) {
    case 'create':
        include_once 'api/create.php';
        break;
    case 'read':
        include_once 'api/read.php';
        break;
    case 'update':
        include_once 'api/update.php';
        break;
    case 'delete':
        include_once 'api/delete.php';
        break;
    default:
        echo json_encode(["message" => "Invalid endpoint."]);
        break;
}
?>
