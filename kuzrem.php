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
            <h2 class="h2_moika">Услуги окраски</h2>
            <div class="previ">
                <div class="prev_vnut">
                    <div class="chast2" style= "background-image: url('/img/image 2.png')" object-fit: cover;  >
                        <div class="overlay4"></div>
                        <span class="ff">13</span>
                    <div class="text_chast_m">Качественный кузовной ремонт с гарантией результата</div>
                    </div>
                </div>
            </div>
            <div class="vse_polirovka">

                <div class="chast_moika">
                    <div class="img_moika">
                        <img src="/img/333.png" alt="">
                    </div>
                    <div class="text_dla">
                        <h2>Ремонт царапин</h2>
                        <span  class="ff">Ремонт царапин</span>
                        <span class="span_number" style="display:none;">20</span>
                        <div class="text_moika">
                            <div class="onetx">Это услуга ремонта царапин лакокрасочного покрытия, направленная на устранение мелких и глубоких повреждений поверхности кузова. Мы используем профессиональное оборудование и качественные материалы для достижения идеального результата.</div>
                            <div class="chenik">4000 р.</div>                   
                        </div>
                    </div>
                </div>

                <div class="chast_moika">
                    <div class="img_moika">
                        <img src="/img/3231.png" alt="">
                    </div>
                    <div class="text_dla">
                        <h2>Ремонт порогов</h2>
                        <span  class="ff">Ремонт порогов</span>
                        <span class="span_number" style="display:none;">21</span>
                        <div class="text_moika">
                            <div class="onetx">Это услуга ремонта порогов автомобиля, направленная на восстановление геометрии, удаление коррозии и выравнивание металла. Мы используем профессиональное оборудование и качественные материалы для достижения идеального результата.</div>
                            <div class="chenik">10000 р.</div>                   
                        </div>
                    </div>
                </div>

                <div class="chast_moika">
                    <div class="img_moika">
                        <img src="/img/3214.png" alt="">
                    </div>
                    <div class="text_dla">
                        <h2>Реставрация</h2>
                        <span  class="ff">Реставрация</span>
                        <span class="span_number" style="display:none;">22</span>
                        <div class="text_moika">
                            <div class="onetx">Это услуга реставрации кузова и элементов интерьера, направленная на восстановление оригинального внешнего вида и сохранение функциональности. Мы используем профессиональное оборудование и качественные материалы для достижения идеального результата.</div>
                            <div class="chenik">50000 р.</div>                   
                        </div>
                    </div>
                </div>
            </div>

            <div class="main_kiz_rem">

               <!-- <div class="head_kuz">
                    <div class="overlay5"></div>
                    <div class="text_head_kuz">Кузовной ремонт</div>
               </div> -->

               <div class="preim_kiz_rem">
                    <div class="osn_kir_rem">
                        <div class="line_kiz">
                            <hr>
                        </div>
                        <div class="text_osn_kir_rem">
                            Пожизненная <br> гарантия 
                        </div>
                    </div>
                    <div class="osn_kir_rem">
                        <div class="line_kiz">
                            <hr>
                        </div>
                        <div class="text_osn_kir_rem">
                            Эксперты <br> кузовного ремонта  
                        </div>
                    </div>
                    <div class="osn_kir_rem">
                        <div class="line_kiz">
                            <hr>
                        </div>
                        <div class="text_osn_kir_rem">
                            Своя лаборатория <br> цветоподбора 
                        </div>
                    </div>
                    <div class="osn_kir_rem">
                        <div class="line_kiz">
                            <hr>
                        </div>
                        <div class="text_osn_kir_rem">
                            Бесплатный  <br> эвакуатор 
                        </div>
                    </div>
               </div> 

               <div class="zapiz_kiz_rem">
                    <div class="kart_kiz_rem" style="background-image: url(/img/i\ 2.png);">
                        <div class="overlay6"></div>
                        <div class="text_kartik">Ремонт царапин</div>
                        <span class="ff">20</span>
                    </div>
                    <div class="kart_kiz_rem" style="background-image: url(/img/image\ 3.png);">
                        <div class="overlay6"></div>
                        <div class="text_kartik">Ремонт порогов</div>
                        <span class="ff">21</span>
                    </div>
                    <div class="kart_kiz_rem" style="background-image: url(/img/image\ 4.png);">
                        <div class="overlay6"></div>
                        <div class="text_kartik">Реставрация</div>
                        <span class="ff">22</span>
                    </div>
               </div>

               <div class="slider" id="slider">
                    <div class="slides" id="slides">
                        <img src="img/download 5.png" alt="Image 1">
                        <img src="img/download 8 (1).png" alt="Image 2">
                        <img src="img/download 9.png" alt="Image 3">
                        <img src="img/download 10.png" alt="Image 4">
                        <img src="img/download 7.png" alt="Image 5">
                        <img src="img/download 6.png" alt="Image 6">
                        <img src="img/ldui2aq7jglplbxmgnpjfws0w14qni1o 1.png" alt="Image 7">
                        <img src="img/756582316469589 1.png" alt="Image 8">
                        <img src="img/3d49627547ecffefea2d48272fd3a1b4dd49acfd 1 (1).png" alt="Image 9">
                        <img src="img/i 14.png" alt="Image 10">
                    </div>
                </div>
               
                <h2 class="stoim">Стоимость работ</h2>
                <div class="hrhr">
                    <hr class="hr2">
                </div>

                <div class="raboti_chena">
                    <div class="one_chena">
                        <div class="cha">
                            <div class="text_1">Ремонт неглубоких царапин</div>
                            <div class="text_2">от 1 000 р.</div>
                        </div>
                        <div class="cha">
                            <div class="text_1">Ремонт внешних порогов</div>
                            <div class="text_2">от 9 000 р.</div>
                        </div>
                    </div>
                    <div class="one_chena">
                        <div class="cha">
                            <div class="text_1">Ремонт глубоких царапин</div>
                            <div class="text_2">от 2 000 р.</div>
                        </div>
                        <div class="cha">
                            <div class="text_1">Ремонт внутренних порогов</div>
                            <div class="text_2">от 5 000 р.</div>
                        </div>
                    </div>
                    <div class="one_chena">
                        <div class="cha">
                            <div class="text_1">Реставрация авто</div>
                            <div class="text_2">от 90 000 р.</div>
                        </div>
                        <div class="cha">
                            <div class="text_1">Реставрация части авто</div>
                            <div class="text_2">от 1 000 р.</div>
                        </div>
                    </div>
                </div>

                <h2 class="stoim">Пример работы</h2>
                <div class="hrhr">
                    <hr class="hr2">
                </div>

                <div class="wrap">
                    <span id="before" class="btn">До</span>
                    <span id="after" class="btn">После</span>
                    <div class="gallery">
                        <img src="/img/1484.jpg" alt="" class="img_wrap">
        
                        
                        <div class="gallery_resize">
                            <img src="/img/1480 1 (1).png" alt=""  class="img_wrap">
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>

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
    <script src="/js/kuzrem.js"></script>
    <script src="/js/jsmoila.js"></script>
</body>
</html>