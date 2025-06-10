<?php
require_once __DIR__ . '/vendor/functions.php';
denyNoUser();

$pdo = getPDO();
$user_id = $_SESSION['user']['id'] ?? null;

$query = "SELECT phone FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
try {
    $stmt->execute([$user_id]);
}
catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    require('errors/500.php');
    die();
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html  lang="ru" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Eat & Reserve - Отзывы</title>
    <link rel="icon" href="/img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/common.css">
    <script defer src="/js/common.js"></script>
    <script defer src="/js/book.js"></script>
</head>
<body>
<?php include_once __DIR__ . '/components/header.php' ?>
<main class="content">
    <div class="con">
        <div class="main_dir">
            <h1 class="page_header">Отзывы</h1>

        </div>
    </div>
</main>
<?php include_once __DIR__ . '/components/footer.php' ?>
</body>
</html>