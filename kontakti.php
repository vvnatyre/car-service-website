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
        <div class="kon_foto">
            <div class="overlay12"></div>
            <div class="text_konn_foto">
                <div class="konn">Контакты</div>
            </div>
        </div>

        <div class="kontact">
            <div class="cocet">
                <div class="my">Мы в соц сетях</div>
                <div class="my2">Вы всегда можете связаться с нами через <br> соцсети Вконтакте и Телеграмм</div>
                <div class="cvazi2">
                    <div class="vk">
                        <a href="vk.ru"><a href="https://vk.com/club230665758" target="_blank"><img src="/img/3670055 1.png" alt=""></a></a>
                    </div>
                    <div class="tg">
                        <a href="telegram.com"><a href="https://t.me/avtoprosrp" target="_blank"><img src="/img/2111646 1.png" alt=""></a></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="ikonki_kon">
            <div class="on_kon">
                <div class="ivonka_kon">
                    <img src="/img/503080 1.png" alt="">
                </div>
                <div class="text1_kon">Адрес</div>
                <div class="text2_kon">г. Сарапул, ул Дубровская 23</div>
            </div>
            <div class="on_kon">
                <div class="ivonka_kon">
                        <img src="/img/159832 1.png" alt="">
                    </div>
                    <div class="text1_kon">Телефон</div>
                    <div class="text2_kon">8 (34147) 2-03-30</div>
                    <div class="text3_kon">8 (34147) 2-03-30</div>
                </div>
            <div class="on_kon">
            <div class="ivonka_kon">
                    <img src="/img/5987346 1.png" alt="">
                </div>
                <div class="text1_kon">Почта</div>
                <div class="text2_kon">exemp@yandex.ru</div>
            </div>
        </div>
        <div class="map">
            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A3ed26eeefaa75cc59e2dfa70fc7b1ea9ee790a01608b5a2e32eb5c74cd139913&amp;source=constructor" width="100%" height="550" frameborder="0">
            </iframe>
        </div>
    </main>

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
</body>
</html>