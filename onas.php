<?php
	require_once('vender/connect.php');
	session_start();
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
                        if (isset($_SESSION['user_login'])) {
                            echo "
                                <div class='nik'>
                                    <a href='#' class='profile-link' onclick='toggleDropdown()'>{$_SESSION['user_login']}</a>
                                    
                                    <div class='dropdown3' id='dropdown'>";
                            
                            // Если логин root — только админка и выход
                            if ($_SESSION['user_login'] === 'root') {
                                echo "<a href='root.php'>Админ панель</a>";
                            } else {
                                echo "<a href='lichniy.php'>Личный кабинет</a>";
                            }

                            echo "
                                        <a href='vender/logout.php'>Выход</a>
                                    </div>
                                </div>";
                        } else {
                            echo "<div class='nik'><a href='#' id='login-button'>Войти</a></div>";
                        }
                    ?>
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
        <div class="onas_foto">
            <div class="overlay11"></div>
            <div class="text_onas_foto">
                <div class="komp">О компании</div>
                <div class="sarap">«AUTO PRO» Сарапул</div>
            </div>
        </div>

        <div class="text_onas">
            <h2>Официальный дилер «AUTO PRO»</h2>
            <p>Компания «AUTO PRO» была основана в 2000 году в Сарапуле и с тех пор зарекомендовала себя как надежный игрок на рынке автозапчастей и технического обслуживания. С открытием магазина автозапчастей на ул. Удмуртской и универсальной станции технического обслуживания на ул. Лесозаводской, компания начала свой путь к успеху.
            </p>
            <p>
            В 2004 году «AUTO PRO» стала официальным дилером таких известных брендов, как HUMMER, OPEL, CHEVROLET и CADILLAC. Позже к этому списку добавились PEUGEOT и VOLVO. На сегодняшний день компания продолжает специализироваться на этих марках, предлагая своим клиентам высококачественное обслуживание и современное оборудование.
            </p>
            <p>
            Компания предоставляет сервисное обслуживание для всех видов автомобилей и сделает все в кратчаишие сроки.
            </p>
        </div>
        <div class="img_onas">
            <img src="/img/ft2.png" alt="">
        </div>
        <div class="text_onas">
            <p>Автосервис  «AUTO PRO» существует более 20 лет. За это время предприятие зарекомендовало себя как успешная и надежная компания.
            </p>
            <p>
            СТО «AUTO PRO» постоянно развивается, направляя свои силы на создание компании с высоким уровнем менеджмента и достойным уровнем сервиса.
            Мы поможем нашим клиентам получать только положительные эмоции от взаимодействия со своим автомобилем.
            </p>
            <p>
            На сегодняшний день основным направлением автосервиса являются техническое обслуживание, ремонт автомобилей отечественного и иностранного производства.
            </p>
            <p>
            «AUTO PRO» — это команда профессионалов, которая делает ваше авто надежным, а вашу жизнь — проще!
            </p>
        </div>
    </main>

    <footer>
        <!-- <div class="footer_main">
            <div class="logo_footer">
                <div class="logo">
                    <a href="index.php"><img src="./img/logo.png" width="130px" alt=""></a>
                </div>
                <div class="cvazi">
                    <div class="vk">
                        <a href="vk.ru"><img src="./img/vk-v2 1.png" ></a>
                    </div>
                    <div class="tg">
                        <a href="telegram.com"><img src="./img/Group.png" ></a>
                    </div>
                </div>
            </div>
            <div class="uslugi_footer">
                <h2>Услуги по ремонту</h2>
                <div class="link_footer">
                    <a href="kuzrem.php">Выравнивание вмятин</a>
                    <a href="kuzrem.php">Варка порогов</a>
                    <a href="kuzrem.php">Варка кузова</a>
                </div>
            </div>
            <div class="uslugi2_footer">
                <h2>Прочие услуги</h2>
                <div class="link_footer">
                    <a href="diagnostika.php">Диагностика</a>
                    <a href="polirovka.php">Полировка</a>
                    <a href="moika.php">Мойка</a>
                </div>
            </div>
            <div class="kontacti_footer">
                <h2>Контакты</h2>
                <p>Г. Сарапул, Дубровская 23</p>
                <p>+ 7 (999) 123 23 32</p>
                <p>Autopro77@yandex.ru</p>
            </div>
        </div> -->
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
</body>
</html>