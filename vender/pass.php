<?php
session_start();
require_once __DIR__ . '/connect.php';  

// 1) Проверяем, что пользователь залогинился
if (empty($_SESSION['user_login']) || empty($_SESSION['id_users'])) {
    $_SESSION['pass_error'] = 'Пожалуйста, войдите в систему.';
    header('Location: ../lichniy.php');
    exit;
}

// 2) Получаем данные из формы
$cur     = trim($_POST['current_password'] ?? '');
$new     = trim($_POST['new_password']     ?? '');
$confirm = trim($_POST['confirm_password'] ?? '');

// 3) Базовая валидация
if ($cur === '' || $new === '' || $confirm === '') {
    $_SESSION['pass_error'] = 'Пожалуйста, заполните все поля.';
    header('Location: ../lichniy.php');
    exit;
}

if ($new !== $confirm) {
    $_SESSION['pass_error'] = 'Новый и подтверждение пароля не совпадают.';
    header('Location: ../lichniy.php');
    exit;
}

if (mb_strlen($new) < 6) {
    $_SESSION['pass_error'] = 'Новый пароль должен быть не менее 6 символов.';
    header('Location: ../lichniy.php');
    exit;
}

// 4) Выбираем текущий хеш из БД
$uid = (int) $_SESSION['id_users'];
$sql = "SELECT pass FROM users WHERE id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param('i', $uid);
$stmt->execute();
$stmt->bind_result($hash);
if (! $stmt->fetch()) {
    $_SESSION['pass_error'] = 'Пользователь не найден.';
    $stmt->close();
    header('Location: ../lichniy.php');
    exit;
}
$stmt->close();

// 5) Сверяем текущий пароль
if (! password_verify($cur, $hash)) {
    $_SESSION['pass_error'] = 'Текущий пароль введён неверно.';
    header('Location: ../lichniy.php');
    exit;
}

// 6) Хешируем новый и сохраняем
$new_hash = password_hash($new, PASSWORD_DEFAULT);
$upd = $connect->prepare("UPDATE users SET pass = ? WHERE id = ?");
$upd->bind_param('si', $new_hash, $uid);
if ($upd->execute()) {
    $_SESSION['pass_success'] = 'Пароль успешно изменён.';
} else {
    $_SESSION['pass_error'] = 'Ошибка при сохранении нового пароля.';
}
$upd->close();
$connect->close();

// 7) Возвращаемся в профиль
header('Location: ../lichniy.php');
exit;
