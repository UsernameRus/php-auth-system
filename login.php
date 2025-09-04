<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
</head>

<body>

    <h2>Вход в систему</h2>

    <?php
    // вывод сообщения об успешной регистрации
    if (isset($_SESSION['success_message'])) {
        echo '<div style="color: green;">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
    }

    // вывод сообщения об ошибке
    if (isset($_SESSION['error_message'])) {
        echo '<div style="color: red;">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
    }
    ?>

    <form action="actions/login_action.php" method="POST">
        <div>
            <label for="login">Email или телефон</label><br>
            <input type="text" name="login" id="login" required>
        </div>
        <br>

        <div>
            <label for="password">Пароль</label><br>
            <input type="password" name="password" id="password" required>
        </div>
        <br>

        <div>
            <input type="submit" value="Авторизоваться">
        </div>
    </form>

</body>

</html>