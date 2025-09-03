<?php

// Параметры подключения к базе данных
$host = 'localhost';
$port = '3306';
$dbname = 'auth_system';
$username = 'root';
$password = '';

try {
  $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
  $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
  die("Ошибка подключения к базе данных: " . $e->getMessage());
}