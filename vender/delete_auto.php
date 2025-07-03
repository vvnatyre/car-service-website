<?php
// Подключаемся к базе данных
require_once('connect.php');

// Проверяем, передан ли индекс автомобиля
if (isset($_GET['index']) && is_numeric($_GET['index'])) {
    $index = $_GET['index'];

    // Запрос на удаление автомобиля
    $query = "DELETE FROM auto WHERE id_auto = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $index);

    if ($stmt->execute()) {
        // Успешное удаление
        echo "Успешно удалено";
    } else {
        // Обработка ошибок, если удаление не удалось
        echo "Ошибка: " . $stmt->error;
    }

    // Закрываем соединение
    $stmt->close();
}

$connect->close();
?>