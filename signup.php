<?php
require_once __DIR__ . '/vendor/functions.php';
denyUser();
?>

<!DOCTYPE html>
<html  lang="ru" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Computer Galaxy - Регистрация</title>
    <link rel="icon" href="/img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/common.css">
    <link rel="stylesheet" href="/css/sign.css">
    <script defer src="js/common.js"></script>
    <script defer src="js/reg.js"></script>
</head>
<body>
<?php include_once __DIR__ . '/components/header.php' ?>
<main class="content">
    <div class="con">
        <div class="main_dir">
            <div class="form_con">
                <form class="sign_up" action="/vendor/signup" method="post" enctype="multipart/form-data" novalidate>
                    <h1>Регистрация</h1>
                    <?php if (checkAlert('error')): ?>
                        <a class="alert_con"><?php echo getAlert('error'); ?></a>
                    <?php endif; ?>
                    <div class="field_con">
                        <input
                                type="text"
                                name="name"
                                id="user_name"
                                class="sup_field"
                                placeholder="Ваше ФИО"
                                value="<?php echo old('name'); ?>"
                            <?php echo errorFrame('name'); ?>
                        >
                        <?php if (checkError('name')): ?>
                            <a class="reg_alert"><?php echo errorMessage('name'); ?></a>
                        <?php endif; ?>
                    </div>
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
                                type="email"
                                name="email"
                                class="sup_field"
                                placeholder="Ваш e-mail"
                                value="<?php echo old('email'); ?>"
                            <?php echo errorFrame('email'); ?>
                        >
                        <?php if (checkError('email')): ?>
                            <a class="reg_alert"><?php echo errorMessage('email'); ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="field_con">
                        <input
                                type="text"
                                name="phone"
                                class="sup_field"
                                placeholder="Ваш номер телефона"
                                value="<?php echo old('phone'); ?>"
                            <?php echo errorFrame('phone'); ?>
                        >
                        <?php if (checkError('phone')): ?>
                            <a class="reg_alert"><?php echo errorMessage('phone'); ?></a>
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
                    <div class="field_con">
                        <input
                                type="password"
                                name="confirm_password"
                                class="sup_field secure"
                                placeholder="Подтвердите пароль"
                            <?php echo errorFrame('confirm_password'); ?>
                        >
                        <?php if (checkError('confirm_password')): ?>
                            <a class="reg_alert"><?php echo errorMessage('confirm_password'); ?></a>
                        <?php endif; ?>
                    </div>
                    <button class="sup_but" type="submit">Зарегестрироваться</button>
                    <a class="link_to" href="/signin.php">Уже есть профиль?</a>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include_once __DIR__ .  '/components/footer.php' ?>
</body>
</html>Z