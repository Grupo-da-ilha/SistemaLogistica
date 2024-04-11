var slides = document.querySelectorAll('.slides');
var btns = document.querySelectorAll('.btns');
let currentSlide = 1;

var manualNav = function(manual){
    slides.forEach((slides) => {
        slides.classList.remove('actives');

        btns.forEach((btns) => {
            slide.classList.remove('actives');
        });
    });

    slides[manual].classList.add('actives');
    btns[manual].classList.add('actives');
}

btns.forEach((btns, i) => {
    btns.addEventListener("click", () => {
        manualNav(i);
        currentSlide = i;

    });
});

var repeat = function(activeClass){
    let active = document.getElementsByClassName('actives');
    let i = 1;

    var repeater = () => {
        setTimeout(function(){
            [...active].forEach((activeSlide) => {
                activeSlide.classList.remove('actives');
            });

        slides[i].classList.add('actives');
        btns[i].classList.add('actives');
        i++;

        if(slides.length == i) {
            i = 0;
        }
        if(i >= slides.length){
            return;
        }
        repeater();
        },25000);
    }
    repeater();
}
repeat();