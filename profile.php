<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
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

    <h2>Ваши данные:</h2>
    <p><strong>Имя:</strong> <?php echo htmlspecialchars($currentUser['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($currentUser['email']); ?></p>
    <p><strong>Телефон:</strong> <?php echo htmlspecialchars($currentUser['phone']); ?></p>

    <hr>

    <a href="logout.php">Выйти</a>

</body>

</html>