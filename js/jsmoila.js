form_moika = document.querySelector(".form_moika");
dark_block = document.querySelector(".dark_block_modal")


dark_block.addEventListener("click",function(){
    form_moika.style.display = "none";
})

moika = document.querySelectorAll(".chast_moika");

moika.forEach(btn => {
    btn.addEventListener("click",function(){
        form_moika.style.display = "flex";
        document.querySelector(".title_input").value = btn.querySelector("span").innerHTML;
        document.querySelector(".title_id").value = btn.querySelector(".span_number").innerHTML;
    })
});



