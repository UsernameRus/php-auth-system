<?php
session_start();

$requiredFields = [
    'name' => 'Имя',
    'phone' => 'Телефон',
    'email' => 'Почта',
    'password' => 'Пароль',
    'password_confirm' => 'Повтор пароля'
];

$errors = [];

// проверка на пустое поле
foreach ($requiredFields as $fieldName => $fieldLabel) {
    if (empty(trim($_POST[$fieldName]))) {
        $errors[] = "Поле '{$fieldLabel}' не может быть пустым.";
    }
}

// проверка на совпадение пароля
if (!empty($_POST['password']) && $_POST['password'] !== $_POST['password_confirm']) {
    $errors[] = "Пароли не совпадают.";
}

// проверка на уникальность в БД
if (empty($errors)) {
    require_once '../db.php';

    $sql = "SELECT id FROM users WHERE email = ? OR phone = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_POST['email'],
        $_POST['phone']
    ]);

    if ($stmt->fetch()) {
        $errors[] = "Пользователь с такой почтой или телефоном уже существует.";
    }
}

// если есть хоть одна ошибка
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ../register.php');
    exit();
}

// регистрируем пользователя
$passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, phone, email, password_hash) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        $_POST['name'],
        $_POST['phone'],
        $_POST['email'],
        $passwordHash
    ]);
    $_SESSION['success_message'] = "Регистрация прошла успешно! Теперь вы можете войти.";
    header('Location: ../login.php');
    exit();
} catch (PDOException $e) {
    die("Ошибка при регистрации пользователя: " . $e->getMessage());
}
