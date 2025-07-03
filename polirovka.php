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
        <h2 class="h2_moika">Услуги полировки</h2>
        <div class="previ">
            <div class="prev_vnut">
                <div class="chast2" style= "background-image: url('/img/i 29.png')" object-fit: cover;  >
                    <div class="overlay4"></div>
                    <span class="ff">13</span>
                <div class="text_chast_m">Идеальная полировка авто без переплат!</div>
                </div>
            </div>
        </div>

        <!-- <form action="">
            <div class="previ2">
                <div class="previ4_vnut">
                    <div class="h2_prev2">Виды полировок</div>
                    <div class="data_text">
                        <div class="pon4">
                            <div class="pon4_h2">Полировка фар</div>
                            <div class="pon4_img"><img src="/img/polirovka-far-0.jpg" alt=""></div>
                            <div class="pon4_text">Это услуга, направленная на восстановление прозрачности и блеска фар, устранение потускнения и царапин.(1)</div>
                        </div>
                        <div class="pon4">
                            <div class="pon4_h2">Полировка фар</div>
                            <div class="pon4_img"><img src="/img/2.jpg" alt=""></div>
                            <div class="pon4_text">Наша услуга по полировке дисков автомобиля направлена на восстановление их первозданного блеска и устранение загрязнений. (2)</div>
                        </div>
                        <div class="pon4">
                            <div class="pon4_h2">Полировка фар</div>
                            <div class="pon4_img"><img src="/img/polirovka-dveri-3.jpg" alt=""></div>
                            <div class="pon4_text">Услуга полировки стекол автомобиля направлена на устранение царапин и потускнения. (3)</div>
                        </div>
                        <div class="pon4">
                            <div class="pon4_h2">Полировка фар</div>
                            <div class="pon4_img"><img src="/img/polir.jpg" alt=""></div>
                            <div class="pon4_text">Наша абразивная полировка кузова автомобиля эффективно удаляет дефекты и восстанавливает его первоначальный блеск.(4)</div>
                        </div>
                        <div class="pon4">
                            <div class="pon4_h2">Полировка фар</div>
                            <div class="pon4_img"><img src="/img/abrazivnaya-polirovka-3.jpg" alt=""></div>
                            <div class="pon4_text">Это услуга, удаляет с автомобиля  кузова мелкие царапины, потертости и следы грязи. (5)</div>
                        </div>
                        <div class="pon4">
                            <div class="pon4_h2">Полировка фар</div>
                            <div class="pon4_img"><img src="/img/polirovka-plenki-1.jpg" alt=""></div>
                            <div class="pon4_text">Мы предлагаем полировку пленки на авто, которая восстанавливает её яркость и защищает от повреждений. (6)</div>
                        </div>
                        <div class="pon4">
                            <div class="pon4_h2">Полировка фар</div>
                            <div class="pon4_img"><img src="/img/polirovka-bampera.jpg" alt=""></div>
                            <div class="pon4_text">Это услуга, направленная на восстановление идеальной поверхности бампера, устранение царапин и потускнения. (7)</div>
                        </div>
                        <div class="pon4">
                            <div class="pon4_h2">Полировка фар</div>
                            <div class="pon4_img"><img src="/img/images.jpg" alt=""></div>
                            <div class="pon4_text">Это услуга, предназначенная для полировки зеркал, восстанавливающая их блеск и устраняющая мелкие дефекты. (8)</div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- 
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
            </div> -->

            <!-- <div class="previ2">
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
                        </select> -->
                        <!-- <div class="pon2">Стандарт <br> от 400р.</div> -->
                    <!-- </div>
                </div>
            </div> -->


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
            </div>
        </form> -->
        
        

        <div class="vse_polirovka">


            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/polirovka-far-0.jpg" alt="">
                </div>
                <div class="text_dla">
                    <h2>Полировка фар автомобиля</h2>
                    <span  class="ff">Полировка фар автомобиля</span>
                    <span class="span_number" style="display:none;">4</span>
                    <div class="text_moika">
                        <div class="onetx">это услуга, направленная на восстановление прозрачности и блеска фар, устранение потускнения и царапин. Мы используем профессиональное оборудование и качественные материалы для достижения идеального результата.</div>
                        <div class="chenik">4555 р.</div>                   
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/2.jpg" alt="">
                </div>
                <div class="text_dla">
                    <h2>Полировка дисков автомобиля</h2>
                    <span  class="ff">Полировка дисков автомобиля</span>
                    <span class="span_number" style="display:none;">5</span>
                    <div class="text_moika">
                        <div class="onetx">Наша услуга по полировке дисков автомобиля направлена на восстановление их первозданного блеска и устранение загрязнений. Мы применяем профессиональное оборудование и высококачественные материалы, чтобы достичь безупречного результата.</div>
                        <div class="chenik">2000 р.</div>                   
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/polirovka-dveri-3.jpg" alt="">
                </div>
                <div class="text_dla">
                    <h2>Полировка двери автомобиля</h2>
                    <span  class="ff">Полировка двери автомобиля</span>
                    <span class="span_number" style="display:none;">6</span>
                    <div class="text_moika">
                        <div class="onetx">Услуга полировки стекол автомобиля направлена на устранение царапин и потускнения. С применением профессионального оборудования и качественных материалов мы обеспечиваем кристальную прозрачность и безопасность ваших стекол.</div>
                        <div class="chenik">3000 р.</div>                   
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/polir.jpg" alt="">
                </div>
                <div class="text_dla">
                    <h2>Полировка стекол автомобиля</h2>
                    <span  class="ff">Полировка стекол автомобиля</span>
                    <span class="span_number" style="display:none;">7</span>
                    <div class="text_moika">
                        <div class="onetx">Наша абразивная полировка кузова автомобиля эффективно удаляет дефекты и восстанавливает его первоначальный блеск. Мы используем специализированное оборудование и высококачественные материалы для достижения идеального результата.</div>
                        <div class="chenik">2000 р.</div>                   
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/abrazivnaya-polirovka-3.jpg" alt="">
                </div>
                <div class="text_dla">
                    <h2>Абразивная полировка кузова</h2>
                    <span  class="ff">Абразивная полировка кузова</span>
                    <span class="span_number" style="display:none;">8</span>
                    <div class="text_moika">
                        <div class="onetx">Эта услуга, удаляет с автомобиля  кузова мелкие царапины, потертости и следы грязи. Помимо всего прочего, данный вид полировки придает ЛКП автомобиля первоначальный яркий вид и блеск и делает ее шикарной как новой.</div>
                        <div class="chenik">3000 р.</div>                   
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/polirovka-plenki-1.jpg" alt="">
                </div>
                <div class="text_dla">
                    <h2>Полировка пленки на авто</h2>
                    <span  class="ff">Полировка пленки на авто</span>
                    <span class="span_number" style="display:none;">9</span>
                    <div class="text_moika">
                        <div class="onetx">Мы предлагаем полировку пленки на авто, которая восстанавливает её яркость и защищает от повреждений. С помощью профессионального оборудования и качественных материалов мы добиваемся отличного результата и долговечности покрытия. </div>
                        <div class="chenik">4000 р.</div>                   
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/polirovka-bampera.jpg" alt="">
                </div>
                <div class="text_dla">
                    <h2>Полировка бампера</h2>
                    <span  class="ff">Полировка бампера</span>
                    <span class="span_number" style="display:none;">10</span>
                    <div class="text_moika">
                        <div class="onetx">Это услуга, направленная на восстановление идеальной поверхности бампера, устранение царапин и потускнения. Мы применяем профессиональное оборудование и высококачественные материалы, чтобы достичь безупречного результата.</div>
                        <div class="chenik">2000 р.</div>                   
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/images.jpg" alt="">
                </div>
                <div class="text_dla">
                    <h2>Полировка зеркал</h2>
                    <span  class="ff">Полировка зеркал</span>
                    <span class="span_number" style="display:none;">11</span>
                    <div class="text_moika">
                        <div class="onetx">Это услуга, предназначенная для полировки зеркал, восстанавливающая их блеск и устраняющая мелкие дефекты. Мы используем специализированное оборудование и лучшие материалы для достижения превосходного качества и долговечности.</div>
                        <div class="chenik">4000 р.</div>                   
                    </div>
                </div>
            </div>

            <!-- <div class="chast_polirovka">
                <img src="/img/polirovka-far-0.jpg" alt="" height="200px">
                <div class="p_polirovka">Полировка фар автомобиля</div>
                <span class="ff">4</span>
                <div class="text_polirovka">
                    это услуга, направленная на восстановление прозрачности и блеска фар, устранение потускнения и царапин. Мы используем профессиональное оборудование и качественные материалы для достижения идеального результата. (1)
                </div>
                <div class="but_pol">
                    <button >Записаться</button>
                </div>
            </div> -->
            <!-- <div class="chast_polirovka">
                <img src="/img/2.jpg" alt="" height="200px">
                <div class="p_polirovka">Полировка дисков автомобиля</div>
                <span class="ff">5</span>
                <div class="text_polirovka">
                    Наша услуга по полировке дисков автомобиля направлена на восстановление их первозданного блеска и устранение загрязнений. Мы применяем профессиональное оборудование и высококачественные материалы, чтобы достичь безупречного результата.(2)
                </div>
                <div class="but_pol">
                    <button>Записаться</button>
                </div>
            </div>
            <div class="chast_polirovka">
                <img src="/img/polirovka-dveri-3.jpg" alt="" height="200px">
                <div class="p_polirovka">Полировка двери автомобиля</div>
                <span class="ff">6</span>
                <div class="text_polirovka">
                    Услуга полировки стекол автомобиля направлена на устранение царапин и потускнения. С применением профессионального оборудования и качественных материалов мы обеспечиваем кристальную прозрачность и безопасность ваших стекол.(3)
                </div>
                <div class="but_pol">
                    <button>Записаться</button>
                </div>
            </div>
            <div class="chast_polirovka">
                <img src="/img/polir.jpg" alt="" height="200px">
                <div class="p_polirovka">Полировка стекол автомобиля</div>
                <span class="ff">7</span>
                <div class="text_polirovka">
                    Наша абразивная полировка кузова автомобиля эффективно удаляет дефекты и восстанавливает его первоначальный блеск. Мы используем специализированное оборудование и высококачественные материалы для достижения идеального результата.(4)
                </div>
                <div class="but_pol">
                    <button>Записаться</button>
                </div>
            </div>
            <div class="chast_polirovka">
                <img src="/img/abrazivnaya-polirovka-3.jpg" alt="" height="200px">
                <div class="p_polirovka">Абразивная полировка кузова</div>
                <span class="ff">8</span>
                <div class="text_polirovka">
                    это услуга, удаляет с автомобиля  кузова мелкие царапины, потертости и следы грязи. Помимо всего прочего, данный вид полировки придает ЛКП автомобиля первоначальный яркий вид и блеск и делает ее шикарной как новой.(5)
                </div>
                <div class="but_pol">
                    <button>Записаться</button>
                </div>
            </div>
            <div class="chast_polirovka">
                <img src="/img/polirovka-plenki-1.jpg" alt="" height="200px">
                <div class="p_polirovka">Полировка пленки на авто</div>
                <span class="ff">9</span>
                <div class="text_polirovka">
                    Мы предлагаем полировку пленки на авто, которая восстанавливает её яркость и защищает от повреждений. С помощью профессионального оборудования и качественных материалов мы добиваемся отличного результата и долговечности покрытия. (6)
                </div>
                <div class="but_pol">
                    <button>Записаться</button>
                </div>
            </div>
            <div class="chast_polirovka">
                <img src="/img/polirovka-bampera.jpg" alt="" height="200px">
                <div class="p_polirovka">Полировка бампера</div>
                <span class="ff">10</span>
                <div class="text_polirovka">
                    Это услуга, направленная на восстановление идеальной поверхности бампера, устранение царапин и потускнения. Мы применяем профессиональное оборудование и высококачественные материалы, чтобы достичь безупречного результата. (7)
                </div>
                <div class="but_pol">
                    <button>Записаться</button>
                </div>
            </div>
            <div class="chast_polirovka">
                <img src="/img/images.jpg" alt="" height="200px">
                <div class="p_polirovka">Полировка зеркал</div>
                <span class="ff">11</span>
                <div class="text_polirovka">
                    Это услуга, предназначенная для полировки зеркал, восстанавливающая их блеск и устраняющая мелкие дефекты. Мы используем специализированное оборудование и лучшие материалы для достижения превосходного качества и долговечности. (8)
                </div>
                <div class="but_pol">
                    <button>Записаться</button>
                </div>
            </div> -->
        </div>



        <div class="plus_polirovki" >
                <h2 class="h2_plus">Преимущества полировки</h2>
                <div class="text_vnut_plus">
                    <div class="text_vnut_plus_class">
                        <div class="oval"><img src="/img/12.png" width="50px" alt=""></div>
                        <h2>Сроки</h2>
                        <div class="text_class_plus">
                            Строгое соблюдение установленных сроков проведения работ.
                        </div>
                    </div>
                    <div class="text_vnut_plus_class">
                        <div class="oval"><img src="/img/1234.png" width="50px" alt=""></div>
                        <h2>Гарантии</h2>
                        <div class="text_class_plus">
                            Предоставление гарантийного обслуживания после осуществления ремонта.
                        </div>
                    </div>
                    <div class="text_vnut_plus_class">
                        <div class="oval"><img src="/img/111.png" width="50px" alt=""></div>
                        <h2>Цены</h2>
                        <div class="text_class_plus">
                            Доступные цены на весь перечень услуг.
                        </div>
                    </div> 
                </div>
        </div>

        <div class="voprosi">
            <h2 class="h2_polirovka">Часто задаваемые вопросы</h2>
            <details>
                <summary>Сколько раз можно выполнить полировку кузова ?</summary>
                <article>
                    <p>Глубоко, с применением абразивных паст — до 3-4 раз за весь срок эксплуатации. Поверхностная полировка выполняется без ограничений. Водитель сам решает, как часто полировать кузов, но чаще раза в 6 месяцев это делать не имеет смысла.
                    </p>
                </article>
            </details>
            <details>
                <summary>Стоит ли покрывать кузов защитным составом после полировки ?</summary>
                <article>
                    <p> Мы рекомендуем нанести защитное покрытие на кузов автомобиля (жидкое стекло или керамику), чтобы защитить ЛКП от негативного воздействия окружающей среды.
                    </p>
                </article>
            </details>
            <details>
                <summary>Все ли царапины уйдут после полировки ?</summary>
                <article>
                    <p>Сезонная полировка кузова уберет половину глубоких царапин и практически все мелкие.
                    </p>
                </article>
            </details>
            <details>
                <summary>Сколько раз можно выполнить полировку кузова ?</summary>
                <article>
                    <p>Глубоко, с применением абразивных паст — до 3-4 раз за весь срок эксплуатации. Поверхностная полировка выполняется без ограничений. Водитель сам решает, как часто полировать кузов, но чаще раза в 6 месяцев это делать не имеет смысла.
                    </p>
                </article>
            </details>
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
    <script src="/js/polirovkajs.js"></script>
    <script src="/js/jsmoila.js"></script>
</body>
</html>