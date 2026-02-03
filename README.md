# Library Management System - Hệ thống Quản lý Thư viện

## Giới thiệu
Hệ thống Quản Lý Thư Viện được xây dựng nhằm hỗ trợ việc quản lý sách, người dùng
và quá trình mượn – trả sách một cách hiệu quả.
Dự án được thực hiện theo hình thức làm việc nhóm gồm 4 thành viên:
- Nguyễn Thùy Trang - leader
- Nguyễn Thị Ngọc Anh
- Đoàn Công Việt
- Hoàng Lê Kim Ngân

## Mục tiêu
- Quản lý danh sách sách trong thư viện
- Quản lý người dùng (sinh viên / thủ thư / admin)
- Quản lý mượn – trả sách
- Giảm thiểu sai sót so với quản lý thủ công
- Nâng cao kỹ năng làm việc nhóm và áp dụng mô hình MVC

## Chức năng chính
### Người dùng
- Đăng ký / đăng nhập tài khoản
- Xem danh sách sách
- Tìm kiếm sách theo tên sách/tác giả
- Gửi yêu cầu mượn sách
- Xem lịch sử mượn – trả
- Xem trang cá nhân và chỉnh sửa nó
### Admin / Thủ thư
- Quản lý sách (thêm / sửa / xóa)
- Quản lý người dùng
- Xác nhận yêu cầu mượn sách
- Thống kê số lượng sách

## Công nghệ sử dụng
- Ngôn ngữ: PHP
- Cơ sở dữ liệu: MySQL
- Frontend: HTML, CSS, JavaScript
- Backend: PHP (PDO)
- Mô hình: MVC
- Công cụ quản lý: Git, GitHub, Jira

## Cấu trúc dự án 
```
library_management_project/
├── app/                          # Thư mục ứng dụng chính
│   ├── core/                     # Các file cốt lõi
│   │   └── PHP mailer
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
│           └── slider.php       # Slider  
├── config/                       # Cấu hình
│   └── config.php               # File cấu hình chính
├── public/                       # Thư mục công khai
│   ├── index.php                # Entry point
│   ├── css/                     # CSS files
│   ├── js/                      # JavaScript files
│   ├── image/                   # Hình ảnh slider
│   └── images/                  # Hình ảnh sách

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
