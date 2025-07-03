
<?php
// require_once('connect.php');
// session_start();

// $nazvanie_auto = $_POST['nazvanie_auto'];
// $god = $_POST['god'];
// $korobka = $_POST['korobka'];
// $moch = $_POST['moch'];
// $obem = $_POST['obem'];
// $kategoria = $_POST['kategoria'];


// // Вставка данных в базу данных
// $stmt2 = mysqli_prepare($connect, "INSERT INTO auto (id, id, nazvanie_auto, god, korobka, moch, obem, kategoria) VALUES (NULL,  '$_SESSION[id]', ?, ?, ?, ?, ?, ?)");
// mysqli_stmt2_bind_param($stmt2, "ssssss", $nazvanie_auto, $god, $korobka, $moch, $obem, $kategoria);

// if (mysqli_stmt2_execute($stmt2)) {
//     $_SESSION['nazvanie_auto'] = $nazvanie_auto;
//     $_SESSION['god'] = $god;
//     $_SESSION['korobka'] = $korobka;
//     $_SESSION['moch'] = $moch;
//     $_SESSION['obem'] = $obem;
//     $_SESSION['kategoria'] = $kategoria;
//     header("Location: ../index.php?success=registration_successful");
//     exit();
// } else {
//     header("Location: ../index.php?error=registration_failed");
//     exit();
// }

// require_once('connect.php');  

// session_start();

// if (!isset($_SESSION['user_id'])) {
//     header("Location: ../index.php?error=lichniy.php");
//     exit();
// }
// $user_id = $_SESSION['user_id'];

// $nazvanie_auto = $_POST['nazvanie_auto'];
// $god = $_POST['god'];
// $korobka = $_POST['korobka'];
// $moch = $_POST['moch'];
// $obem = $_POST['obem'];
// $kategoria = $_POST['kategoria'];


// if(empty($nazvanie_auto) || empty($god) || empty($korobka) || empty($moch) || empty($obem) || empty($kategoria)){
//     header("Location: ../index.php?error=empty_fields");
//     exit();
// }

// $stmt = $connect->prepare("INSERT INTO auto (id_users, nazvanie_auto, god, korobka, moch, obem, kategoria) VALUES (?, ?, ?, ?, ?, ?, ?)");
// $stmt->bind_param("issssss", $user_id, $nazvanie_auto, $god, $korobka, $moch, $obem, $kategoria);

// if ($stmt->execute()) {
//     header("Location: ../index.php?success=auto_added");
//     exit();
// } else {
//     echo "Ошибка: " . $stmt->error;
//     header("Location: ../index.php?error=auto_add_failed");
//     exit();
// }

// $stmt->close();
// $connect->close();


// session_start();
// require_once('connect.php');
// var_dump($_SESSION);



// // Проверяем, авторизован ли пользователь
// if (!isset($_SESSION['id_users'])) {
//     die("Пользователь не авторизован.");
// }



// // Получаем данные из формы
// $nazvanie_auto = $_POST['nazvanie_auto'];
// $god = $_POST['god'];
// $moch = $_POST['moch'];
// $obem = $_POST['obem'];
// $kategoria = $_POST['kategoria'];

// // Получаем id_users из сессии
// $id_users = $_SESSION['id_users'];

// // Используем подготовленные выражения для защиты от SQL-инъекций
// $stmt = $conn->prepare("INSERT INTO avto (id_users, nazvanie_auto, god, moch, obem, kategoria) VALUES (?, ?, ?, ?, ?, ?)");
// $stmt->bind_param("isiiis", $id_users, $nazvanie_auto, $god, $moch, $obem, $kategoria);

// if ($stmt->execute()) {
//     echo "Новая запись успешно добавлена";
// } else {
//     echo "Ошибка: " . $stmt->error;
// }

// $stmt->close();
// $conn->close();


session_start();
require_once('connect.php');

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['id_users'])) {
    die("Пользователь не авторизован.");
}

// Получаем данные из формы
$nazvanie_auto = $_POST['nazvanie_auto'] ?? null;
$god = $_POST['god'] ?? null;
$moch = $_POST['moch'] ?? null;
$obem = $_POST['obem'] ?? null;
$kategoria = $_POST['kategoria'] ?? null;
$korobka = $_POST['korobka'] ?? null;

// Проверяем, что все обязательные поля заполнены
if (empty($nazvanie_auto) || empty($god) || empty($moch) || empty($obem) || empty($kategoria) || empty($korobka)) {
    die("Все поля формы обязательны для заполнения.");
}

// Получаем id_users из сессии
$id_users = $_SESSION['id_users'];



// Подготавливаем запрос
$stmt = $connect->prepare("INSERT INTO auto (id_users, nazvanie_auto, god, moch, obem, kategoria, korobka) VALUES (?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Ошибка подготовки запроса: " . $connect->error);
}

// Привязываем параметры
$stmt->bind_param("issssss", $id_users, $nazvanie_auto, $god, $moch, $obem, $kategoria, $korobka);

if ($stmt->execute()) {
    // Сохраняем данные в сессию
    // $new_auto = [
    //     'nazvanie_auto' => $nazvanie_auto,
    //     'god' => $god,
    //     'moch' => $moch,
    //     'obem' => $obem,
    //     'kategoria' => $kategoria,
    //     'korobka' => $korobka
    // ];

    // Если массив автомобилей еще не существует в сессии, создаем его
    // if (!isset($_SESSION['auto_list'])) {
    //     $_SESSION['auto_list'] = [];
    // }

    // Добавляем новый автомобиль в массив
    // $_SESSION['auto_list'][] = $new_auto;

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
