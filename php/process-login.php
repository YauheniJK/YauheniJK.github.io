<?php
session_start();

// Параметры для соединения с базой данных
$host = 'ваш_хост';
$username = 'ваше_имя_пользователя';
$password = 'ваш_пароль';
$database = 'ваша_база_данных';

// Подключение к базе данных
$conn = new mysqli($host, $username, $password, $database);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}

// Получение данных из формы
$username = $_POST['username'];
$password = $_POST['password'];

// Защита от SQL-инъекций
$username = mysqli_real_escape_string($conn, $username);

// Поиск пользователя в базе данных
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Проверка пароля
    if (password_verify($password, $row['password'])) {
        // Успешный вход
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        header("Location: dashboard.php"); // Перенаправление на защищенную страницу (например, dashboard.php)
        exit();
    } else {
        // Неверный пароль
        echo "Неверный пароль";
    }
} else {
    // Пользователь не найден
    echo "Пользователь не найден";
}

// Закрытие соединения
$conn->close();
?>
