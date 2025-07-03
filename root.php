<?php
	require_once('vender/connect.php');
	session_start();

    // Обработка ответа админа
    if (isset($_POST['reply_zapis'])) {
        $id    = (int)$_POST['zapis_id'];
        $reply = trim($_POST['reply']);

        if ($reply === '') {
            $_SESSION['error'] = 'Введите текст ответа.';
        } else {
            // Получаем email клиента
            $res = mysqli_query($connect, "SELECT email FROM zapis WHERE id = {$id}");
            if ($res && mysqli_num_rows($res) > 0) {
                $row     = mysqli_fetch_assoc($res);
                $to      = $row['email'];
                $subject = 'Ответ на Вашу заявку';
                $headers = "From: no-reply@yourdomain.ru\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8\r\n";

                // Пробуем отправить письмо и ловим ошибку, если она есть
                if (mail($to, $subject, $reply, $headers)) {
                    mysqli_query($connect, "UPDATE zapis SET id_status = 2 WHERE id = {$id}");
                    $_SESSION['success'] = "Письмо успешно отправлено на {$to}.";
                } else {
                    $err = error_get_last();
                    $_SESSION['error'] = 'Не удалось отправить письмо. PHP-ошибка: ' 
                                        . ($err['message'] ?? 'неизвестная');
                }
            } else {
                $_SESSION['error'] = "Заявка с ID {$id} не найдена.";
            }
        }

        header('Location: root.php#vm3');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="img/fav.png">
    <title>AUTOPRO</title>
</head>
<body>
    <div class="form_moika3">
        <div class="dark_block_modal3"></div>
        <?// забыл написать метод отправки?>
        <form class="form_white3" method="post" action="./vender/save_auto.php" onsubmit="showAlert()">
            <h2>Автомобиль</h2>
            <input type="text" placeholder="Название авто" name="nazvanie_auto" class="title_input22">
            <!-- <textarea type="text" disabled class="title_input22" name="comment"></textarea> -->
            <input type="number"  placeholder="Год"  name="god" class="title_input2">
            <input type="number"  placeholder="Мощность" name="moch" class="title_input2">
            <input type="number"  placeholder="Обьем" name="obem" class="title_input2">
            <input type="text"  placeholder="Категория" name="kategoria" class="title_input2">
            <input type="text"  placeholder="Коробка" name="korobka" class="title_input2">
            <!-- <select class="title_input2">
                <option>Lada Granta</option>
            </select> -->
            <button>Добавить</button>
        </form>
    </div>
    <div class="body_2">
    <header>
        <div class="head">
            <div class="logo">
                <a href="index.php"><img src="./img/logo.png" width="130px" alt=""></a>
            </div>
            <nav>
                <div class="dropdown">
                    <a href="#" class="dropbtn">Услуги</a>
                    <img src="img/треугольник.png" width="10px" alt="">
                    <div class="dropdown-content">
                        <a href="moika.php">Мойка</a>
                        <a href="polirovka.php">Полировка</a>
                        <a href="okraska.php">Окраска</a>
                        <a href="kuzrem.php">Кузовной ремонт</a>
                        <a href="diagnostika.php">Диагностика</a>
                    </div>
                </div>
                <a href="onas.php">О нас</a>
                <a href="kontakti.php">Контакты</a>
                <!-- <a href="#">Вакансии</a> -->
            </nav>
            <div class="ava">
            
                <?php 
                    if(isset($_SESSION['user_login'])){
                        echo "
                            <div class='nik'>
                                <a href='#' class='profile-link' onclick='toggleDropdown()'>{$_SESSION['user_login']}</a>
                                
                                <div class='dropdown3' id='dropdown'>
                                    <a href='lichniy.php'>Личный кабинет</a>
                                    <a href='vender/logout.php'>Выход</a>
                                </div>
                            </div>";
                    }else{
                        echo "<div class='nik'><a href='#' id='login-button'>Войти</a></div>";
                    }   
                ?>
                <!-- <div class="nik"><a href="#" id="login-button">Войти</a></div>  -->
                <div id="login-button"></div>
            </div>
            <div class="nomer">
                <div class="nonerok">7 (999) 123 23 32</div>
            </div>
            <div class="burger" id="burger">
                <span></span>
            </div>
        </div>
        <div class="auth-modal" id="auth-modal" <?php if (!(isset($_SESSION['error_message']) && !empty($_SESSION['error_message']))) {echo "style=\"display: none\"";} else {echo "";}?>>
            <div class="modal-content">
                <h2 id="modal-title">Войти</h2>
                <form id="auth-form" class="auth-form" method="post" action="vender/avtoriz.php">
                    <input type="text" placeholder="Логин" required name="login">
                    <input type="password" placeholder="Пароль" required name="pass">
                    <div class="ochibka">
                        <?php 
                            if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) {
                            echo $_SESSION['error_message'];
                            unset($_SESSION['error_message']); // Удаляем сообщение из сессии
                            }
                            ?>
                    </div>
                    <button type="submit" >Войти</button>
                    <p class="modal-p"><a href="#" id="toggle-link">Зарегистрироваться</a></p>
                </form>
                
                <form id="register-form" class="auth-form" method="post" style="display: none;" action="vender/reg.php" enctype="multipart/form-data">
                    <input type="text" placeholder="Логин" required name="login">
                    <input type="text" placeholder="Почта" required name="email">
                    <input type="text" placeholder="Телефон" required name="telefon">
                    <input type="password" placeholder="Пароль" required name="pass">
                    <input type="password" placeholder="Подтверждение пароля" required name="password_second">
                    <label class="input-file">
                        <input type="file" name="file">		
                        <span>Вставьте аватарку</span>
                    </label>
                    <button type="submit">Зарегистрироваться</button>
                    <p class="modal-p"><a href="#" id="toggle-link" >Войти</a></p>
                </form>
                
            </div>
        </div>
        

    </header>

        <main>
            <div class="vseli">
                <p class="lich">Админ панель</p>
                <div class="vmeste_osn">
                    <div class="osn_lick_pr42">
                        <div class="osn_lich_pr24" onclick="showTab('vm1')">Пользователи</div>
                        <div class="osn_lich_pr24" onclick="showTab('vm2')">Заявки</div>
                        <div class="osn_lich_pr24" onclick="showTab('vm3')">Еще что то</div>
                    </div>
                </div>  

                <!-- Контейнеры с контентом -->
                <div class="vm1 tab-section active-tab">
                    <p style="margin-bottom: 10px; ">Пользователи</p>

                    <?php
                    // Удаление пользователя и его связанных данных
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
                        $user_id = intval($_POST['delete_user']);

                        // Удаление записей, связанных с авто пользователя
                        $auto_query = mysqli_query($connect, "SELECT id_auto FROM auto WHERE id_users = $user_id");
                        while ($auto = mysqli_fetch_assoc($auto_query)) {
                            $auto_id = intval($auto['id_auto']);
                            mysqli_query($connect, "DELETE FROM zapis_uslug WHERE id_auto = $auto_id");
                        }

                        // Удаление авто и самого пользователя
                        mysqli_query($connect, "DELETE FROM auto WHERE id_users = $user_id");
                        mysqli_query($connect, "DELETE FROM users WHERE id = $user_id");
                    }

                    // Получение всех пользователей
                    $result = mysqli_query($connect, "SELECT * FROM users");

                    if (mysqli_num_rows($result) > 0) {
                        echo "<div style='max-height: 600px; overflow-y: auto; border-radius: 12px; '>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<div style='margin-bottom: 20px; padding: 15px; background-color: #f9f9f9; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);'>";
                            echo "<p><strong>👤 Логин:</strong> " . htmlspecialchars($row['login']) . "</p>";
                            echo "<p><strong>📧 Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                            echo "<p><strong>📞 Телефон:</strong> " . htmlspecialchars($row['telefon']) . "</p>";
                            echo "<p><strong>🕒 Регистрация:</strong> " . htmlspecialchars($row['time']) . "</p>";

                            // Кнопка удаления
                            echo "<form method='POST' onsubmit=\"return confirm('Удалить пользователя?');\" style='margin-top: 10px;'>
                                    <input type='hidden' name='delete_user' value='{$row['id']}'>
                                    <button type='submit' style='background-color: #F64C72; color: white; border: none; padding: 8px 14px; border-radius: 6px; cursor: pointer; font-weight: bold;'>Удалить</button>
                                </form>";
                            echo "</div>";
                        }

                        echo "</div>";
                    } else {
                        echo "<p>Нет пользователей.</p>";
                    }
                    ?>
                </div>

                <div class="vm2 tab-section">
                    <p>Заявки</p>
                    <?php
                    // Обработка смены статуса
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
                        $zapis_id = intval($_POST['zapis_id']);
                        $new_status = intval($_POST['status']);
                        mysqli_query($connect, "UPDATE zapis_uslug SET id_status = $new_status WHERE id_zapis_uslug = $zapis_id");
                    }

                    // Получение статусов
                    $status_result = mysqli_query($connect, "SELECT * FROM status");
                    $statuses = [];
                    while ($s = mysqli_fetch_assoc($status_result)) {
                        $statuses[$s['id_status']] = $s['name'];
                    }

                    // Заявки + JOIN
                    $query = "SELECT z.*, u.login, a.nazvanie_auto, usl.nazvanie 
                            FROM zapis_uslug z 
                            JOIN users u ON z.id_users = u.id 
                            JOIN auto a ON z.id_auto = a.id_auto 
                            JOIN uslugi usl ON z.id_uslugi = usl.id_uslugi";
                    $result = mysqli_query($connect, $query);

                    if (mysqli_num_rows($result) > 0) {
                        echo '<div style="overflow-x:auto; margin-top: 20px;">';
                        echo '<table style="
                            border-collapse: collapse; 
                            width: 100%; 
                            background-color: #ffffff; 
                            border-radius: 10px; 
                            overflow: hidden;
                            box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
                            font-family: \'Regular\';
                        ">
                        <thead style="background-color: #2F2FA2; color: white;">
                            <tr>
                                <th style="padding: 12px;">ID</th>
                                <th style="padding: 12px;">Пользователь</th>
                                <th style="padding: 12px;">Авто</th>
                                <th style="padding: 12px;">Услуга</th>
                                <th style="padding: 12px;">Телефон</th>
                                <th style="padding: 12px;">Дата</th>
                                <th style="padding: 12px;">Статус</th>
                                <th style="padding: 12px;">Действие</th>
                            </tr>
                        </thead><tbody>';

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr style="border-bottom: 1px solid #ddd;">';
                            echo '<td style="padding: 10px; text-align: center;">' . $row['id_zapis_uslug'] . '</td>';
                            echo '<td style="padding: 10px;">' . htmlspecialchars($row['login']) . '</td>';
                            echo '<td style="padding: 10px;">' . htmlspecialchars($row['nazvanie_auto']) . '</td>';
                            echo '<td style="padding: 10px;">' . htmlspecialchars($row['nazvanie']) . '</td>';
                            echo '<td style="padding: 10px;">' . htmlspecialchars($row['nomer_tel']) . '</td>';
                            echo '<td style="padding: 10px;">' . htmlspecialchars($row['data']) . '</td>';
                            echo '<td style="padding: 10px;">
                                    <form method="POST" style="display:flex; align-items:center; gap:8px;">
                                        <input type="hidden" name="zapis_id" value="' . $row['id_zapis_uslug'] . '">
                                        <select name="status" style="
                                            padding: 5px 8px;
                                            border: 1px solid #ccc;
                                            border-radius: 6px;
                                            background-color: #f0f0f0;
                                            font-size: 14px;
                                        ">';

                            foreach ($statuses as $id => $name) {
                                $selected = ($id == $row['id_status']) ? 'selected' : '';
                                echo "<option value=\"$id\" $selected>$name</option>";
                            }

                            echo '</select></td>';
                            echo '<td style="padding: 10px;">
                                    <button type="submit" name="update_status" style="
                                        background-color: #F64C72;
                                        color: white;
                                        border: none;
                                        padding: 6px 12px;
                                        border-radius: 6px;
                                        cursor: pointer;
                                        font-weight: bold;
                                    ">Сохранить</button>
                                </form></td>';
                            echo '</tr>';
                        }

                        echo '</tbody></table></div>';
                    } else {
                        echo '<p>Заявок нет.</p>';
                    }
                    ?>
                </div>

                <?php
                    // Вверху файла, до вывода HTML, можно объявить хелпер:
                    function h(string|int|null $val): string {
                        return htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
                    }
                    ?>
                    <div class="vm3 tab-section" id="vm3">
                        <!-- Flash-сообщения -->
                        <?php if (!empty($_SESSION['success'])): ?>
                            <script>alert(<?= json_encode($_SESSION['success'], JSON_UNESCAPED_UNICODE) ?>);</script>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>
                        <?php if (!empty($_SESSION['error'])): ?>
                            <script>alert(<?= json_encode($_SESSION['error'], JSON_UNESCAPED_UNICODE) ?>);</script>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <?php
                        $res = mysqli_query(
                            $connect,
                            "SELECT z.*, s.name AS status_name
                            FROM zapis z
                            LEFT JOIN status s ON z.id_status = s.id_status
                            ORDER BY z.id DESC"
                        );
                        if (mysqli_num_rows($res) > 0): ?>
                            <div style="max-height:600px; overflow-y:auto; padding-right:10px;">
                            <?php while ($z = mysqli_fetch_assoc($res)): ?>
                                <div style="border:1px solid #ccc; padding:10px; margin-bottom:15px; border-radius:6px;">
                                    <p><strong>ID:</strong> <?= h($z['id']) ?></p>
                                    <p><strong>Имя:</strong> <?= h($z['name']) ?></p>
                                    <p><strong>Email:</strong> <?= h($z['email']) ?></p>
                                    <p><strong>Сообщение:</strong><br><?= nl2br(h($z['text'])) ?></p>
                                    <p><strong>Статус:</strong> <?= h($z['status_name']) ?></p>

                                    <form method="post" style="margin-top:10px;">
                                        <input type="hidden" name="zapis_id" value="<?= h($z['id']) ?>">
                                        <textarea
                                            name="reply"
                                            required
                                            placeholder="Введите ответ клиенту…"
                                            style="width:100%; height:80px; padding:6px; border-radius:4px; border:1px solid #aaa;"
                                        ></textarea>
                                        <button
                                            type="submit"
                                            name="reply_zapis"
                                            style="margin-top:8px; padding:8px 12px; background-color:#2F2FA2; color:#fff; border:none; border-radius:4px; cursor:pointer;"
                                        >
                                            Отправить ответ
                                        </button>
                                    </form>
                                </div>
                            <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p>Новых сообщений нет.</p>
                        <?php endif; ?>
                    </div>

            </div>
        </main>
    </div>
    <footer>
        <div class="foot">
            <hr>
        </div>
        <div class="footer_textgl">
            <div class="nizz">
                <p>©2025 AUTOPRO. Все права защищены.</p>
                <div class="ikonki">
                    <a href="https://vk.com/club230665758" target="_blank"><img src="/img/3670055 1.png" alt=""></a>
                    <a href="https://t.me/avtoprosrp" target="_blank"><img src="/img/2111646 1.png" alt=""></a>
                </div>
            </div>
        </div>
    </footer>
    <script src="/js/js.js"></script>
    <script src="/js/lic.js"></script>
</body>
</html>