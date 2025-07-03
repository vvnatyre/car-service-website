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
        <h2 class="h2_moika">Услуги кузовного ремонта</h2>
        <div class="previ">
            <div class="prev_vnut">
                <div class="chast2" style= "background-image: url('/img/i 32.png')" object-fit: cover;  >
                    <div class="overlay4"></div>
                    <span class="ff">13</span>
                <div class="text_chast_m">Выявим очаги ржавчины и проблемные зоны до дорогостоящего ремонта</div>
                </div>
            </div>
        </div>

        <div class="vse_polirovka">
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/597_17\ 1.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Комплексная диагностика</h2>
                    <span  class="ff">Комплексная диагностика</span>
                    <span class="span_number" style="display:none;">23</span>
                    <div class="text_moika">
                        <div class="onetx">Это услуга комплексной диагностики двигателя и электронных компонентов, системы кондиционирования и отопления, а также ходовой части. Мы используем современное оборудование для эффективного выявления неисправностей.</div>
                        <div class="chenik">4000 р.</div>                   
                    </div>
                </div>
            </div>

            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/597_17\ 1.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Диагностика двигателя и электронных компонентов</h2>
                    <span  class="ff">Диагностика двигателя и электронных компонентов</span>
                    <span class="span_number" style="display:none;">24</span>
                    <div class="text_moika">
                        <div class="onetx">Это услуга комплексной диагностики систем автомобиля, направленная на полную проверку и выявление дефектов. Мы используем профессиональное оборудование и точные методики для достижения идеального результата.</div>
                        <div class="chenik">5000 р.</div>                   
                    </div>
                </div>
            </div>
            
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/597_17\ 1.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Диагностика системы кондиционирования</h2>
                    <span  class="ff">Диагностика системы кондиционирования</span>
                    <span class="span_number" style="display:none;">25</span>
                    <div class="text_moika">
                        <div class="onetx">Это услуга диагностики двигателя и электронных компонентов, направленная на оценку состояния и выявление неисправностей. Мы используем профессиональное оборудование и методики для достижения идеального результата.</div>
                        <div class="chenik">7000 р.</div>                   
                    </div>
                </div>
            </div>

            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/597_17\ 1.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Диагностика системы отопления авто</h2>
                    <span  class="ff">Диагностика системы отопления авто</span>
                    <span class="span_number" style="display:none;">26</span>
                    <div class="text_moika">
                        <div class="onetx">Это услуга диагностики системы кондиционирования, направленная на оперативную проверку эффективности охлаждения и выявление утечек. Мы используем профессиональное оборудование и методики для достижения идеального результата.</div>
                        <div class="chenik">5000 р.</div>                   
                    </div>
                </div>
            </div>

            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/597_17\ 1.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Диагностика двигателя и электронных компонентов</h2>
                    <span  class="ff">Диагностика двигателя и электронных компонентов</span>
                    <span class="span_number" style="display:none;">27</span>
                    <div class="text_moika">
                        <div class="onetx">Это услуга диагностики системы отопления авто, направленная на проверку эффективности обогрева и выявление неисправностей. Мы используем профессиональное оборудование и методики для достижения идеального результата.</div>
                        <div class="chenik">3000 р.</div>                   
                    </div>
                </div>
            </div>

            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/597_17\ 1.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Диагностика ходовой части</h2>
                    <span  class="ff">Диагностика ходовой части</span>
                    <span class="span_number" style="display:none;">28</span>
                    <div class="text_moika">
                        <div class="onetx">Это услуга диагностики ходовой части автомобиля, направленная на проверку состояния подвески и выявление износа. Мы используем профессиональное оборудование и методики для достижения идеального результата.</div>
                        <div class="chenik">8000 р.</div>                   
                    </div>
                </div>
            </div>
        </div>


        <!-- <div class="zaposi_diagnostiki">
            <div class="zapis_dia" style="background-image: url(/img/597_17\ 1.png)"  object-fit: cover;>
                <div class="overlay10"></div>
                <div class="vn_zapis">
                    <div class="text_zaposi">Комплексная диагностика</div>
                    <span class="ff">23</span>
                    <div class="knopka_zapisi">
                        <button>Записаться</button>
                    </div>
                </div>

            </div>
            <div class="zapis_dia" style="background-image: url(/img/i\ 3.png)"  object-fit: cover;>
                <div class="overlay10"></div>
                <div class="vn_zapis">
                    <div class="text_zaposi">Диагностика двигателя и <br> электронных компонентов</div>
                    <span class="ff">24</span>
                    <div class="knopka_zapisi">
                        <button>Записаться</button>
                    </div>
                </div>
            </div>
            <div class="zapis_dia" style="background-image: url(/img/i\ 4.png)"  object-fit: cover;>
                <div class="overlay10"></div>
                <div class="vn_zapis">
                    <div class="text_zaposi">Диагностика системы <br> кондиционирования</div>
                    <span class="ff">25</span>
                    <div class="knopka_zapisi">
                        <button>Записаться</button>
                    </div>
                </div>
            </div>
            <div class="zapis_dia" style="background-image: url(/img/i\ 5.png)"  object-fit: cover;>
                <div class="overlay10"></div>
                <div class="vn_zapis">
                    <div class="text_zaposi">Диагностика системы <br> отопления авто</div>
                    <span class="ff">26</span>
                    <div class="knopka_zapisi">
                        <button>Записаться</button>
                    </div>
                </div>
            </div>
            <div class="zapis_dia" style="background-image: url(/img/i\ 6.png)"  object-fit: cover;>
                <div class="overlay10"></div>
                <div class="vn_zapis">
                    <div class="text_zaposi">Диагностика двигателя и <br> электронных компонентов</div>
                    <span class="ff">27</span>
                    <div class="knopka_zapisi">
                        <button>Записаться</button>
                    </div>
                </div>
            </div>
            <div class="zapis_dia" style="background-image: url(/img/i\ 7.png)"  object-fit: cover;>
                <div class="overlay10"></div>
                <div class="vn_zapis">
                    <div class="text_zaposi">Диагностика ходовой части</div>
                    <span class="ff">28</span>
                    <div class="knopka_zapisi">
                        <button>Записаться</button>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="zagol_h22">
            <p>Фотогалерея</p>
        </div>

        <div class="slider" id="slider">
            <div class="slides2" id="slides">
                <img src="img/i 8.png" alt="Image 1">
                <img src="img/i 9.png" alt="Image 2">
                <img src="img/i 10.png" alt="Image 3">
                <img src="img/i 11.png" alt="Image 4">
                <img src="img/i 12.png" alt="Image 5">
                <img src="img/i 16.png" alt="Image 6">
                <img src="img/i 17.png" alt="Image 7">
                <img src="img/i 18.png" alt="Image 8">
                <img src="img/i 19.png" alt="Image 9">
                <img src="img/i 20.png" alt="Image 10">
                <img src="img/i 21.png" alt="Image 11">
            </div>

        </div>

        <!-- <div class="zagol_h22">
            <p>Диагностика авто осциллографом</p>
        </div> -->
        
        <!-- <div class="video_diag">
            <iframe width="920" height="405" src="https://rutube.ru/play/embed/26c25bd43b5a66973480cbde0b6ba317/" frameBorder="0" allow="clipboard-write; autoplay" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
        </div> -->

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
    <script src="/js/diagnostikjs.js"></script>
    <script src="/js/jsmoila.js"></script>
</body>
</html>