<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

require_once 'db.php';
$currentUserId = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$currentUserId]);
$currentUser = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
</head>

<body>

    <h1>Добро пожаловать, <?php echo htmlspecialchars($currentUser['name']); ?>!</h1>
    <a href="logout.php">Выйти</a>
    <hr>

    <?php
    // выводим сообщения об успехе или ошибках
    if (isset($_SESSION['success_message'])) {
        echo '<div style="color: green;">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
    }
    if (isset($_SESSION['errors'])) {
        echo '<div style="color: red;"><ul>';
        foreach ($_SESSION['errors'] as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul></div>';
        unset($_SESSION['errors']);
    }
    ?>

    <h2>Редактировать профиль</h2>
    <form action="actions/update_profile_action.php" method="POST">
        <div>
            <label for="name">Имя:</label><br>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($currentUser['name']); ?>" required>
        </div>
        <br>
        <div>
            <label for="phone">Телефон:</label><br>
            <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($currentUser['phone']); ?>" required>
        </div>
        <br>
        <div>
            <label for="email">Почта:</label><br>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($currentUser['email']); ?>" required>
        </div>
        <br>
        <hr>
        <p>Оставьте поля ниже пустыми, если не хотите менять пароль.</p>
        <div>
            <label for="password">Новый пароль:</label><br>
            <input type="password" name="password" id="password">
        </div>
        <br>
        <div>
            <label for="password_confirm">Повторить новый пароль:</label><br>
            <input type="password" name="password_confirm" id="password_confirm">
        </div>
        <br>
        <div>
            <input type="submit" value="Сохранить изменения">
        </div>
    </form>

</body>

</html>