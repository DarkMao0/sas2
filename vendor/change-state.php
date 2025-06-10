<?php
require_once __DIR__ . '/../vendor/functions.php';
header('Content-Type: application/json');

$pdo = getPDO();

$input = json_decode(file_get_contents('php://input'), true);
$book_id = $input['id'] ?? null;
$state = $input['state'] ?? null;

$query = "UPDATE book SET state = ? WHERE id = ?";
$stmt = $pdo->prepare($query);

try {
    $stmt->execute([$state, $book_id]);
}
catch (\PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Ошибка подключения к базе данных']);
    die();
}

echo json_encode(['success' => true]);