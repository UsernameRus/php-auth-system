<?php
session_start();

require_once '../db.php';

define('SMARTCAPTCHA_SERVER_KEY', 'Secret key');

function check_captcha($token) {
    $ch = curl_init();
    $args = http_build_query([
        "secret" => SMARTCAPTCHA_SERVER_KEY,
        "token" => $token,
        "ip" => $_SERVER['REMOTE_ADDR'], // Нужно передать IP пользователя.
                                         // Как правильно получить IP зависит от вашего прокси.
    ]);
    curl_setopt($ch, CURLOPT_URL, "https://smartcaptcha.yandexcloud.net/validate?$args");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);

    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode !== 200) {
        echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
        return true;
    }
    $resp = json_decode($server_output);
    return $resp->status === "ok";
}

$token = $_POST['smart-token'];
if (!check_captcha($token)) {
    $_SESSION['error_message'] = "Пожалуйста, подтвердите, что вы не робот.";
    header('Location: ../login.php');
    exit();
}



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
