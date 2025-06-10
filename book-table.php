<?php
require_once __DIR__ . '/vendor/functions.php';
denyNoUser();

$pdo = getPDO();
$user_id = $_SESSION['user']['id'] ?? null;

$query = "SELECT phone FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
try {
    $stmt->execute([$user_id]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    require('errors/500.php');
    die();
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Eat & Reserve - Профиль</title>
    <link rel="icon" href="/img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/common.css">
    <link rel="stylesheet" href="/css/cart.css">
    <link rel="stylesheet" href="/css/book-table.css"> <!-- Подключение нового CSS -->
    <script defer src="/js/common.js"></script>
    <script defer src="/js/book.js"></script>
</head>
<body>
<?php include_once __DIR__ . '/components/header.php' ?>
<main class="content">
    <div class="con">
        <div class="main_dir">
            <h1 class="page_header">Забронировать столик</h1>
            <div class="cart_items">
                <img class="scheme" src="/img/scheme.png">
                <form action="/vendor/make-order" method="post">
                    <table class="prod_table">
                        <tr class="titles">
                            <th>Номер стола</th>
                            <th>Количество человек</th>
                            <th>Контактный телефон</th>
                            <th>Дата и время</th>
                        </tr>
                        <tr class="table_content">
                            <td data-label="№ стола">
                                <select class="select_field" name="table">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                            <td data-label="Кол-во">
                                <div class="refresh">
                                    <div class="quantity_changer">
                                        <button type="button">-</button>
                                        <input
                                                type="number"
                                                class="quantity_input"
                                                name="quantity"
                                                value="1"
                                                readonly
                                        >
                                        <button type="button">+</button>
                                    </div>
                                </div>
                            </td>
                            <td class="phone-cell" data-label="Телефон">
                                <div class="book_field">
                                    <input
                                            type="text"
                                            class="sup_field"
                                            id="phone"
                                            name="phone"
                                            value="<?php echo htmlspecialchars($row['phone'] ?? ''); ?>"
                                        <?php echo errorFrame('phone'); ?>
                                    >
                                    <?php if (checkError('phone')): ?>
                                        <a class="reg_alert"><?php echo errorMessage('phone'); ?></a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="date-cell" data-label="Дата">
                                <div class="book_field">
                                    <input
                                            type="datetime-local"
                                            class="sup_field"
                                            name="date"
                                        <?php echo errorFrame('date'); ?>
                                    >
                                    <?php if (checkError('date')): ?>
                                        <a class="reg_alert"><?php echo errorMessage('date'); ?></a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <button type="submit" class="cart_del">Отправить заявку</button>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include_once __DIR__ . '/components/footer.php' ?>
</body>
</html>