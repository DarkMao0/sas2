<?php
require_once __DIR__ . '/functions.php';

$pdo = getPDO();
$user_id = $_SESSION['user']['id'] ?? null;
$reviewText = trim($_POST['review'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($reviewText)) {
    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, review) VALUES (?, ?)");
    $stmt->execute([$user_id, $reviewText]);
}

redirect('/reviews');