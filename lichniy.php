<?php
    session_start();
	require_once('vender/connect.php'); 
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
                <p class="lich">Личный кабинет</p>
                <div class="vmeste_osn2">
                    <div class="osn_lich_pr">

                        <div class="bgbg">
                            <div class="img_osn_lich">
                                <?php
                                if (isset($_SESSION['img'])) {
                                    echo '<img src="' . $_SESSION['img'] . '" alt="User Avatar">';
                                } else {
                                    echo '<img src="img/ava21.png" alt="Default Avatar">';
                                }
                                ?>
                                <!-- <img src="img/i 9.png" alt="" width="160px"> -->
                            </div>
                            <div class="login_lich_pr">
                                <div class="nikname"><?php echo htmlspecialchars($_SESSION['user_login']); ?></div>
                            </div>
                            <div class="infa_lich_kab2">
                                <div class="infa_kab">
                                    <div class="icon_lic"><img src="/img/4546924 2.png" alt=""></div>
                                    <div class="maail"><?php echo $_SESSION['mail']; ?></div>
                                </div>
                                <div class="infa_kab">
                                    <div class="icon_lic"><img src="/img/16738903 2.png" alt=""></div>
                                    <div class="maail"><?php echo $_SESSION['tel']; ?></div>
                                </div>
                                <div class="infa_kab">
                                    <div class="icon_lic"><img src="/img/833593 2.png" alt=""></div>
                                    <div class="maail"><?php echo $_SESSION['time']; ?></div>
                                </div>
                            </div>
                        </div>
                            <div class="profile-card">
                                <!-- Блок смены пароля -->
                                <div id="changePassBlock" class="settings-card change-pass-card" style="display: none;">
                                    <h3 class="settings-card__title">Сменить пароль</h3>
                                    <form id="changePassForm" class="change-pass-form" action="vender/pass.php" method="post">
                                        <div class="input-group">
                                            <label class="input-group__label" for="current_password">Текущий пароль</label>
                                            <input class="input-group__field"
                                                type="password"
                                                id="current_password"
                                                name="current_password"
                                                required>
                                        </div>
                                        <div class="input-group">
                                            <label class="input-group__label" for="new_password">Новый пароль</label>
                                            <input class="input-group__field"
                                                type="password"
                                                id="new_password"
                                                name="new_password"
                                                required>
                                        </div>
                                        <div class="input-group">
                                            <label class="input-group__label" for="confirm_password">Подтвердите пароль</label>
                                            <input class="input-group__field"
                                                type="password"
                                                id="confirm_password"
                                                name="confirm_password"
                                                required>
                                        </div>
                                        <div id="passError" class="form-error">
                                            <?php
                                            if (!empty($_SESSION['pass_error'])) {
                                                echo '<span style="color:red;">'.htmlspecialchars($_SESSION['pass_error']).'</span>';
                                                unset($_SESSION['pass_error']);
                                            }
                                            if (!empty($_SESSION['pass_success'])) {
                                                echo '<span style="color:green;">'.htmlspecialchars($_SESSION['pass_success']).'</span>';
                                                unset($_SESSION['pass_success']);
                                            }
                                            ?>
                                        </div>
                                        <button type="submit" class="btn btn--pink btn--full">Сохранить</button>
                                        <button type="button" id="cancelChange" class="btn btn--ghost btn--full" style="margin-top:0.5em;">
                                            Отмена
                                        </button>
                                    </form>
                                </div>

                                <!-- Кнопки управления -->
                                <div class="knopkaka">
                                    <button id="changePassBtn" class="btn btn--pink btn--full">Изменить пароль</button>
                                    <form method="POST" action="vender/img_update.php" enctype="multipart/form-data">
                                    <!-- label с for, чтобы при клике открывалось окно выбора файла -->
                                    <!-- <label for="avatarka" class="btn btn--blue btn--full">Изменить аватарку</label> -->
                                    <!-- скрываем реальное поле, но оставляем его с нужным name -->
                                    <!-- <input 
                                        type="file" 
                                        name="avatarka" 
                                        id="avatarka" 
                                        accept="image/*" 
                                        style="display:none" 
                                        onchange="this.form.submit()"
                                    >
                                    </form> -->
                                    <!-- <button id="changeAvatarBtn" class="btn btn--blue btn--full">Изменить аватарку</button> -->
                                </div>
                            </div>
                    </div>
                    <div class="osn_lick_pr33">
                    <div class="osn_lich_pr3">
                        <div class="vse_naz_zak">
                            <div class="naz_zak">Автомобиль</div>
                            <div class="gfg">
                                <img src="/img/edit_icon_128873 2.png" height="20px" alt="">
                            </div>
                        </div>

                        <?php
                        // Подключаемся к базе данных
                        require_once('vender/connect.php');

                        // Получаем id_users из сессии
                        $id_users = $_SESSION['id_users'];

                        // Запрос на выборку автомобилей пользователя
                        $query = "SELECT * FROM auto WHERE id_users = ?";
                        $stmt = $connect->prepare($query);
                        $stmt->bind_param("i", $id_users);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Получаем все автомобили пользователя
                        $auto_list = $result->fetch_all(MYSQLI_ASSOC);

                        // Закрываем соединение
                        // $stmt->close();
                        // $connect->close();
                        ?>

                        <div class="vse_auto">
                            <?php if (!empty($auto_list)): ?>
                                <?php foreach ($auto_list as $index => $auto): ?>
                                    <div class="avto_lich" id="auto_<?php echo $auto['id_auto']; ?>">
                                    <div class="udal">
                                        <div class="text_naz"><?php echo htmlspecialchars($auto['nazvanie_auto']); ?></div>
                                        <div class="krestik" onclick="deleteAuto(<?php echo $auto['id_auto'] ?>)">x</div>
                                    </div>
                                    <div class="udal">
                                        <div class="text_naz2">Год</div>
                                        <div class="krestik"><?php echo htmlspecialchars($auto['god']); ?></div>
                                    </div>
                                    <div class="udal">
                                        <div class="text_naz2">Коробка</div>
                                        <div class="krestik"><?php echo htmlspecialchars($auto['korobka']); ?></div>
                                    </div>
                                    <div class="udal">
                                        <div class="text_naz2">Мощность</div>
                                        <div class="krestik"><?php echo htmlspecialchars($auto['moch']); ?> л.с</div>
                                    </div>
                                    <div class="udal">
                                        <div class="text_naz2">Объем</div>
                                        <div class="krestik"><?php echo htmlspecialchars($auto['obem']); ?> куб</div>
                                    </div>
                                    <div class="udal">
                                        <div class="text_naz2">Категория</div>
                                        <div class="krestik"><?php echo htmlspecialchars($auto['kategoria']); ?></div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Данные об автомобилях отсутствуют.</p>
                            <?php endif; ?>
                            </div>
                        </div>


                        <?php
                        // Подключаемся к базе данных
                        require_once('vender/connect.php');

                        // Запускаем сессию, если ещё не запущена
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }

                        // Получаем id_users из сессии
                        $id_users = $_SESSION['id_users'] ?? null;

                        // Проверка: если пользователь не авторизован
                        if (!$id_users) {
                            die("Ошибка: пользователь не авторизован.");
                        }

                        // Запрос на выборку автомобилей пользователя с названиями
                        $query = "
                            SELECT 
                                zapis_uslug.*,
                                auto.nazvanie_auto,
                                auto.god,
                                auto.korobka,
                                auto.moch,
                                auto.obem,
                                auto.kategoria,
                                uslugi.nazvanie AS uslugi_name,
                                uslugi.price   AS price,
                                status.name    AS status_name
                            FROM 
                                zapis_uslug
                            JOIN 
                                auto   ON zapis_uslug.id_auto   = auto.id_auto
                            JOIN 
                                uslugi ON zapis_uslug.id_uslugi = uslugi.id_uslugi
                            JOIN
                                status ON zapis_uslug.id_status = status.id_status
                            WHERE 
                                zapis_uslug.id_users = ?
                        ";

                        $stmt = $connect->prepare($query);
                        $stmt->bind_param("i", $id_users);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Получаем все записи в виде ассоциативного массива
                        $auto_list = $result->fetch_all(MYSQLI_ASSOC);

                        // Закрываем соединение
                        $stmt->close();
                        $connect->close();
                        ?>


                        <div class="osn_lich_pr3">
                            <div class="vse_naz_zak">
                                <div class="naz_zak">Заказ</div>
                                <!-- <img src="/img/edit_icon_128873 2.png" height="20px" alt=""> -->
                            </div>

                            <div class="vse_auto2">
                                <?php if (!empty($auto_list)): ?>
                                    <?php foreach ($auto_list as $index => $auto): ?>
                                        <div class="avto_lich2" id="auto_<?php echo $auto['id_auto']; ?>">
                                            <div class="udal">
                                                <div class="text_naz"><?php echo htmlspecialchars($auto['uslugi_name']); ?></div>
                                                <!-- <div class="krestik" onclick="deleteAuto(<?php echo $auto['id_zapis_uslug'] ?>)">x</div> -->
                                            </div>
                                            <div class="udal">
                                                <div class="text_naz2">Номер телефона</div>
                                                <br>
                                                <div class="krestik"><?php echo htmlspecialchars($auto['nomer_tel']); ?></div>
                                            </div>
                                            <div class="udal">
                                                <div class="text_naz2">Ваш автомобиль</div>
                                                <br>
                                                <div class="krestik"><?php echo htmlspecialchars($auto['nazvanie_auto']); ?></div>
                                            </div>
                                            <div class="udal">
                                                <div class="text_naz2">Дата услуги</div>
                                                <br>
                                                <div class="krestik"><?php echo htmlspecialchars($auto['data']); ?></div>
                                            </div>
                                            <div class="udal">
                                                <div class="text_naz2">Стоимость услуги</div>
                                                <br>
                                                <div class="krestik">
                                                    <?php echo htmlspecialchars($auto['price']); ?> ₽
                                                </div>
                                            </div>
                                            <div class="udal">
                                                <div class="text_naz2">Статус</div>
                                                <br>
                                                <div class="krestik" style="color: green;"><?php echo htmlspecialchars($auto['status_name']); ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Данные о записях нет.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                
                        
            </div>
                
            <!-- <div class="osnova_kab">
                <div class="l_kabinet">
                    <h2>Личный кабинет</h2>
                    <div class="l_kabint_vnutr">
                        <div class="l_kab_ava"></div>
                        <div class="l_kab_text">
                            <div class="nikname"><?php echo htmlspecialchars($_SESSION['user_login']); ?></div>
                            <div class="data_regg">Дата регистрации: <span> <?php echo $_SESSION['time']; ?> </span></div>
                        </div>
                    </div>
                    <button class="l_cmen">Сменить пароль</button>
                </div>

                <div class="l_infa">
                    <div class="l_infa_vnut">
                        <h2>Информация</h2>
                        <div class="l_infa_email">
                            <div class="l_infa_email_vnut"><span>Email</span><b><?php echo $_SESSION['mail']; ?></b>
                            </div>
                            <div class="l_infa_email_vnut2">Изменить</div>
                        </div>
                        <div class="l_infa_email">
                            <div class="l_infa_email_vnut"><span>Номер телефона</span><b><?php echo $_SESSION['tel']; ?></b></div>
                            <div class="l_infa_email_vnut2">Изменить</div>
                        </div>
                        <div class="l_infa_email">
                            <div class="l_infa_email_vnut"><span>Изменить аватарку</span><b><label for=""></label></b></div>
                            <div class="l_infa_email_vnut2">Изменить</div>
                        </div>
                    </div>
                </div>

                
            </div>
            
            <div class="li_zakazi">
                <div class="li_kaz">
                    <h2>Мои заказы</h2>
                    <div class="li_kaz_da">
                        <div class="net_zakazov">
                            Нет заказов
                        </div>
                    </div>
                </div>
            </div>

            <div class="li_zakazi">
                <div class="li_kaz">
                    <h2>Автомобиль</h2>
                    <div class="li_kaz_da">
                        <div class="li_kaz_car">
                            <div class="li_kaz_naz">
                                <div class="lada_gran">Lada Granta</div>
                                <div class="krestik">&#x2716;</div>
                            </div>
                            <div class="li_kaz_naz_infa">Год проиизводства <span>2013</span></div>
                            <div class="li_kaz_naz_infa">Двигатель<span>Бензиновый</span></div>
                            <div class="li_kaz_naz_infa">Коробка<span>автомат</span></div>
                            <div class="li_kaz_naz_infa">Категория <span>В</span></div>
                            <div class="li_kaz_naz_infa">Мощность <span>98 л.с</span></div>
                            <div class="li_kaz_naz_infa">Руль<span>Левый</span></div>
                            <div class="li_kaz_naz_infa">Обьем <span>1596 куб.см</span></div>
                        </div>
                        
                    </div>
                    <div class="but_li_kaz">
                        <button>Добавить машину</button>
                    </div>
                </div>
            </div> -->


            
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