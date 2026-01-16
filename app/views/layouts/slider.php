<?php

/**
 * app/views/layouts/slider.php
 * 
 * File này hiển thị slider (carousel) sử dụng Bootstrap Carousel
 * 
 * GIẢI THÍCH CHO NGƯỜI MỚI HỌC:
 * - Bootstrap Carousel là component có sẵn của Bootstrap
 * - Tự động chuyển slide sau mỗi khoảng thời gian (data-bs-interval)
 * - Có thể click nút Previous/Next để chuyển thủ công
 * - Có indicators (dấu chấm) để biết đang ở slide nào
 * 
 * CÁCH HOẠT ĐỘNG:
 * 1. data-bs-ride="carousel" - Tự động chạy carousel
 * 2. data-bs-interval="3000" - Chuyển slide sau mỗi 3 giây (3000ms)
 * 3. data-bs-slide="prev/next" - Chuyển slide khi click nút
 */

// Đảm bảo BASE_URL đã được định nghĩa
if (!defined('BASE_URL')) {
    require_once dirname(dirname(dirname(__DIR__))) . '/config/config.php';
}
?>

<!-- SLIDER - SỬ DỤNG BOOTSTRAP CAROUSEL -->
<div class="container mt-3 mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <!-- Card chứa carousel -->
            <div class="card shadow-lg border-0 overflow-hidden">
                <!-- 
                    Bootstrap Carousel Component
                    - id="bookCarousel": ID duy nhất để JavaScript điều khiển
                    - class="carousel slide": Class của Bootstrap carousel
                    - data-bs-ride="carousel": Tự động chạy carousel
                    - data-bs-interval="3000": Chuyển slide sau mỗi 3 giây (3000ms = 3s)
                    - data-bs-pause="hover": Tạm dừng khi hover chuột
                -->
                <div id="bookCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" data-bs-pause="hover">

                    <!-- Indicators - Dấu chấm hiển thị slide hiện tại -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                        <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
                    </div>

                    <!-- Slides - Các hình ảnh sẽ hiển thị -->
                    <div class="carousel-inner">
                        <!-- Slide 1: Hoàng Tử Bé (active = hiển thị đầu tiên) -->
                        <div class="carousel-item active">
                            <div class="carousel-image-wrapper">
                                <img src="<?php echo BASE_URL; ?>/images/fantasy/hoang_tu_be.png"
                                    class="d-block w-100 carousel-image"
                                    alt="Hoàng Tử Bé"
                                    onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>/images/hoang_tu_be.jpg';">
                            </div>
                        </div>

                        <!-- Slide 2: Harry Potter -->
                        <div class="carousel-item">
                            <div class="carousel-image-wrapper">
                                <img src="<?php echo BASE_URL; ?>/images/fantasy/harry_potter.png"
                                    class="d-block w-100 carousel-image"
                                    alt="Harry Potter"
                                    onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>/images/harry_potter.jpg';">
                            </div>
                        </div>

                        <!-- Slide 3: Đắc Nhân Tâm -->
                        <div class="carousel-item">
                            <div class="carousel-image-wrapper">
                                <img src="<?php echo BASE_URL; ?>/images/self_help/dac_nhan_tam.png"
                                    class="d-block w-100 carousel-image"
                                    alt="Đắc Nhân Tâm"
                                    onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>/images/self_help/dac_nhan_tam.jpg';">
                            </div>
                        </div>

                        <!-- Slide 4: A House Witch -->
                        <div class="carousel-item">
                            <div class="carousel-image-wrapper">
                                <img src="<?php echo BASE_URL; ?>/images/fantasy/a_house_witch.png"
                                    class="d-block w-100 carousel-image"
                                    alt="A House Witch"
                                    onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>/images/fantasy/a_house_witch.png';">
                            </div>
                        </div>

                        <!-- Slide 5: Đất Rừng Phương Nam -->
                        <div class="carousel-item">
                            <div class="carousel-image-wrapper">
                                <img src="<?php echo BASE_URL; ?>/images/fantasy/dat_rung_phuong_nam.png"
                                    class="d-block w-100 carousel-image"
                                    alt="Đất Rừng Phương Nam"
                                    onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>/images/fantasy/dat_rung_phuong_nam.png';">
                            </div>
                        </div>
                    </div>

                    <!-- Nút Previous - Chuyển slide trước -->
                    <button class="carousel-control-prev" type="button"
                        data-bs-target="#bookCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <!-- Nút Next - Chuyển slide sau -->
                    <button class="carousel-control-next" type="button"
                        data-bs-target="#bookCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>