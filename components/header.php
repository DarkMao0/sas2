<?php
require_once __DIR__ . '/../vendor/functions.php';
$user = authorizedUserData();
?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0">
    <title>HELP!!!</title>
</head>
<script>
    // Динамическая корректировка margin-top для .content на основе высоты шапки
    function adjustContentMargin() {
        const header = document.querySelector('.header');
        const content = document.querySelector('.content');
        if (header && content) {
            const headerHeight = header.offsetHeight;
            content.style.marginTop = `${headerHeight + 2}px`; // +10px запас
        }
    }
    // Выполняем корректировку при загрузке страницы и при изменении размера окна
    window.addEventListener('load', adjustContentMargin);
    window.addEventListener('resize', adjustContentMargin);
</script>
<header class="header">
    <div class="con">
        <div class="header_actions">
            <div class="navigation">
                <a href="/" title="На главную"><img class="log" src="../img/svg/logo.svg"></a>
                <div class="nav_sections">
                    <div class="nav_page"><a href="/book-table.php">Забронировать стол</a></div>
                    <div class="nav_page"><a href="/reviews.php">Отзывы</a></div>
                    <?php if (isset($user['id']) && $user['role'] !== 'user'): ?>
                        <div class="nav_page"><a href="../adminpanel.php">Управление заявками</a></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="profile_actions">
                <div class="profile_action">
                    <?php if (isset($user['id'])): ?>
                    <a class="user_pages" href="/signin.php">
                        <svg class="user_pages_image" width="25px" height="25px" viewBox="0 0 409.165 409.164">
                            <path d="M204.583,216.671c50.664,0,91.74-48.075,91.74-107.378c0-82.237-41.074-107.377-91.74-107.377
                            c-50.668,0-91.74,25.14-91.74,107.377C112.844,168.596,153.916,216.671,204.583,216.671z"/>
                            <path d="M407.164,374.717L360.88,270.454c-2.117-4.771-5.836-8.728-10.465-11.138l-71.83-37.392
                            c-1.584-0.823-3.502-0.663-4.926,0.415c-20.316,15.366-44.203,23.488-69.076,23.488c-24.877,0-48.762-8.122-69.078-23.488
                            c-1.428-1.078-3.346-1.238-4.93-0.415L58.75,259.316c-4.631,2.41-8.346,6.365-10.465,11.138L2.001,374.717
                            c-3.191,7.188-2.537,15.412,1.75,22.005c4.285,6.592,11.537,10.526,19.4,10.526h362.861c7.863,0,15.117-3.936,19.402-10.527
                            C409.699,390.129,410.355,381.902,407.164,374.717z"/>
                        </svg>
                        <span class="user_pages_title">Профиль</span>
                    </a>
                    <?php else: ?>
                        <a class="user_pages" href="/signin.php">
                            <svg class="user_pages_image" width="25px" height="25px" viewBox="0 0 409.165 409.164">
                                <path d="M204.583,216.671c50.664,0,91.74-48.075,91.74-107.378c0-82.237-41.074-107.377-91.74-107.377
                                c-50.668,0-91.74,25.14-91.74,107.377C112.844,168.596,153.916,216.671,204.583,216.671z"/>
                                <path d="M407.164,374.717L360.88,270.454c-2.117-4.771-5.836-8.728-10.465-11.138l-71.83-37.392
                                c-1.584-0.823-3.502-0.663-4.926,0.415c-20.316,15.366-44.203,23.488-69.076,23.488c-24.877,0-48.762-8.122-69.078-23.488
                                c-1.428-1.078-3.346-1.238-4.93-0.415L58.75,259.316c-4.631,2.41-8.346,6.365-10.465,11.138L2.001,374.717
                                c-3.191,7.188-2.537,15.412,1.75,22.005c4.285,6.592,11.537,10.526,19.4,10.526h362.861c7.863,0,15.117-3.936,19.402-10.527
                                C409.699,390.129,410.355,381.902,407.164,374.717z"/>
                            </svg>
                            <span class="user_pages_title">Войти</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>