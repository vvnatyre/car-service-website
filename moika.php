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
    <?php
        $id_users = false;
        if (isset($_SESSION['id_users'])) {
        $id_users = $_SESSION['id_users'];
        }
        
        if ($id_users) {
            // Запрос на выборку автомобилей пользователя
            $query = "SELECT * FROM auto WHERE id_users = ?";
            $stmt = $connect->prepare($query);
            $stmt->bind_param("i", $id_users);                                                          
            $stmt->execute();
            $result = $stmt->get_result();

            // Получаем все автомобили пользователя
            $auto_list = $result->fetch_all(MYSQLI_ASSOC);

            // Закрываем соединение
            $stmt->close();
            $connect->close();
        }
    ?>
    <form action="vender/poluch.php" method="POST" class="form_moika">
        <div class="dark_block_modal"></div>
        <div class="form_white">
            <h2>Запись</h2>
            <input type="text" value="1" class="title_id" name="id_uslugi" style="display:none;">
            <input type="text" value="1"  class="title_input">
            <input type="text"  name="nomer_tel"  placeholder="Ваш номер телефона" class="title_input">
            <input type="date" name="data"  placeholder="Дата услуги" class="title_input">
            <select class="title_input" name="id_auto">
                <?php if (!empty($auto_list)): ?>
                    <?php foreach ($auto_list as $index => $auto): ?>
                        <option value='<?php echo $auto['id_auto']; ?>'><?php echo htmlspecialchars($auto['nazvanie_auto']); ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value=""><p>Данные об авто отсутствуют</p></option>
                <?php endif; ?>
            </select>
            <button>Записаться</button>
        </div>
    </form>
    <?php if (!empty($message)): ?>
        <div class="alert"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
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
                        <input type="file" name="img" accept="image/*">		
                        <span>Вставьте аватарку</span>
                    </label>
                    <button type="submit">Зарегистрироваться</button>
                    <p class="modal-p"><a href="#" id="toggle-link" >Войти</a></p>
                </form>
                
            </div>
        </div>
        

    </header>
    <main>
        <h2 class="h2_moika">
            Выберите тип мойки
        </h2>
        <!-- <div class="previ">
            <div class="prev_vnut">
                <div class="chast2" style= "background-image: url('/img/1651296828_34-sportishka-com-p-dlinnaya-mashina-mashini-krasivo-foto-37.jpg')" object-fit: cover;  >
                    <div class="overlay4"></div>
                    <span class="ff">13</span>
                <div class="text_chast_m">Качественная мойка авто по разумным ценам</div>
                </div>
            </div>
        </div> -->
        <!-- <form action="moika.php" method="POST" >
            <div class="previ2">
                <div class="previ2_vnut">
                    <div class="h2_prev2">Дата и время записи на услугу</div>
                    <div class="data_text">
                        <div class="pon">Понедельник</div>
                        <div class="pon">Вторник</div>
                        <div class="pon">Среда</div>
                        <div class="pon">Четверг</div>
                        <div class="pon">Пятница</div>
                        <div class="pon">Суббота</div>
                        <div class="pon">Воскресенье</div>
                    </div>
                    <div class="time_text">
                        <div class="pon">8:00</div>
                        <div class="pon">10:00</div>
                        <div class="pon">12:00</div>
                        <div class="pon">14:00</div>
                        <div class="pon">16:00</div>
                        <div class="pon">18:00</div>
                        <div class="pon">20:00</div>
                    </div>
                </div>
            </div> 
            
            <div class="previ2">
                <div class="previ3_vnut">
                    <div class="h2_prev2">Выберите тип мойки</div>
                    <div class="data_text">
                        <div class="pon2">Стандарт <br> от 400р.</div>
                        <div class="pon2">Люкс <br> от 700р</div>
                        <div class="pon2">Премиум<br> от 900р</div>
                    </div>
                </div>
            </div>

            <div class="previ2">
                <div class="previ3_vnut">
                    <div class="h2_prev2">Выберите авто</div>
                    <div class="data_text">
                        <select class="title_input" name="id_auto">
                            <?php if (!empty($auto_list)): ?>
                                <?php foreach ($auto_list as $index => $auto): ?>
                                    <option value='<?php echo $auto['id_auto']; ?>'><?php echo htmlspecialchars($auto['nazvanie_auto']); ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value=""><p>Данные об авто отсутствуют</p></option>
                            <?php endif; ?>
                        </select>
                        <!-- <div class="pon2">Стандарт <br> от 400р.</div> -->
                    </div>
                </div>
            </div>

            <!-- <div class="previ2">
                <div class="previ3_vnut">
                    <div class="h2_prev2">Ваши контактные данные</div>
                    <div class="data_text">
                        <input type="text"   name="nomer_tel"  placeholder="Ваш номер телефона" class="title_input" >
                    </div>
                </div>
            </div>
            <div class="but_moi">
                <button>Записаться</button>
            </div> -->
        <!-- </form>  -->
        
        <div class="vidi_moika">
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/107 1.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Cтандарт</h2>
                    <span class="ff">Cтандарт</span>
                    <span class="span_number" style="display:none;">1</span>
                    <div class="text_moika">
                        <div class="onetx">В стоимость стандартной мойки  включаются основные услуги: Внешняя мойка кузова автомобиля. Мытье колес и колесных арок. Протирка стекол. Уборка салона (собрать мусор). Мойка ковриков. Протирка чательно тряпкой.</div>
                        <div class="chenik">500 р.</div>
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/30258560048460298_ea8e 1.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Комфорт</h2>
                    <span  class="ff">Комфорт</span>
                    <span class="span_number" style="display:none;">2</span>
                    <div class="text_moika">
                        <div class="onetx">Комфортная мойка включает все услуги стандартного плана, а также дополнительные элементы:Полировка кузова для придания блеска. Чистка салона с  пылесосом. Мытье пластиковых  деталей. Нанесение  воска на кузов. </div>
                        <div class="chenik">700 р.</div>                   
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/image 1.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Люкс</h2>
                    <span class="ff">Люкс</span>
                    <span class="span_number" style="display:none;">3</span>
                    <div class="text_moika">
                        <div class="onetx"> Люкс мойка предлагает полный комплекс услуг, включая все из стандартной и комфортной мойки, плюс: Глубокая химчистка салона. Термозащита кузова. Уборка в труднодоступных местах. Нанесение защитного покрытия на лакокрасочное покрытие.</div>
                        <div class="chenik">1200 р.</div>
                    </div>
                </div>
                
            </div>
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
    <script src="/js/jsmoila.js"></script>
</body>
</html>