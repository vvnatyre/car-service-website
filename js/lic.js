function openAvatarForm() {
    // Показываем форму при нажатии на кнопку
    document.getElementById('avatarForm').style.display = 'block';
}


form_moika = document.querySelector(".form_moika3");
dark_block = document.querySelector(".dark_block_modal3")


dark_block.addEventListener("click",function(){
    form_moika.style.display = "none";
})

moika = document.querySelectorAll(".gfg");

moika.forEach(btn => {
    btn.addEventListener("click",function(){
        form_moika.style.display = "flex";
        for (let i = 0; i < moika.length; i++) {
            if(moika[i] == btn){
                document.querySelector(".title_input22").value;
            }
        }
        
    })
});


function showAlert() {
    alert("Успешное добавление!");
}

function deleteAuto(index) {
    if (confirm("Вы уверены, что хотите удалить этот автомобиль?")) {
        // Создаем XMLHttpRequest объект
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "vender/delete_auto.php?index=" + index, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Если удаление прошло успешно, удаляем форму со страницы
                var autoElement = document.getElementById("auto_" + index);
                if (autoElement) {
                    autoElement.remove();
                }
            } else {
                alert("Ошибка при удалении автомобиля.");
            }
        };

        xhr.send();
    }
}


//  root
function showTab(className) {
    // Скрываем все
    document.querySelectorAll('.tab-section').forEach(el => {
        el.classList.remove('active-tab');
    });
    // Показываем выбранную
    const selected = document.querySelector('.' + className);
    if (selected) {
        selected.classList.add('active-tab');
    }
}



document.addEventListener('DOMContentLoaded', function() {
  const changeBtn = document.getElementById('changePassBtn');
  const cancelBtn = document.getElementById('cancelChange');
  const formBlock = document.getElementById('changePassBlock');

  // Показать форму
  changeBtn.addEventListener('click', () => {
    formBlock.style.display = 'block';
  });

  // Скрыть форму и очистить ошибки
  cancelBtn.addEventListener('click', () => {
    formBlock.style.display = 'none';
  });
});