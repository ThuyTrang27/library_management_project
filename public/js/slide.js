let slideIndex = 0;
let slides, autoSlideInterval;

function showSlides(n) {
    slides = document.getElementsByClassName("slide");
    if (n >= slides.length) { slideIndex = 0; }
    if (n < 0) { slideIndex = slides.length - 1; }
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
    }
    slides[slideIndex].classList.add("active");
}

function plusSlides(n) {
    clearInterval(autoSlideInterval);
    slideIndex += n;
    showSlides(slideIndex);
    autoSlideInterval = setInterval(nextSlide, 3000);
}

function nextSlide() {
    slideIndex++;
    showSlides(slideIndex);
}

window.onload = function() {
    slides = document.getElementsByClassName("slide");
    showSlides(slideIndex);
    autoSlideInterval = setInterval(nextSlide, 3000);
};