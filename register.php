<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>

    <h2>Форма регистрации</h2>

    <form action="actions/register_action.php" method="POST">

        <div>
            <label for="name">Имя:</label><br>
            <input type="text" name="name" id="name" placeholder="Иван Иванов" required>
        </div>
        <br>

        <div>
            <label for="phone">Телефон:</label><br>
            <input type="tel" name="phone" id="phone" placeholder="+7 (999) 000-00-00" required>
        </div>
        <br>

        <div>
            <label for="email">Почта:</label><br>
            <input type="email" name="email" id="email" placeholder="user@example.com" required>
        </div>
        <br>

        <div>
            <label for="password">Пароль:</label><br>
            <input type="password" name="password" id="password" required>
        </div>
        <br>

        <div>
            <label for="password_confirm">Повторить пароль:</label><br>
            <input type="password" name="password_confirm" id="password_confirm" required>
        </div>
        <br>

        <div>
            <input type="submit" value="Зарегистрироваться">
        </div>

    </form>
</body>

</html>