<?php
require_once __DIR__ . '/vendor/functions.php';
denyNoUser();

$user_id = $_SESSION['user']['id'];

$pdo = getPDO();

$query = "SELECT b.id, b.table_number, b.people_quantity, b.phone, b.date, b.state FROM book b LEFT JOIN users u ON b.user_id = u.id WHERE u.id = ? AND b.state != 'Новое'";
$stmt = $pdo->prepare($query);
try {
    $stmt->execute([$user_id]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo "<div style='text-align: center; color: red; padding: 20px;'>Ошибка сервера. Пожалуйста, попробуйте позже.</div>";
    die();
}

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Computer Galaxy - Профиль</title>
    <link rel="icon" href="/img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/common.css">
    <link rel="stylesheet" href="/css/profile-table.css">
    <script defer src="/js/common.js"></script>
</head>
<body>
<?php include_once __DIR__ . '/components/header.php' ?>
<main class="content">
    <div class="con">
        <div class="main_dir">
            <h2>История заявок</h2>
            <?php if (!empty($items)): ?>
                <table class="prod_table">
                    <tr class="titles">
                        <th>Номер заявки</th>
                        <th>Номер</th>
                        <th>Количество</th>
                        <th>Телефон</th>
                        <th>Дата и время</th>
                        <th>Статус</th>
                    </tr>
                    <?php foreach ($items as $item): ?>
                        <tr class="table_content">
                            <td data-label="№ заявки"><?php echo htmlspecialchars($item['id']); ?></td>
                            <td data-label="№ стола"><?php echo htmlspecialchars($item['table_number']); ?></td>
                            <td data-label="Кол-во"><?php echo htmlspecialchars($item['people_quantity']); ?></td>
                            <td class="phone-cell" data-label="Телефон"><?php echo htmlspecialchars(str_replace([' ', '(', ')', '-'], '', $item['phone'])); ?></td>
                            <td class="date-cell" data-label="Дата"><?php echo (new DateTime($item['date']))->format('d.m.Y H:i'); ?></td>
                            <td class="status-cell" data-label="Статус"><?php echo htmlspecialchars($item['state']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p class="no-items">У вас нет активных заявок.</p>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php include_once __DIR__ . '/components/footer.php' ?>
</body>
</html>