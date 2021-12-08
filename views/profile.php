<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Профиль</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
<div class="profile">
    <div class="page_top">
        <div class="page_title">
            Привет, <span><?= $GLOBALS['user_info']['name']; ?></span>
        </div>

        <div class="page_logout">
            <a href="/logout">Выйти</a>
        </div>
    </div>
    <div class="items">
        <div class="login_tab change_password form" data-url="/change_password">
            <input type="password" class="element" name="old_password" placeholder="Старый пароль">
            <input type="password" class="element" name="password" placeholder="Новый пароль">
            <input type="password" class="element" name="confirm_password" placeholder="Подтверждение пароля">
            <div class="buttons">
                <div class="login_but submit">Сохранить</div>
            </div>
        </div>

        <div class="login_tab change_username form" data-url="/change_username">
                <input type="text" class="element" name="username" placeholder="Сменить ФИО"
                       value="<? $GLOBALS['user_info']['name']; ?>">
                <div class="buttons">
                    <div class="login_but submit">Сохранить</div>
                </div>

        </div>
    </div>
</div>

<div class="notification">
Hello world
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
<script src="../assets/scripts.js"></script>
</body>
</html>

