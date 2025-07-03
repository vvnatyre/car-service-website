<?php
session_start();
require_once('connect.php');

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user_login'])) {
    header('Location: ../index.php');
    exit;
}
$username = $_SESSION['user_login'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatarka'])) {
    $file = $_FILES['avatarka'];

    // Проверяем на ошибки
    if ($file['error'] === UPLOAD_ERR_OK) {
        // Базовая валидация: тип и размер
        $allowedMime = ['image/jpeg','image/png','image/gif'];
        if (in_array($file['type'], $allowedMime) && $file['size'] <= 2 * 1024 * 1024) {
            // Генерируем уникальное имя
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newName = uniqid('avatar_', true) . '.' . $ext;

            $uploadDir = __DIR__ . 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $destination = $uploadDir . $newName;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                // Сохраняем в БД только относительный путь
                $relativePath = 'vender/uploads/' . $newName;
                $stmt = $connect->prepare("UPDATE users SET img = ? WHERE login = ?");
                $stmt->bind_param("ss", $relativePath, $username);
                if ($stmt->execute()) {
                    // Перенаправляем обратно на страницу профиля
                    header('Location: ../lichniy.php');
                    exit;
                } else {
                    $error = "Ошибка обновления записи в базе: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $error = "Не удалось переместить файл на сервер.";
            }
        } else {
            $error = "Неверный формат файла или слишком большой размер (макс. 2 МБ).";
        }
    } else {
        $error = "Ошибка загрузки (код ошибки: {$file['error']}).";
    }
}
?>