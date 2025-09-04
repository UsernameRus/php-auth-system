<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
</head>

<body>

    <h1>Добро пожаловать!</h1>
    <p>Это простая система аутентификации, написанная на нативном PHP.</p>
    <hr>

    <?php
    if (isset($_SESSION['user_id'])):
    ?>
        <!-- Блок виден только для АВТОРИЗОВАННЫХ -->
        <p>Вы успешно вошли в систему.</p>
        <p>
            <a href="profile.php">Профиль</a>
        </p>
        <p>
            <a href="logout.php">Выйти из аккаунта</a>
        </p>

    <?php
    else:
    ?>
        <!-- Блок виден только для ГОСТЕЙ (неавторизованных) -->
        <p>Для доступа к личному кабинету, войдите или зарегистрируйтесь.</p>
        <p>
            <a href="login.php">Авторизация</a>
        </p>
        <p>
            <a href="register.php">Регистрация</a>
        </p>

    <?php
    endif;
    ?>

</body>

</html>