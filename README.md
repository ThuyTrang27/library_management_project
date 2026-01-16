# Library Management System - Hệ thống Quản lý Thư viện

## 📁 Cấu trúc Thư mục

```
library_management_project/
├── app/                          # Thư mục ứng dụng chính
│   ├── core/                     # Các file cốt lõi
│   │   └── App.php              # Class App - Load config và helper functions
│   ├── controllers/              # Controllers (xử lý logic)
│   │   ├── bookController.php   # Controller quản lý sách
│   │   ├── authController.php    # Controller xử lý đăng nhập/đăng ký
│   │   └── borrowController.php  # Controller quản lý mượn sách
│   ├── models/                   # Models (tương tác database)
│   │   ├── book.php             # Model sách
│   │   ├── category.php         # Model danh mục
│   │   ├── user.php             # Model người dùng
│   │   └── borrowRequest.php    # Model yêu cầu mượn
│   ├── views/                    # Views (giao diện)
│   │   ├── home.php             # Trang chủ
│   │   └── layouts/             # Layout chung
│   │       ├── header.php       # Header
│   │       ├── footer.php       # Footer
│   │       └── slider.php       # Slider
│   └── helpers/                  # Helper functions
│       └── imageHelper.php      # Hàm xử lý hình ảnh
├── config/                       # Cấu hình
│   └── config.php               # File cấu hình chính
├── public/                       # Thư mục công khai
│   ├── index.php                # Entry point
│   ├── css/                     # CSS files
│   ├── js/                      # JavaScript files
│   ├── image/                   # Hình ảnh slider
│   └── images/                  # Hình ảnh sách
└── Data/                        # Database
    └── DATABASE.sql             # File SQL tạo database
```

## 🚀 Cách Sử Dụng

### 1. Cấu hình Database
- Mở file `config/config.php`
- Điều chỉnh thông tin kết nối database:
  ```php
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'LIBRARY_MANAGEMENT');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  ```

### 2. Tạo Database
- Import file `Data/DATABASE.sql` vào MySQL
- Hoặc chạy các câu lệnh SQL trong file đó

### 3. Cấu hình BASE_URL
- Mở file `config/config.php`
- Điều chỉnh `BASE_URL` theo cấu trúc thư mục của bạn:
  ```php
  define('BASE_URL', '/library_management_project/public');
  ```

### 4. Truy cập Website
- URL: `http://localhost/library_management_project/public/index.php?action=home`

## 📝 Giải Thích Code

### App.php
- File này chứa class `App` với các hàm helper
- `App::init()` - Load config một lần
- `App::url($path)` - Tạo URL đầy đủ

### imageHelper.php
- `convertImagePath($dbImagePath)` - Chuyển đổi đường dẫn từ database sang web
- `getBookImagePath($book)` - Lấy đường dẫn ảnh từ dữ liệu sách (xử lý cả image_ulr và image_url)
- `safeValue($value, $default)` - Lấy giá trị an toàn (tránh null)

### Cách Xử Lý Hình Ảnh
1. Database lưu: `"../public/images/fantasy/a_house_witch.png"`
2. Hàm `convertImagePath()` chuyển đổi thành: `"/library_management_project/public/images/fantasy/a_house_witch.png"`
3. Hiển thị trên web với đường dẫn đúng

## ⚠️ Lưu Ý Quan Trọng

### Tên Cột Database
- Trong database, cột hình ảnh có tên là `image_ulr` (thiếu chữ 'l')
- Code đã xử lý cả `image_ulr` và `image_url` để tương thích

### Đường Dẫn Hình Ảnh
- Tất cả hình ảnh sách nằm trong: `public/images/`
- Hình ảnh slider nằm trong: `public/image/`
- Logo nằm trong: `public/image/logo.jpg`

## 🔧 Cấu Trúc MVC

### Model (app/models/)
- Tương tác với database
- Trả về dữ liệu dạng mảng

### View (app/views/)
- Hiển thị giao diện
- Nhận dữ liệu từ Controller
- Không chứa logic phức tạp

### Controller (app/controllers/)
- Xử lý logic
- Lấy dữ liệu từ Model
- Truyền dữ liệu cho View

## 📚 Các File Quan Trọng

- `public/index.php` - Entry point, xử lý routing
- `config/config.php` - Cấu hình chung
- `app/core/App.php` - Core functions
- `app/helpers/imageHelper.php` - Helper xử lý ảnh
