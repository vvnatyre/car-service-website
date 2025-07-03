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
                    <div class="chast2" style= "background-image: url('/img/Group 3265.png')" object-fit: cover;  >
                        <div class="overlay4"></div>
                        <span class="ff">13</span>
                    <div class="text_chast_m">Идеальная покраска кузова без переплат</div>
                    </div>
                </div>
            </div>

            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/download.jpg" style="border-radius:12px;" alt="">
                </div>
                <div class="text_dla">
                    <h2>Полная покраска</h2>
                    <span  class="ff">Полная покраска</span>
                    <span class="span_number" style="display:none;">12</span>
                    <div class="text_moika">
                        <div class="onetx">Идеальная покраска кузова без переплат</div>
                        <div class="chenik">2000 р.</div>                    
                    </div>
                </div>
            </div>           
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/download 1.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Частичная покраска</h2>
                    <span  class="ff">Частичная покраска</span>
                    <span class="span_number" style="display:none;">13</span>
                    <div class="text_moika">
                        <div class="onetx">Идеальная покраска кузова без переплат</div>
                        <div class="chenik">2400 р.</div>                    
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/img_2161-min 1 (1).png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Покраска двери</h2>
                    <span  class="ff">Покраска двери</span>
                    <span class="span_number" style="display:none;">14</span>
                    <div class="text_moika">
                        <div class="onetx">Идеальная покраска дверей без переплат</div>
                        <div class="chenik">1000 р.</div>                    
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/download 2.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Покраска крыла</h2>
                    <span  class="ff">Покраска крыла</span>
                    <span class="span_number" style="display:none;">15</span>
                    <div class="text_moika">
                        <div class="onetx">Идеальная покраска крыла без переплат</div>
                        <div class="chenik">2400 р.</div>                    
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/download 3.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Покраска капота</h2>
                    <span  class="ff">Покраска капота</span>
                    <span class="span_number" style="display:none;">16</span>
                    <div class="text_moika">
                        <div class="onetx">Идеальная покраска капота без переплат</div>
                        <div class="chenik">1000 р.</div>                    
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/download 4.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Покраска багажника</h2>
                    <span  class="ff">Покраска багажника</span>
                    <span class="span_number" style="display:none;">17</span>
                    <div class="text_moika">
                        <div class="onetx">Идеальная покраска багажника без переплат</div>
                        <div class="chenik">700 р.</div>                    
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/images 1.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Покраска бампера</h2>
                    <span  class="ff">Покраска бампера</span>
                    <span class="span_number" style="display:none;">18</span>
                    <div class="text_moika">
                        <div class="onetx">Идеальная покраска бампера без переплат</div>
                        <div class="chenik">4000 р.</div>                    
                    </div>
                </div>
            </div>
            <div class="chast_moika">
                <div class="img_moika">
                    <img src="/img/images 2.png" alt="">
                </div>
                <div class="text_dla">
                    <h2>Покраска крыши</h2>
                    <span  class="ff">Покраска крыши</span>
                    <span class="span_number" style="display:none;">19</span>
                    <div class="text_moika">
                        <div class="onetx">Идеальная покраска крыши без переплат</div>
                        <div class="chenik">700 р.</div>                    
                    </div>
                </div>
            </div>
            <!-- 
            <div class="previ">
                <div class="prev_vnut">
                    <div class="chast2" style= "background-image: url('/img/Group 65.png')" object-fit: cover; >
                        <div class="overlay4"></div>
                    <div class="text_chast_m">Идеальная покраска кузова без переплат</div>
                    </div>
                </div>
            </div> -->
            

