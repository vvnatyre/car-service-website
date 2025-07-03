<?php

session_start();
require_once('connect.php');

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['id_users'])) {
    header('Location: ../moika.php'); 
    die("Пользователь не авторизован.");
}

// Получаем данные из формы
$id_users = $_SESSION['id_users'] ?? null;
$id_auto = $_POST['id_auto'] ?? null;
$id_uslugi  = $_POST['id_uslugi'] ?? null;
$nomer_tel = $_POST['nomer_tel'] ?? null;
$dat = $_POST['data'] ?? null;
$id_status = 1;



// Проверяем, что все обязательные поля заполнены
if (empty($id_uslugi)) {
    die("Все поля формы обязательны для заполнения.");
}

// Получаем id_users из сессии
$id_users = $_SESSION['id_users'];





// Подготавливаем запрос
$stmt = $connect->prepare("INSERT INTO zapis_uslug (id_users, id_auto, id_uslugi, nomer_tel, data, id_status) VALUES (?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Ошибка подготовки запроса: " . $connect->error);
}

// Привязываем параметры
$stmt->bind_param("iisssi", $id_users, $id_auto, $id_uslugi, $nomer_tel, $dat,$id_status);

if ($stmt->execute()) {
    $message = "Новая запись успешно добавлена";
    echo "<script>
    alert('$message');
    </script>";
    $stmt->close();
    $connect->close();
    header('Location: ../lichniy.php'); 
} else {
    $message = "Ошибка: " . $stmt->error;
    echo "<script>
    alert('$message');
    </script>";
    $stmt->close();
    $connect->close();
    header('Location: ../lichniy.php'); 
}




?>