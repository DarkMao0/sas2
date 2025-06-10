<?php
require_once __DIR__ . '/vendor/functions.php';
denyUser();
?>

<!DOCTYPE html>
<html  lang="ru" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Computer Galaxy - Вход</title>
    <link rel="icon" href="/img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/common.css">
    <script defer src="js/common.js"></script>
    <script defer src="js/reg.js"></script>
</head>
<body>
<?php include_once __DIR__ . '/components/header.php' ?>
<main class="content">
    <div class="con">
        <div class="main_dir">
            <div class="form_con">
                <form class="sign_up" action="/vendor/signin" method="post" novalidate>
                    <h1>Вход</h1>
                    <?php if (checkAlert('error')): ?>
                        <a class="alert_con"><?php echo getAlert('error'); ?></a>
                    <?php endif; ?>
                    <div class="field_con">
                        <input
                                type="text"
                                name="login"
                                class="sup_field"
                                placeholder="Логин"
                                value="<?php echo old('login'); ?>"
                            <?php echo errorFrame('login'); ?>
                        >
                        <?php if (checkError('login')): ?>
                            <a class="reg_alert"><?php echo errorMessage('login'); ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="field_con">
                        <input
                                type="password"
                                name="password"
                                class="changeable sup_field secure"
                                placeholder="Пароль"
                            <?php echo errorFrame('password'); ?>
                        >
                        <img class="eye_image" src="/img/svg/eye_closed.svg"/>
                        <?php if (checkError('password')): ?>
                            <a class="reg_alert"><?php echo errorMessage('password'); ?></a>
                        <?php endif; ?>
                    </div>
                    <button class="sup_but" type="submit">Войти</button>
                    <a class="link_to" href="/signup.php">Зарегистрироваться</a>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include_once __DIR__ . '/components/footer.php' ?>
</body>
</html>