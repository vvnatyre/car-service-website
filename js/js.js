navv = 0
// console.log(getComputedStyle(document.querySelector("nav")).height)
document.querySelector('.burger').addEventListener('click', function(){
    
    this.classList.toggle('active');
    // document.querySelector('.nav').classList.toggle('open');
    if(navv == 0){
        navv = 1
        document.querySelector("nav").style.height = "30%";
    }else{
        navv = 0
        document.querySelector("nav").style.height = "0%";
        document.querySelector("nav").style.transform = "translateY(-10px)";[]
    }
    
})


document.getElementById('login-button').addEventListener('click', function() {
    document.getElementById('auth-modal').style.display = 'block';
});

// Закрытие модального окна при клике вне его
window.onclick = function(event) {
    if (event.target == document.getElementById('auth-modal')) {
        document.getElementById('auth-modal').style.display = 'none';
    }
};



document.getElementById('login-button').addEventListener('click', function(event) {
    event.preventDefault(); 
    document.getElementById('modal-background').style.display = 'block'; 
    document.getElementById('auth-modal').style.display = 'block'; 
    document.getElementById('modal-title').innerText = 'Войти';
    document.getElementById('auth-form').style.display = 'block';
    document.getElementById('register-form').style.display = 'none';
});

document.querySelectorAll('#toggle-link').forEach(btn => {
    btn.addEventListener('click', function(event) {
        event.preventDefault(); 
        const isLoginVisible = document.getElementById('auth-form').style.display !== 'none';
        
        if (isLoginVisible) {
            document.getElementById('modal-title').innerText = 'Зарегистрироваться';
            document.getElementById('auth-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
            initPhoneMask();
            // this.innerText = 'Войти'; 
        } else {
            document.getElementById('modal-title').innerText = 'Войти';
            document.getElementById('auth-form').style.display = 'block';
            document.getElementById('register-form').style.display = 'none';
            // this.innerText = 'Зарегистрироваться';
        }
    });
    
});



// Закрытие модального окна при клике вне его
window.onclick = function(event) {
    if (event.target == document.getElementById('auth-modal')) {
        document.getElementById('auth-modal').style.display = 'none';
    }
};

// $('.input-file input[type=file]').on('change', function(){
// 	let file = this.files[0];
// 	$(this).closest('.input-file').find('.input-file-text').html(file.name);
// });

// слайдер
// var slideIndex = 1;
// showSlides(slideIndex);

// function plusSlides(n) {
//     showSlides(slideIndex += n);
// } 

// function currentSlide(n) {
//     showSlides(slideIndex = n);
// }

// function showSlides(n) {
//     var i;
//     var slides = document.getElementsByClassName("mySlides");
//     var dots = document.getElementsByClassName("dot");
//     image_arr = ["img/полировка.png","img/мойка.png","img/покраска.png"]

//     if (n > slides.length) {
//         slideIndex = 1;
//         // document.querySelector(".slideshow-container").style.backgroundImage = "url(../img/полировка.png)"
//     }
//     if (n < 1) {
//         slideIndex = slides.length;
//         // document.querySelector(".slideshow-container").style.backgroundImage = "url(/img/мойка.png)"
//     }
    
//     for (i = 0; i < slides.length; i++) {
//         slides[i].style.display = "none";  
        
//     }
//     for (i = 0; i < dots.length; i++) {
//         dots[i].className = dots[i].className.replace(" active", ""); 
//     }
//     document.querySelector(".slideshow-container").style.backgroundImage = "url("+image_arr[slideIndex - 1]+")"
    
//     slides[slideIndex - 1].style.display = "block";  
//     dots[slideIndex - 1].className += " active";
// }


var slideIndex = 1;
showSlides(slideIndex);

// Функции для управления слайдами
function plusSlides(n) {
    showSlides(slideIndex += n);
} 

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    var image_arr = ["img/полировка.png", "img/мойка.png", "img/покраска.png"];
    
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    
    // Скрыть все слайды
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    
    // Удалить класс "active" у всех точек
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", ""); 
    }

    // Установить фоновое изображение
    document.querySelector(".slideshow-container").style.backgroundImage = "url("+image_arr[slideIndex - 1]+")";
    
    // // Показать текущий слайд и установить класс "active" у соответствующей точки
    slides[slideIndex - 1].style.display = "block";  
    dots[slideIndex - 1].className += " active";
}

// Автоматическая прокрутка слайдов
setInterval(function() {
    plusSlides(1); 
}, 5000); 

document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Удаляем активный класс со всех кнопок
            tabButtons.forEach(btn => btn.classList.remove('active'));
            // Добавляем активный класс нажатой кнопке
            button.classList.add('active');

            // Скрываем все контентные блоки
            tabContents.forEach(content => content.classList.remove('active'));
            // Показываем нужный контентный блок
            const tabId = button.getAttribute('data-tab');
            const activeContent = document.querySelector(`.tab-content[data-content="${tabId}"]`);
            activeContent.classList.add('active');
        });
    });
});



function toggleDropdown() {
    const dropdown = document.getElementById("dropdown");
    dropdown.classList.toggle("show");
}

// Закрыть выпадающее меню, если кликнули вне него
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById("dropdown");
    const isProfileLink = event.target.closest('.profile-link');

    if (!isProfileLink && dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
    }
});

// маска телефона
function initPhoneMask() {
    var input = document.getElementById('modal-phone');
    // Маска только для российских номеров +7
    var im = new Inputmask({
        mask: "+7 (999) 999-99-99",
        showMaskOnHover: false,
        showMaskOnFocus: true,
        // Это ограничение на ввод только цифр
        definitions: {
            '9': {
                validator: "[0-9]",
                cardinality: 1,
                definitionSymbol: "*"
            }
        },
        // не позволять вставлять буквы
        onBeforePaste: function (pastedValue, opts) {
            return pastedValue.replace(/\D/g, '');
        },
        // блокировать нецифровой ввод
        onKeyDown: function (e, buffer, caretPos, opts) {
            if (e.key.length === 1 && /\D/.test(e.key)) {
                e.preventDefault();
            }
        }
    });
    im.mask(input);

    // Дополнительно: не позволять копировать нецифровое
    input.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9\+\(\)\-\s]/g, '');
    });
}


