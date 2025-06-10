<?php
require_once __DIR__ . '/vendor/functions.php';

$pdo = getPDO();
$user_id = $_SESSION['user']['id'] ?? null;

$query = "SELECT COUNT(*) FROM book WHERE user_id = ? AND state != 'Новое'";
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

$canLeaveReview = $stmt->fetchColumn() > 0;

$query = "SELECT r.id, r.review, u.name FROM reviews r LEFT JOIN users u ON r.user_id = u.id ORDER BY r.id DESC";
$stmt = $pdo->prepare($query);
try {
    $stmt->execute();
}
catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    require('errors/500.php');
    die();
}
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>kushac - Отзывы</title>
    <link rel="icon" href="/img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <script defer src="/js/common.js"></script>
</head>
<body>
<?php include_once __DIR__ . '/components/header.php' ?>
<main class="content">
    <div class="con">
        <div class="main_dir">
            <h1 class="page_header">Отзывы</h1>
            <?php if (!empty($canLeaveReview)): ?>
                <div class="review_form">
                    <h2>Оставить отзыв</h2>
                    <form method="post" action="/vendor/make-review">
                        <div class="send_review">
                            <textarea name="review" placeholder="Ваш отзыв" ></textarea>
                            <button type="submit" class="exit_but">Отправить</button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
            <div class="review_form">
                <a>Чтобы оставить отзыв, у вас должно быть завершённое бронирование</a>
            </div>
            <?php endif; ?>
            <div class="reviews_container">
                <?php if (count($reviews) > 0): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review">
                            <h3><?php echo htmlspecialchars($review['name']); ?></h3>
                            <a><?php echo htmlspecialchars($review['review']); ?></a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <a class="alert">Отзывов пока нет</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php include_once __DIR__ . '/components/footer.php' ?>
</body>
</html>