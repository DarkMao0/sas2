<?php
require_once __DIR__ . '/functions.php';

$user_id = $_SESSION['user']['id'];
$table = $_POST['table'] ?? null;
$persons = $_POST['quantity'] ?? null;
$phone = $_POST['phone'] ?? null;
$date = $_POST['date'] ?? null;
$state = 'Новое';

if (empty($date)) {
    setError('date', 'Выберите дату');
}

if (empty($phone)) {
    setError('phone', 'Укажите ваш номер');
}

if (!empty($_SESSION['validation'])) {
    redirect('/book-table.php');
}

$pdo = getPDO();

$query = "INSERT INTO book (user_id, table_number, date, people_quantity, phone, state) VALUES(:user_id, :table_number, :date, :people_quantity, :phone, :state)";
$params = [
    'user_id' => $user_id,
    'table_number' => $table,
    'date' => $date,
    'people_quantity' => $persons,
    'phone' => $phone,
    'state' => $state
];

$stmt = $pdo->prepare($query);

try {
    $stmt->execute($params);
}
catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    require('../errors/500.php');
    die();
}

redirect('/book-table.php');