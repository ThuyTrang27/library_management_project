<?php

/**
 * app/helpers/imageHelper.php
 * 
 * File này chứa các hàm helper (hàm hỗ trợ) để xử lý hình ảnh
 * Tách riêng để dễ quản lý và tái sử dụng ở nhiều nơi
 * 
 * CÁCH SỬ DỤNG:
 * require_once dirname(__DIR__) . '/helpers/imageHelper.php';
 */

// Load App core để có BASE_URL
require_once dirname(__DIR__) . '/core/App.php';
App::init();

/**
 * Hàm chuyển đổi đường dẫn ảnh từ database sang đường dẫn web
 * 
 * GIẢI THÍCH:
 * - Trong database, đường dẫn được lưu dạng: "../public/images/fantasy/a_house_witch.png"
 * - Trên web, cần đường dẫn dạng: "/library_management_project/public/images/fantasy/a_house_witch.png"
 * - Hàm này sẽ tự động chuyển đổi
 * 
 * @param string|null $dbImagePath - Đường dẫn ảnh lấy từ database (có thể là null hoặc rỗng)
 * @return string - Đường dẫn ảnh đúng để hiển thị trên web
 */
function convertImagePath($dbImagePath)
{
    // Bước 1: Kiểm tra đường dẫn có rỗng hoặc null không
    if (empty($dbImagePath)) {
        // Nếu rỗng, trả về ảnh mặc định (no-image)
        return BASE_URL . '/images/no-image.png';
    }

    // Bước 2: Xử lý các trường hợp đường dẫn khác nhau

    // Trường hợp 1: Đường dẫn bắt đầu bằng "../public/"
    // Ví dụ: "../public/images/fantasy/a_house_witch.png"
    if (strpos($dbImagePath, '../public/') === 0) {
        // Loại bỏ "../public/" và thay bằng BASE_URL
        // Kết quả: "/library_management_project/public/images/fantasy/a_house_witch.png"
        return BASE_URL . '/' . str_replace('../public/', '', $dbImagePath);
    }

    // Trường hợp 2: Đường dẫn bắt đầu bằng "public/"
    // Ví dụ: "public/images/fantasy/a_house_witch.png"
    if (strpos($dbImagePath, 'public/') === 0) {
        // Loại bỏ "public/" và thay bằng BASE_URL
        return BASE_URL . '/' . str_replace('public/', '', $dbImagePath);
    }

    // Trường hợp 3: Đường dẫn đã là đường dẫn tuyệt đối (bắt đầu bằng "/")
    // Ví dụ: "/images/fantasy/a_house_witch.png"
    if (strpos($dbImagePath, '/') === 0) {
        // Giữ nguyên đường dẫn
        return $dbImagePath;
    }

    // Trường hợp 4: Đường dẫn là URL đầy đủ (bắt đầu bằng "http")
    // Ví dụ: "https://example.com/image.jpg"
    if (strpos($dbImagePath, 'http') === 0) {
        // Giữ nguyên URL
        return $dbImagePath;
    }

    // Trường hợp 5: Đường dẫn tương đối khác
    // Ví dụ: "images/fantasy/a_house_witch.png"
    // Thêm BASE_URL vào đầu
    return BASE_URL . '/' . ltrim($dbImagePath, './');
}

/**
 * Lấy đường dẫn ảnh từ dữ liệu sách
 * Xử lý cả image_ulr và image_url (do database có thể dùng cả hai)
 * 
 * @param array $book - Mảng chứa thông tin sách từ database
 * @return string - Đường dẫn ảnh đúng để hiển thị
 */
function getBookImagePath($book)
{
    // Kiểm tra cả image_ulr và image_url (do database có thể dùng cả hai)
    // Lưu ý: Trong database tên cột là image_ulr (thiếu chữ 'l')
    $imagePath = $book['image_ulr'] ?? $book['image_url'] ?? '';
    
    // Chuyển đổi sang đường dẫn web
    return convertImagePath($imagePath);
}

/**
 * Hàm lấy giá trị an toàn từ mảng (tránh lỗi null)
 * 
 * GIẢI THÍCH:
 * - Khi lấy dữ liệu từ database, một số trường có thể là null
 * - PHP 8.1+ không cho phép truyền null vào htmlspecialchars()
 * - Hàm này sẽ trả về giá trị mặc định nếu null
 * 
 * @param mixed $value - Giá trị cần kiểm tra (có thể là null)
 * @param string $default - Giá trị mặc định nếu null
 * @return string - Giá trị an toàn để sử dụng
 */
function safeValue($value, $default = '')
{
    // Nếu giá trị rỗng hoặc null, trả về giá trị mặc định
    if (empty($value) && $value !== '0' && $value !== 0) {
        return $default;
    }
    // Nếu không, trả về giá trị đó (chuyển sang string)
    return (string)$value;
}