<!-- 
            <div class="chasti_pokraski"> -->
                <!-- <div class="chast" style= "background-image: url('/img/pokraska-auto-2\ 1\ \(1\).png')" object-fit: cover;  >
                    <div class="overlay4"></div>
                    <span class="ff">12</span>
                    <div class="text_chast">Полная<br> покраска</div>
                </div> -->
                <!-- <div class="chast" style= "background-image: url('/img/download 1.png')" object-fit: cover; >
                    <div class="overlay4"></div>
                    <span class="ff">13</span>
                    <div class="text_chast">Частичная<br> покраска</div>
                </div> -->
                <!-- <div class="chast" style= "background-image: url('/img/img_2161-min 1 (1).png')" object-fit: cover;  >
                    <div class="overlay4"></div>
                    <span class="ff">14</span>
                    <div class="text_chast">Покраска<br> двери</div>
                </div> -->
                <!-- <div class="chast" style= "background-image: url('/img/download 2.png')" object-fit: cover; >
                    <div class="overlay4"></div>
                    <span class="ff">15</span>
                    <div class="text_chast">Покраска <br>крыла</div>
                </div> -->
                <!-- <div class="chast" style= "background-image: url('/img/download 3.png')" object-fit: cover; >
                    <div class="overlay4"></div>
                    <span class="ff">16</span>
                    <div class="text_chast">Покраска<br> капота</div>
                </div> -->
                <!-- <div class="chast" style= "background-image: url('/img/download 4.png')" object-fit: cover; >
                    <div class="overlay4"></div>
                    <span class="ff">17</span>
                    <div class="text_chast">Покраска<br> багажника</div>
                </div> -->
                <!-- <div class="chast" style= "background-image: url('/img/images 1.png')" object-fit: cover; >
                    <div class="overlay4"></div>
                    <span class="ff">18</span>
                    <div class="text_chast">Покраска <br>бампера</div>
                </div> -->
                <!-- <div class="chast" style= "background-image: url('/img/images 2.png')" object-fit: cover; >
                    <div class="overlay4"></div>
                    <span class="ff">19</span>
                    <div class="text_chast">Покраска <br>крыши</div>
                </div> -->
            <!-- </div> -->

            <!-- <div class="opisanie_okraski">
                <div class="naz_ork">
                    <div class="opis_rab">Описание работы</div>
                    <div class="opis_rab">Цены</div>
                    <div class="opis_rab">Преимущества</div>
                    <div class="opis_rab">Частные вопросы</div>
                </div>
            </div> -->
            <div class="op_okr">
                <h2>Этапы покраски кузова автомобиля</h2>
                <p> <span>1. Мойка авто</span> <br>
                    Перед покраской автомобиля необходимо тщательно очистить его кузов. Необходимо удалить все загрязнения, чтобы оценить состояние ЛКП, обнаружить даже небольшие дефекты и нейтрализовать вещества, которые могут помешать выполнению работы.
                    Для этого кузов сначала обрабатывается стандартными моющими средствами. Затем необходимо удалить битумные пятна, остатки насекомых и другие сложные загрязнения. Для этого используются специальные составы.
                    И, наконец, кузов автомобиля обезжиривают. Для этого используется уайт-спирит или другой неагрессивный растворитель.
                </p>
                <p>
                    <span>2. Подготовка</span> <br>
                    Следующим этапом покраски автомобиля считается его подготовка.
                    Здесь нужно удалить с кузова все шильдики, значки и прочие детали, которые могут помешать работе. Также следует избавиться от остатков клея. Для этого можно использовать шуруповерт с резиновой насадкой. Если выполнять покраску в кустарных условиях, на эту роль может подойти кусок старой автомобильной или велосипедной камеры.
                </p>
                <p>
                    <span>3. Удаление ржавчины</span> <br>
                    Если задача заключается в полной покраске автомобиля, нужно предварительно избавиться от ржавчины. Это необходимо, так как она помешает нанести новые слои базы и лака ровно. Также она продолжит разрушать металл, что снизит прочность кузова. Этого лучше не допускать.
                    Главное не перестараться. Если повредить металл в том месте, где ржавчина лишь поверхностная, этот участок придется шпаклевать. Это приведет к увеличению стоимости работы.
                </p>
                <!-- <div class="img_op_okr">
                    <img src="/img/etapy-pokraski-avto-5 1.png" alt="">
                    <img src="/img/etapy-pokraski-avto-3 1.png" alt="">
                </div> -->
                <p>
                    <span>5. Шпаклевание</span> <br>
                    При наличии серьезных повреждений кузова и ограниченном бюджете на его восстановление необходимо зашпаклевать вмятины. Это нужно сделать заранее, до перехода к этапу покраски авто.
                    Предварительно места, подлежащие шпаклеванию, матуются, чтобы материал лучше закрепился на поверхности. Для этого используется абразивная шкурка.
                    Обработанные места обезжиривают, наносят на них шпаклевку. Ее необходимо отшлифовать, чтобы сгладить неровности и придать ей нужную форму. На этом данный этап работы можно считать завершенным.
                </p>
                <p>
                    <span>6. Покраска</span> <br>
                    Прежде чем приступить к покраске авто, снимаем бумагу и скотч, нанесенные на предыдущем этапе. Также следует обдуть машину сжатым воздухом. Задача — удалить пыль, частицы грунта, воду и другие материалы, которые могли попасть в труднодоступные места кузова при проделанных операциях.
                    После этого заклеиваем все детали, не подлежащие окрашиванию, бумагой и малярным скотчем. Это поможет избежать попадания на них краски и лака.
                    Каждый мастер использует свою технику покраски, поэтому рекомендовать оборудование и способ распыления материалов не будем. Приведем лишь общие рекомендации по порядку работ, которые помогут получить достойный результат.
                    Сначала наносится база — пигментный слой. В первую очередь его наносят на грунтованные детали. После этого в 2 слоя на все части, не заклеенные бумагой.
                    Лак наносится сразу на весь кузов. Обычно достаточно 1-2 слоев, но все зависит от особенностей состава и подхода мастера к работе.
                    Все описанные этапы выполняются с интервалами, которые дают нанесенному материалу высохнуть и закрепиться.
                    После этого непосредственно покраску можно считать завершенной. Остается только снять бумагу, скотч, установить снятые детали и проверить качество работы.
                </p>
                <br>
            </div>
            <!-- <div class="op_okr2">
                <table> 
                    <thead>
                      <tr>
                        <th>Вид работ</th>
                        <th>Малый класс, руб.</th>
                        <th>Средний класс, руб.</th>
                        <th>Премиум класс, руб</th>
                        <th>Бизнес класс, руб</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Полная покраска</td>
                        <td>9000</td>
                        <td>10000</td>
                        <td>11000</td>
                        <td>12000</td>
                      </tr>
                      <tr>
                        <td>Частичная покраска</td>
                        <td>от 4000</td>
                        <td>от 5000</td>
                        <td>от 6000</td>
                        <td>от 7000</td>
                      </tr>
                      <tr>
                        <td>Покраска двери</td>
                        <td>от 6000</td>
                        <td>от 7000</td>
                        <td>от 7000</td>
                        <td>от 8000</td>
                      </tr>
                      <tr>
                        <td>Покраска крыла</td>
                        <td>от 4000</td>
                        <td>от 4500</td>
                        <td>от 5000</td>
                        <td>от 5000</td>
                      </tr>
                      <tr>
                        <td>Покраска капота</td>
                        <td>9000</td>
                        <td>900</td>
                        <td>11000</td>
                        <td>11000</td>
                      </tr>
                      <tr>
                        <td>Покраска багажника</td>
                        <td>от 6000</td>
                        <td>от 6000</td>
                        <td>от 7000</td>
                        <td>от 7000</td>
                      </tr>
                      <tr>
                        <td>Покраска бампера</td>
                        <td>от 4000</td>
                        <td>от 5000</td>
                        <td>от 6000</td>
                        <td>от 10000</td>
                      </tr>
                      <tr>
                        <td>Покраска крыши</td>
                        <td>от 9000</td>
                        <td>от 10000</td>
                        <td>от 11000</td>
                        <td>от 12000</td>
                      </tr>
                    </tbody>
                </table>
            </div> -->
            <!-- <div class="op_okr3">
                
            </div>
            <div class="op_okr4">1236</div> -->
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
    <script src="/js/okraska.js"></script>
    <script src="/js/jsmoila.js"></script>
</body>
</html>