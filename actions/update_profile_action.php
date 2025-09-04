<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    exit('Доступ запрещен.');
}

require_once '../db.php';

$currentUserId = $_SESSION['user_id'];
$name = trim($_POST['name']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$password_confirm = trim($_POST['password_confirm']);

$errors = [];

// проверка, что основные поля не пустые
if (empty($name)) {
    $errors[] = 'Имя не может быть пустым.';
}
if (empty($phone)) {
    $errors[] = 'Телефон не может быть пустым.';
}
if (empty($email)) {
    $errors[] = 'Email не может быть пустым.';
}

// если поле "Новый пароль" не пустое, значит пользователь хочет его сменить
if (!empty($password)) {
    if ($password !== $password_confirm) {
        $errors[] = 'Новые пароли не совпадают.';
    }
}

// проверка уникальности Email и телефона чтобы убедиться, что они не заняты кем-то другим
if (empty($errors)) {
    $sql = "SELECT id FROM users WHERE (email = ? OR phone = ?) AND id != ?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([$email, $phone, $currentUserId]);

    if ($stmt->fetch()) {
        $errors[] = 'Этот email или телефон уже занят другим пользователем.';
    }
}

// проверка, появились ли у нас ошибки после всех проверок
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
} else {
    // если ошибок нет, обновляем данные в базе

    if (!empty($password)) {
        // если ДА, то хэшируем новый пароль и готовим запрос с 5-ю параметрами
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET name = ?, email = ?, phone = ?, password_hash = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $phone, $password_hash, $currentUserId]);
    } else {
        // если НЕТ, то готовим запрос с 4-мя параметрами, не трогая пароль
        $sql = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $phone, $currentUserId]);
    }

    $_SESSION['success_message'] = "Профиль успешно обновлен.";
}

header('Location: ../profile.php');
exit();


