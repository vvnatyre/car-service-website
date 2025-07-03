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
    <header>
        <div class="headglav">
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
                        <input type="text" placeholder="Телефон" id="modal-phone" name="telefon" required pattern="\d*" autocomplete="tel">
                        <input type="password" placeholder="Пароль" required name="pass">
                        <input type="password" placeholder="Подтверждение пароля" required name="password_second">
                        <label class="input-file">
                            <input type="file" name="img" accept="image/*">		
                            <span>Вставьте аватарку</span>
                        </label>
                        <button type="submit">Зарегистрироваться</button>
                        <p class="modal-p"><a href="#" id="toggle-link" >Войти</a></p>
                    </form>
                    
                </div>
            </div>
        </div>
        

    </header>
    <main>
        <div class="slideshow-container" style="background-image: url(/img/полировка.png);">
            <div class="dark_block">
                <a  class="prev" onclick="plusSlides(-1)"><</a>
                <div class="mySlides fade">
                    <div class="text">Полировка автомобиля</div>
                    <div class="text2">Полировка авто в Сарапуле от команды профессионалов. <br> Придадим блеск и эффективность кузову вашего авто за<br> один рабочий день, используя профессиональные<br> подходы и современные материалы.</div>
                    <div class="dva">
                        <a href="polirovka.php"><button>Подробнее</button></a>
                        <div class="cena_ot">от 1 400 р.</div>        
                    </div>
                </div>
    
                <div class="mySlides fade">
                    <div class="text">Автомойка автомобиля</div>
                    <div class="text2">Автомойка в Сарапуле от команды экспертов. Мы обеспечим вашему автомобилю безупречную чистоту и ухоженный вид всего  за один день, применяя современные технологии и качественные моющие средства. Доверьте нам заботу о вашем авто, и мы вернем  ему первозданный блеск и свежесть!</div>
                    <div class="dva">
                        <a href="moika.php"><button>Подробнее</button></a>
                        <div class="cena_ot">от 500 р.</div>        
                    </div>
                </div>
    
                <div class="mySlides fade">
                    <div class="text">Покраска автомобиля</div>
                    <div class="text2">Покраска автомобилей в Сарапуле от команды профессионалов! Мы предлагаем  высококачественные услуги по покраске, используя современные технологии и экологически чистые материалы. Наши эксперты обеспечат вашему автомобилю идеальное покрытие и защиту, а также вернут ему  привлекательный вид. Доверьте нам заботу о вашем авто, и мы сделаем его не только красивым, но и  долговечным!</div>
                    <div class="dva">
                        <a href="okraska.php"><button>Подробнее</button></a>
                        <div class="cena_ot">от 3 000 р.</div>        
                    </div>

                </div>
                <a  class="next" onclick="plusSlides(1)"> > </a>
                <div class="da">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                </div>
            </div>
        </div>

        <h2 class="kr_rabh2">Наши работы</h2>
        <div class="k_ragg">
            <div class="kr_raboti">
                <div class="dark_block2">
                    <div class="cart" style="background-image: url('/img/large_bd93ecad 1.png');">
                        <div class="overlay"></div>
                        <div class="teex">
                            <a href="moika.php"><button class="but_texx">Подробнее</button></a>
                        </div>
                        <div class="cart_text1">Двухфазная мойка</div>
                        <div class="cart_text2">от 700 р</div>
                    </div>
                </div>
                <div class="dark_block2">
                    <div class="cart" style="background-image: url('/img/diploma 1.png');">
                        <div class="overlay"></div>
                        <div class="teex">
                            <a href="polirovka.php"><button class="but_texx">Подробнее</button></a>
                        </div>
                        <div class="cart_text1">Полировка авто</div>
                        <div class="cart_text2">от 1 400 р</div>
                    </div>
                </div>
                <div class="dark_block2">
                    <div class="cart" style="background-image: url('/img/916efa1s-1920 1.png');">
                        <div class="overlay"></div>
                        <div class="teex">
                            <a href="okraska.php"><button class="but_texx">Подробнее</button></a>
                        </div>
                        <div class="cart_text1">Покраска багажника</div>
                        <div class="cart_text2">от 8 900 р</div>
                    </div>
                </div>
                <div class="dark_block2">
                    <div class="cart" style="background-image: url('/img/remont_i_pokraska_kapota 1.png');">
                        <div class="overlay"></div>
                        <div class="teex">
                            <a href="okraska.php"><button class="but_texx">Подробнее</button></a>
                        </div>
                        <div class="cart_text1">Покраска капота</div>
                        <div class="cart_text2">от 7 900 р</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- здесь, до формы, выводим флеш-сообщения -->
        <?php if(!empty($_SESSION['success'])): ?>
        <script>
        alert(<?= json_encode($_SESSION['success'], JSON_UNESCAPED_UNICODE) ?>);
        </script>
        <?php unset($_SESSION['success']); endif; ?>

        <?php if(!empty($_SESSION['error'])): ?>
        <script>
        alert(<?= json_encode($_SESSION['success'], JSON_UNESCAPED_UNICODE) ?>);
        </script>
        <?php unset($_SESSION['error']); endif; ?>

        <div class="forma_otp">
            <div class="forma_textt">
                <div class="zagolovok_for">Запись в автосервис</div>
                <div class="text_for">
                Свяжитесь с нами через нашу контактную форму, и мы свяжемся с вами в ближайшее время.
                </div>
                <form action="vender/zapis.php" method="post">
                <div class="inputs">
                    <input type="text" name="name"     placeholder="Ваше имя" required>
                    <input type="email" name="email"   placeholder="Ваша почта" required>
                </div>
                <textarea class="inputda" name="text" placeholder="Сообщение" required></textarea>
                <button class="ottt" type="submit">Отправить</button>
                </form>
            </div>
        </div>
        
        <div class="map">
            <div class="info_map">
                <div class="inmp_h">Приезжайте к нам:</div>
                <div class="inmp_p">
                    Адрес: <br>
                        <span>г. Сарапул, Дубровская 23</span>
                </div>
                <div class="inmp_p">
                    Контакты: <br>
                        <span>+ 7 (999) 123 23 32</span>
                </div>
                <div class="inmp_p">
                    Пн-Вс: <br>
                        <span>8:00 - 23:00</span>
                </div>
            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/inputmask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/addons/cleave-phone.ru.js"></script>
</body>
</html>