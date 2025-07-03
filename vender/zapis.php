<?php
    session_start();
	require_once('connect.php');


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name  = trim($_POST['name']);
        $email = trim($_POST['email']);
        $text  = trim($_POST['text']);

        // простая валидация
        if (empty($name) || empty($email) || empty($text) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Пожалуйста, заполните все поля корректно.';
            header('Location: ../index.php'); exit;
        }

        // вставляем в БД, ставим id_status = 1 (новая заявка)
        $stmt = $connect->prepare("INSERT INTO zapis (`name`, `email`, `text`, `id_status`) VALUES (?, ?, ?, 1)");
        $stmt->bind_param('sss', $name, $email, $text);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Спасибо! Ваша заявка успешно отправлена.';
        } else {
            $_SESSION['error']   = 'Ошибка базы данных. Попробуйте позже.';
        }
        header('Location: ../index.php'); exit;
    }
?>

