<?php
require_once __DIR__ . '/vendor/functions.php';
denyNoUser();

$user = authorizedUserData();
$user_id = $_SESSION['user']['id'];

$pdo = getPDO();

$query = "SELECT b.id, b.table_number, b.people_quantity, b.phone, b.date, b.state FROM book b LEFT JOIN users u ON b.user_id = u.id WHERE u.id = ? AND b.state = 'Новое'";
$stmt = $pdo->prepare($query);
try {
    $stmt->execute([$user_id]);
}
catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo $e->getMessage();
    die();
}

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Eat & Reserve - Профиль</title>
    <link rel="icon" href="/img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/common.css">
    <link rel="stylesheet" href="/css/profile-table.css"> <!-- Подключение нового CSS -->
    <script defer src="/js/common.js"></script>
</head>
<body>
<?php include_once __DIR__ . '/components/header.php' ?>
<main class="content">
    <div class="con">
        <div class="main_dir">
            <div class="profile_container">
                <div class="user_profile">
                    <?php if ($user['role'] === 'admin'): ?>
                        <a>Администратор</a>
                    <?php endif; ?>
                    <h2>Здравствуйте,
                        <?php
                        $firstName = explode(' ', $user['name']);
                        echo $firstName[1];
                        ?>!
                    </h2>
                    <div class="user_actions">
                        <form action="/vendor/logout" method="post">
                            <button type="submit" class="exit_but">Выйти из профиля</button>
                        </form>
                    </div>
                    <a href="/book-history?id=<?php echo $user_id ?>" class="history_but">История заказов</a>
                </div>
                <?php if (!empty($items)): ?>
                    <div class="books">
                        <h2>Текущие заявки</h2>
                        <table class="prod_table">
                            <tr class="titles">
                                <th>Номер заявки</th>
                                <th>Номер стола</th>
                                <th>Количество человек</th>
                                <th>Ваш телефон</th>
                                <th>Дата бронирования</th>
                                <th>Статус заявки</th>
                            </tr>
                            <?php foreach ($items as $data): ?>
                                <tr class="table_content">
                                    <td data-label="№ заявки"><?php echo htmlspecialchars($data['id']); ?></td>
                                    <td data-label="№ стола"><?php echo htmlspecialchars($data['table_number']); ?></td>
                                    <td data-label="Кол-во"><?php echo htmlspecialchars($data['people_quantity']); ?></td>
                                    <td class="phone-cell" data-label="Телефон"><?php echo htmlspecialchars($data['phone']); ?></td>
                                    <td class="date-cell" data-label="Дата">
                                        <div><?php echo (new DateTime($data['date']))->format('d.m.Y'); ?></div>
                                        <div><?php echo (new DateTime($data['date']))->format('H:i'); ?></div>
                                    </td>
                                    <td class="status-cell" data-label="Статус"><?php echo htmlspecialchars($data['state']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="no-items">У вас нет текущих заявок.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php include_once __DIR__ . '/components/footer.php' ?>
</body>
</html>