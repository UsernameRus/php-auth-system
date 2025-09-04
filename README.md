# Система регистрации и авторизации на нативном PHP

## Инструкция по запуску

Чтобы развернуть проект выполните следующие шаги:

**1. Клонирование репозитория:**

```bash
git clone https://github.com/UsernameRus/php-auth-system.git
cd php-auth-system
```

**2. Настройка базы данных:**

- Выполнить SQL-запрос для создания таблицы `users`:

```sql
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**3. Конфигурация проекта:**

- Открыть файл `db.php`.
- Указать данные для подключения к БД в переменных: `$host`, `$port`, `$dbname`, `$username`, `$password`.

**4. Настройка Yandex SmartCaptcha:**

- Откройте файл `login.php` и вставьте ключ клиента в `data-sitekey`.
- Откройте файл `actions/login_action.php` и вставьте ключ сервера в константу `SMARTCAPTCHA_SERVER_KEY`.

**5. Запуск локального веб-сервера:**

```bash
php -S localhost:8000
```
