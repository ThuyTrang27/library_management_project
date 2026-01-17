/**
 * public/js/slide.js
 * 
 * File này xử lý slider với 2 chế độ:
 * 1. AUTO: Tự động chuyển slide sau mỗi 3 giây
 * 2. MANUAL: Người dùng click nút để chuyển slide
 */

let slideIndex = 0;
let slides;
let autoSlideInterval = null;
let isAutoMode = true; // Mặc định là chế độ tự động

/**
 * Hiển thị slide theo chỉ số
 * @param {number} n - Chỉ số slide cần hiển thị
 */
function showSlides(n) {
    slides = document.getElementsByClassName("slide");
    
    // Nếu không có slide nào, thoát
    if (slides.length === 0) return;
    
    // Xử lý chỉ số vượt quá phạm vi
    if (n >= slides.length) {
        slideIndex = 0;
    }
    if (n < 0) {
        slideIndex = slides.length - 1;
    }
    
    // Ẩn tất cả slide
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
        slides[i].style.display = "none";
    }
    
    // Hiển thị slide hiện tại
    slides[slideIndex].classList.add("active");
    slides[slideIndex].style.display = "block";
}

/**
 * Chuyển slide theo hướng (MANUAL - Thủ công)
 * @param {number} n - Số bước chuyển (1: tiếp theo, -1: quay lại)
 */
function plusSlides(n) {
    // Dừng chế độ tự động khi người dùng click
    stopAutoSlide();
    
    // Chuyển slide
    slideIndex += n;
    showSlides(slideIndex);
    
    // Khởi động lại chế độ tự động sau 5 giây
    setTimeout(function() {
        if (isAutoMode) {
            startAutoSlide();
        }
    }, 5000);
}

/**
 * Chuyển sang slide tiếp theo (AUTO - Tự động)
 */
function nextSlide() {
    slideIndex++;
    showSlides(slideIndex);
}

/**
 * Bắt đầu chế độ tự động chuyển slide
 */
function startAutoSlide() {
    // Dừng interval cũ nếu có
    stopAutoSlide();
    
    // Bắt đầu interval mới (chuyển slide sau mỗi 3 giây)
    autoSlideInterval = setInterval(nextSlide, 3000);
    isAutoMode = true;
}

/**
 * Dừng chế độ tự động chuyển slide
 */
function stopAutoSlide() {
    if (autoSlideInterval) {
        clearInterval(autoSlideInterval);
        autoSlideInterval = null;
    }
    isAutoMode = false;
}

/**
 * Toggle chế độ tự động/thủ công
 */
function toggleAutoMode() {
    if (isAutoMode) {
        stopAutoSlide();
    } else {
        startAutoSlide();
    }
}

/**
 * Khởi tạo slider khi trang web được load
 */
window.onload = function() {
    slides = document.getElementsByClassName("slide");
    
    if (slides.length > 0) {
        // Hiển thị slide đầu tiên
        showSlides(slideIndex);
        
        // Bắt đầu chế độ tự động
        startAutoSlide();
        
        // Tìm container chứa slider
        var slideBox = document.querySelector('.slideshow-container');
        
        if (slideBox) {
            // Khi người dùng đưa chuột vào slider
            slideBox.addEventListener('mouseenter', function() {
                // Dừng tự động chuyển slide
                stopAutoSlide();
            });
            
            // Khi người dùng rời chuột khỏi slider
            slideBox.addEventListener('mouseleave', function() {
                // Tiếp tục tự động chuyển slide
                if (isAutoMode) {
                    startAutoSlide();
                }
            });
        }
    }
};
