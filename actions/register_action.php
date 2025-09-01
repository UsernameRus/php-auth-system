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

// если есть хоть одна ошибка
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ../register.php');
    exit();
}

echo 'Валидация прошла успешно.';
?>