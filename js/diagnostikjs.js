const slider = document.querySelector(".slides2");
let count_slider = 1;
const sdvig = -505;

slider.style.transition = "margin-left 0.5s ease";  // Добавлено для плавности

setInterval(function() {
    if (count_slider == 6) {
        count_slider = 1;
    }
    slider.style.marginLeft = (sdvig * count_slider) + "px";
    console.log(sdvig * count_slider + "px");
    count_slider++;
}, 1500);  // Увеличено время до 2000 мс

// form_moika = document.querySelector(".form_moika2");
// dark_block = document.querySelector(".dark_block_modal2")


// dark_block.addEventListener("click",function(){
//     form_moika.style.display = "none";
// })

// moika = document.querySelectorAll(".but_kiz_rem");

// moika.forEach(btn => {
//     btn.addEventListener("click",function(){
//         form_moika.style.display = "flex";
//         for (let i = 0; i < moika.length; i++) {
//             if(moika[i] == btn){
//                 document.querySelector(".title_input2").value = document.querySelectorAll(".ff")[i].textContent;
//             }
//         }
        
//     })
// });


form_moika = document.querySelector(".form_moika2");
dark_block = document.querySelector(".dark_block_modal2")


dark_block.addEventListener("click",function(){
    form_moika.style.display = "none";
})

moika = document.querySelectorAll(".knopka_zapisi");

moika.forEach(btn => {
    btn.addEventListener("click",function(){
        form_moika.style.display = "flex";
        for (let i = 0; i < moika.length; i++) {
            if(moika[i] == btn){
                document.querySelector(".title_input22").value = document.querySelectorAll(".ff")[i].textContent;
            }
        }
        
    })
});