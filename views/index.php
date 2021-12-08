<?php global $username ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
<div class="wrapper">
    <?php if (!$GLOBALS['users_info']): ?>
        <div class="tabs">
            <div id="login" class="login_tab tab tab_active form" data-url="login/">
                <div class="title">Вход</div>
                <input type="text" class="element" name="login" placeholder="Введите имя">
                <input type="password" class="element" name="password" placeholder="Введите пароль">
                <div class="buttons">
                    <div class="login_but submit">Войти</div>
                    <div class="register_link tab_link" data-id="#register">Регистрация</div>
                </div>
            </div>
            <div id="register" class="tab login_tab form" data-url="register/">
                <div class="title">Регистрация</div>
                <input type="text" class="element" name="username" placeholder="Введите имя">
                <input type="email" class="element" name="email" placeholder="Введите email">
                <input type="text" class="element" name="login" placeholder="Придумайте логин">
                <input type="password" class="element" name="password" placeholder="Придумайте пароль">
                <input type="password" class="element" name="confirm_password" placeholder="Подтверждение пароля">
                <div class="buttons">
                    <div class="login_but submit">Регистрация</div>
                    <div class="register_link tab_link" data-id="#login">Вход</div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="notification"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
<script src="../assets/scripts.js"></script>
</body>
</html>