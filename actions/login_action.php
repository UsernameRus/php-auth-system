<?php
session_start();

require_once '../db.php';

// проверка, чтобы поля не были пустыми
if (empty(trim($_POST['login'])) || empty(trim($_POST['password']))) {
    $_SESSION['error_message'] = "Поля 'Логин' и 'Пароль' не могут быть пустыми.";
    header('Location: ../login.php');
    exit();
}

$login = trim($_POST['login']);
$password = trim($_POST['password']);

// ищем пользователя в БД
$sql = "SELECT * FROM users WHERE email = ? OR phone = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$login, $login]);
$user = $stmt->fetch();

// проверяем, найден ли пользователь и верен ли пароль
if ($user && password_verify($password, $user['password_hash'])) {
    // авторизация успешна
    $_SESSION['user_id'] = $user['id'];
    header('Location: ../profile.php');
    exit();
} else {
    // ошибка авторизации
    $_SESSION['error_message'] = "Неверный логин или пароль.";
    header('Location: ../login.php');
    exit();
}
