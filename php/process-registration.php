<?php
// Параметры для соединения с базой данных
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'Phone';

// Подключение к базе данных
$conn = new mysqli($host, $username, $password, $database);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}

// Получение данных из формы
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Защита от SQL-инъекций (используйте подготовленные запросы в продакшене)
$username = mysqli_real_escape_string($conn, $username);
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);

// Хеширование пароля (рекомендуется использовать более безопасные методы хеширования)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// SQL-запрос для вставки данных в таблицу пользователей
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

// Выполнение запроса
if ($conn->query($sql) === TRUE) {
    echo "Регистрация успешна!";
} else {
    echo "Ошибка при регистрации: " . $conn->error;
}

// Закрытие соединения
$conn->close();
?>
