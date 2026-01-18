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
