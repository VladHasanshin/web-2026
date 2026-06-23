<?php
$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Разрешен только POST.']);
    exit;
}

$inputJSON = file_get_contents('php://input');
$inputData = json_decode($inputJSON, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Ошибка JSON: ' . json_last_error_msg()]);
    exit;
}

if (!isset($inputData['image']) || !isset($inputData['filename'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Ожидались поля image или filename']);
    exit;
}

$imageData = $inputData['image'];
$filename = $inputData['filename'];

if (strpos($imageData, 'base64,') !== false) {
    $imageData = explode('base64,', $imageData)[1];
}

$decodedImage = base64_decode($imageData);

$directory =  __DIR__ . '/static/';
if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
}

$path = $directory . $filename;

if (file_put_contents($path, $decodedImage)) {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'path' => './static/' . $filename
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Не удалось сохранить файл на сервер']);
}
?>