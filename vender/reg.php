<?php
session_start();
require_once('connect.php');


$login = $_POST['login'];
$mail = $_POST['email'];
$pass = $_POST['pass'];
$tel = $_POST['telefon'];
// $id = $_POST['id_users'];
$passtwo = $_POST['password_second'];
$date = date('d.m.Y');

// Проверка совпадения паролей
if ($pass !== $passtwo) {
    header("Location: ../index.php?error=passwords_do_not_match");
    exit();
}

// Проверка на существование логина
$logcheck = mysqli_prepare($connect, "SELECT login FROM users WHERE login = ?");
mysqli_stmt_bind_param($logcheck, "s", $login);
mysqli_stmt_execute($logcheck);
mysqli_stmt_store_result($logcheck);

if (mysqli_stmt_num_rows($logcheck) > 0) {
    header("Location: ../index.php?error=login_exists");
    exit();
}

// Проверка на существование email
$mailcheck = mysqli_prepare($connect, "SELECT email FROM users WHERE email = ?");
mysqli_stmt_bind_param($mailcheck, "s", $mail);
mysqli_stmt_execute($mailcheck);
mysqli_stmt_store_result($mailcheck);

if (mysqli_stmt_num_rows($mailcheck) > 0) {
    header("Location: ../index.php?error=email_exists");
    exit();
}

// Обработка загрузки аватарки
if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
    $upload_dir = '../uploads/';
    $file_name = basename($_FILES['img']['name']);
    $file_path = $upload_dir . $file_name;

    // Перемещение файла в папку uploads
    if (move_uploaded_file($_FILES['img']['tmp_name'], $file_path)) {
        $img_path = 'uploads/' . $file_name;
    } else {
        header("Location: ../index.php?error=file_upload_failed");
        exit();
    }
} else {
    $img_path = 'img/ava21.png'; // Путь к аватарке по умолчанию
}

// Хеширование пароля
$pass_zap = password_hash($pass, PASSWORD_DEFAULT);

// Вставка данных в базу данных
$stmt = mysqli_prepare($connect, "INSERT INTO users (id, login, email, telefon, pass, img, time) VALUES (NULL, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssssss", $login, $mail, $tel, $pass_zap, $img_path, $date);

if (mysqli_stmt_execute($stmt)) {
    $stmt = $connect->prepare("SELECT id FROM users WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();


    $_SESSION['user_login'] = $login;
    $_SESSION['time'] = $date;
    $_SESSION['mail'] = $mail;
    $_SESSION['id_users'] = $user['id'];
    $_SESSION['tel'] = $tel;
    $_SESSION['img'] = $img_path; // Сохраняем путь к аватарке в сессии
    header("Location: ../index.php?success=registration_successful");
    exit();
} else {
    // var_dump(2);+
    header("Location: ../index.php?error=registration_failed");
    exit();
}
?>
