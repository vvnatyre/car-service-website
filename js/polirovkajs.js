let coll = document.getElementsByClassName('but_vnut_vop')
for (let i = 0; i < coll.length; i++){
    coll[i].addEventListener('click', function() {
        this.classList.toggle('active');
        let content = this.nextElementSibling;
        if (content.style.maxHeight){
            content.style.maxHeight = null;
        }else{
            content.style.maxHeight = content.scrollHeight + 'px'
        }
    })
}



form_moika = document.querySelector(".form_moika2");
dark_block = document.querySelector(".dark_block_modal2")


dark_block.addEventListener("click",function(){
    form_moika.style.display = "none";
})

moika = document.querySelectorAll(".chast");

moika.forEach(btn => {
    btn.addEventListener("click",function(){
        form_moika.style.display = "flex";
        for (let i = 0; i < moika.length; i++) {
            if(moika[i] == btn){
                document.querySelector(".title_input2").value = document.querySelectorAll(".ff")[i].textContent;
            }
        }
        
    })
});

form_moika = document.querySelector(".form_moika2");
dark_block = document.querySelector(".dark_block_modal2")


dark_block.addEventListener("click",function(){
    form_moika.style.display = "none";
})

moika = document.querySelectorAll(".chast_moika");

moika.forEach(btn => {
    btn.addEventListener("click",function(){
        form_moika.style.display = "flex";
        document.querySelector(".title_input2").value = btn.querySelector("span").innerHTML;
        document.querySelector(".title_id").value = btn.querySelector(".span_number").innerHTML;
    })
});
