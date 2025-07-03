<?php
// session_start();
// require_once('connect.php');

// // Получаем данные из формы
// $login = $_POST['login'];
// $pass = $_POST['pass'];
// $date = date('d.m.Y');
// $mail = isset($_POST['email']) ? $_POST['email'] : '';
// $tel = isset($_POST['telefon']) ? $_POST['telefon'] : '';

// // Проверка на заполненность обязательных полей
// if(empty($login) || empty($pass)){
//     echo 'Заполните поля';
// } else {
//     // Проверяем, существует ли пользователь с таким логином
//     $result = mysqli_query($connect, "SELECT `login` FROM `users` WHERE `login` = '$login'");
//     if(mysqli_num_rows($result) == 0) {
//         echo 'Неверный логин или пароль';
//     } else {
//        // Получаем хешированный пароль из базы данных
//         $result = mysqli_query($connect, "SELECT `pass` FROM `users` WHERE `login` = '$login'");
//         $row = $result->fetch_assoc();
//         $hashed_password_from_db = $row['pass'];

//        // Проверяем пароль с помощью password_verify()
//        if (password_verify($pass, $hashed_password_from_db)) {
//             // Если пароль верный, получаем все данные пользователя
//             $logout = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
//             if (mysqli_num_rows($logout) > 0) {
//                 $user = mysqli_fetch_assoc($logout);

//                  // Сохраняем данные пользователя в сессию
//                 $_SESSION['user_login'] = $user['login'];
//                 $_SESSION['time'] = $date;
//                 $_SESSION['tel'] = $user['telefon'];
//                 $_SESSION['mail'] = $user['email'];
                
//                 // Перенаправляем на главную страницу
//                 header('Location: ../index.php');
//                 exit(); // Добавляем exit(), чтобы остановить выполнение скрипта после перенаправления
//             } else {
//                 // Обработка случая, если не удалось получить данные пользователя
//                echo 'Ошибка получения данных пользователя';
//             }
//         } else {
//             echo 'Неверный логин или пароль';
//         }
//     }
// }


// session_start();
// require_once('connect.php');

// // Инициализируем переменную для хранения ошибок в сессии
// $_SESSION['error_message'] = '';

// // Получаем данные из формы
// $login = $_POST['login'] ?? ''; // Используем ?? для безопасного доступа к $_POST
// $pass = $_POST['pass'] ?? '';
// $date = date('d.m.Y');
// $mail = $_POST['email'] ?? '';
// $tel = $_POST['telefon'] ?? '';
// // $id = $_POST['id'] ?? '';


// // Проверка на заполненность обязательных полей
// if(empty($login) || empty($pass)){
//     $_SESSION['error_message'] = 'Заполните поля';
//      header('Location: ' . $_SERVER['HTTP_REFERER']); // Перенаправляем обратно
//     exit();
// } else {
//     // Проверяем, существует ли пользователь с таким логином
//     $result = mysqli_query($connect, "SELECT `login` FROM `users` WHERE `login` = '$login'");
//     if(mysqli_num_rows($result) == 0) {
//          $_SESSION['error_message'] = 'Неверный логин или пароль';
//          header('Location: ' . $_SERVER['HTTP_REFERER']); // Перенаправляем обратно
//         exit();
//     } else {
//        // Получаем хешированный пароль из базы данных
//         $result = mysqli_query($connect, "SELECT `pass` FROM `users` WHERE `login` = '$login'");
//         $row = $result->fetch_assoc();
//         $hashed_password_from_db = $row['pass'];

//        // Проверяем пароль с помощью password_verify()
//        if (password_verify($pass, $hashed_password_from_db)) {
//             // Если пароль верный, получаем все данные пользователя
//             $logout = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
//             if (mysqli_num_rows($logout) > 0) {
//                 $user = mysqli_fetch_assoc($logout);

//                  // Сохраняем данные пользователя в сессию
//                 $_SESSION['user_login'] = $user['login'];
//                 $_SESSION['time'] = $date;
//                 $_SESSION['tel'] = $user['telefon'];
//                 $_SESSION['mail'] = $user['email'];
//                 // $_SESSION['id'] = $id['id'];
                
//                 // Перенаправляем на главную страницу
//                 header('Location: ' . $_SERVER['HTTP_REFERER']);
//                 exit(); // Добавляем exit(), чтобы остановить выполнение скрипта после перенаправления
//             } else {
//                 // Обработка случая, если не удалось получить данные пользователя
//                $_SESSION['error_message'] = 'Ошибка получения данных пользователя';
//                  header('Location: ' . $_SERVER['HTTP_REFERER']); // Перенаправляем обратно
//                  exit();
//             }
//         } else {
//             $_SESSION['error_message'] = 'Неверный логин или пароль';
//             header('Location: ' . $_SERVER['HTTP_REFERER']); // Перенаправляем обратно
//             exit();
//         }
//     }
// }

session_start();
require_once('connect.php');

$_SESSION['error_message'] = '';

$login = $_POST['login'] ?? '';
$pass = $_POST['pass'] ?? '';
$date = date('d.m.Y');

if(empty($login) || empty($pass)){
    $_SESSION['error_message'] = 'Заполните поля';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

// в запрос добавляем id пользователя
$stmt = $connect->prepare("SELECT id, login, pass, telefon, email, img FROM users WHERE login = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
    $_SESSION['error_message'] = 'Неверный логин или пароль';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$user = $result->fetch_assoc();
$hashed_password_from_db = $user['pass'];

// Проверь этот кусок вероятно из за кодировки в моей базе хеш не правильно создается, я проверку не прохожу
if (!password_verify($pass, $hashed_password_from_db)) {
   $_SESSION['error_message'] = 'Неверный логин или пароль';
   header('Location: ' . $_SERVER['HTTP_REFERER']);
   exit();
}

// Сохраняем данные пользователя в сессию, также добавляем id_users, который равен id пользователя в базе
$_SESSION['user_login'] = $user['login'];
$_SESSION['time'] = $date;
$_SESSION['tel'] = $user['telefon'];
$_SESSION['mail'] = $user['email'];
$_SESSION['id_users'] = $user['id'];
$_SESSION['img'] = $user['img'];

// Перенаправляем на главную страницу
header('Location: /');
?>