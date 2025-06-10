<?php
require_once __DIR__ . '/vendor/functions.php';
denyNoAdmin();

$user_id = $_SESSION['user']['id'];

$pdo = getPDO();

$query = "SELECT id, table_number, people_quantity, phone, state, date FROM book ORDER BY state = 'Новое' AND date DESC";
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

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html  lang="ru" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Eat & Reserve - Управление заявками</title>
    <link rel="icon" href="/img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/common.css">
    <script defer src="/js/common.js"></script>
    <script defer src="/js/state.js"></script>
</head>
<body>
<?php include_once __DIR__ . '/components/header.php' ?>
<main class="content">
    <div class="con">
        <div class="main_dir">
            <?php if (!empty($items)): ?>
                <h2>Управление заявками</h2>
                <a id="error-container" class="error_container"></a>
                <table class="prod_table">
                    <tr class="titles">
                        <td>Номер заявки</td>
                        <td>Номер стола</td>
                        <td>Количество человек</td>
                        <td>Ваш телефон</td>
                        <td>Дата бронирования</td>
                        <td>Статус заявки</td>
                    </tr>
                    <?php foreach ($items as $data): ?>
                        <tr class="table_content">
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['table_number']; ?></td>
                            <td><?php echo $data['people_quantity']; ?></td>
                            <td><?php echo $data['phone']; ?></td>
                            <td>
                                <div>
                                    <?php
                                    $datetime = new DateTime($data['date']);
                                    echo $datetime->format('d.m.Y');
                                    ?>
                                </div>
                                <div>
                                    <?php
                                    $datetime = new DateTime($data['date']);
                                    echo $datetime->format('H:i');
                                    ?>
                                </div>
                            </td>
                            <td>
                                <select class="book_input" id="select" data-book-id="<?php echo $data['id']; ?>" data-original-state="<?php echo $data['state']; ?>">
                                    <option value="Новое" <?php echo $data['state'] === 'Новое' ? 'selected' : ''; ?>>Новое</option>
                                    <option value="Отменено" <?php echo $data['state'] === 'Отменено' ? 'selected' : ''; ?>>Отменено</option>
                                    <option value="Состоялось" <?php echo $data['state'] === 'Состоялось' ? 'selected' : ''; ?>>Состоялось</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php include_once __DIR__ . '/components/footer.php' ?>
</body>
</html>