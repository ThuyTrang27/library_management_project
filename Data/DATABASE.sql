DROP DATABASE LIBRARY_MANAGEMENT;
CREATE DATABASE LIBRARY_MANAGEMENT;
USE LIBRARY_MANAGEMENT;

CREATE TABLE categories (
	categories_id int(10) NOT NULL PRIMARY KEY,
    categories_name varchar(50),
    description text
);
INSERT INTO categories ( caTegories_id, categories_name, description) VALUES
	(1, "Fantasy", ""),
    (2, "Literature", ""),
    (3, "Mystery", ""),
    (4, "Romantic", ""),
    (5, "Self-help", ""),
    (6, "Text book", ""),
    (7, "Science Fiction", "");

CREATE TABLE books (
	book_id int(10) NOT NULL PRIMARY KEY,
    book_title varchar(255) NOT NULL,
    price decimal(10,2),
    author varchar(50),
    publisher varchar(50),
    publisher_year int(4),
    stock_quantity int(10),
    categories_id int(10) NOT NULL,
    content text,
    image_ulr text
    );
INSERT INTO books (book_id, book_title, price, author, publisher, publisher_year, stock_quantity, categories_id, content, image_url)
VALUES 
(1, "THE HOUSE WITCH",450000,"Delemhach", "Podium Publishing", 2022,7, 1, "The House Witch is a fantasy story with romance and humor about Finlay Ashowan — a “house” witch skilled in cooking, who is hired as the royal chef in Daxaria. Fin only wants a peaceful life with his cat Kraken, but when his true powers are revealed, he is drawn into court intrigues, protects the pregnant queen, clashes with a troublesome knight, hunts for a spy, and is forced to confront his past and his complicated love life.", "../public/images/fantasy/a_house_witch.png"),
(2, "ANYA AND THE NIGHTINGALE",196000,"Sofiya Pasternack", " Versify", 2020,10, 1, "”Anya and the Nightingale” is the finale of the Anya and the Dragon duology. After her father is conscripted and doesn’t return, Anya sets out to find him with Ivan and Håkon the dragon. Along the way they face dark forces and the mysterious Nightingale, uncovering hidden secrets. Anya must choose between saving her father, protecting her friends, and understanding who she is.", "../public/images/fantasy/anya_and_the_nightingale.png"),
(3, "HARRY POTTER",150000,"J. K. Rowling", " Scholastic", 2007,8, 1, "Harry Potter is a globally famous fantasy series about Harry Potter, an orphaned boy who discovers he is a wizard at the age of eleven and attends Hogwarts School of Witchcraft and Wizardry. There, Harry and his two best friends, Ron Weasley and Hermione Granger, enter a mysterious magical world, facing dangerous challenges and the dark forces of Lord Voldemort.", "../public/images/fantasy/harry_potter.png"),
(4, "HOÀNG TỬ BÉ",120000,"Saint-Exupéry", " NXB Trẻ", 1943,4, 1, "", "../public/images/fantasy/hoang_tu_be.png"),
(5, "LIGHTFALL",196000,"Tim Probert", "  HarperAlley", 2020,9, 1, "", "../public/images/fantasy/lightfall.png"),
(6, "LOST IN THE NEVER WOODS",270000,"Aiden Thomas", " Feiwel & Friends", 2021,7, 1, "", "../public/images/fantasy/lost_in_th_never_woods.png"),
(7, "NIGHTBOOKS",196000,"J. A. White", " HarperCollins", 2018,7, 1, "", "../public/images/fantasy/night_book.png"),
(8, "SIX OF CROWS",200000,"Leigh Bardugo", "  Henry Holt and Company", 2015,5, 1, "", "../public/images/fantasy/six_of_crows.png"),
(9, "A SHADOW IN THE WOODS",300000,"J. P. Rose", " Little Tiger Press", 2000,7, 1, "", "../public/images/fantasy/shadow_in_the_woods.png"),
(10, "CHÍ PHÈO",70000,"Nam Cao", " NXB Văn Học", 1941,7, 2, "", "../public/images/literature/chi_pheo.png"),
(11, "TRUYỆN KIỀU",150000,"Nguyễn Du", " NXB Kim Đồng", 1805,7, 2, "", "../public/images/literature/truyen_kieu.png"),
(12, "DẾ MÈN PHIÊU LƯU KÝ",100000,"Tô Hoài", "NXB Kim Đồng", 1941,10, 2, "", "../public/images/literature/de_men_phieu_luu_ky.png"),
(13, "LÃO HẠC",65000,"Nam Cao", " NXB Văn Học", 1952,7, 2, "", "../public/images/literature/lao_hac.png"),
(14, "MẮT BIẾC",90000,"Nguyễn Nhật Ánh", " NXB Trẻ", 1990,7, 2, "", "../public/images/literature/mat_biec.png"),
(15, "ĐẤT RỪNG PHƯƠNG NAM",140000,"Đoàn Giỏi", " NXB Kim Đồng", 1957,7, 2, "", "../public/images/literature/dat_rung_phuong_nam.png"),
(16, "SỐ ĐỎ",130000,"Vũ Trọng Phụng", " NXB Văn Học", 1963,7, 2, "", "../public/images/literature/so_do.png"),
(17, "TẮT ĐÈN",150000,"Ngô Tất Tố", " NXB Văn Học", 1939,7, 2, "", "../public/images/literature/tat_den.png"),
(18, "TUỔI THƠ DỮ DỘI",180000,"Phùng Quán", " NXB Kim Đồng", 1988,7, 2, "", "../public/images/literature/tuoi_tho_du_doi.png"),
(19, "SHERLOCK HOLMES",180000,"Arthur Conan Doyle", " NXB Kim Đồng", 1988,7, 3, "", "../public/images/mystery/Sherlock_Holmes.png"),
(20, "GONE GIRL",160000,"Gillian Flynn", " NXB Kim Đồng", 2012,7, 3, "", "../public/images/mystery/Gone_Girl.png"),
(21, "BIG LITTLE LIES",95000,"Liane Moriarty", " Không rõ", 2014,11, 3, "", "../public/images/mystery/Big_Little_Lies.png"),
(22, "THE SILENT PATIENT",130000,"Alex Michaelides", " NXB Kim Đồng", 2019,8, 3, "", "../public/images/mystery/The_Silent_Patient.png"),
(23, "REBECCA",90000,"Daphne du Maurier", " NXB Kim Đồng", 1938,5, 3, "", "../public/images/mystery/Rebecca.png"),
(24, "IN THE WOODS",180000,"Tana French", " NXB Kim Đồng", 2007,12, 3, "", "../public/images/mystery/In_the_Woods.png"),
(25, "ANH CÓ THÍCH NƯỚC MĨ KHÔNG",120000,"Tân Di Ổ", " NXB Văn Học", 2012,9, 3, "", "../public/images/mystery/anh_co_thich_nuoc_my_khong.png"),
(26, "CHO TÔI XIN MỘT VÉ ĐI TUỔI THƠ",140000,"Nguyễn Nhật Ánh", " NXB Trẻ", 2008,10, 4, "", "../public/images/romance/Cho_tôi_xin_một_vé_đi_tuổi_thơ.png"),
(27, "GỬI THỜI THANH XUÂN TƯƠI ĐẸP CỦA CHÚNG TA",90000,"Tân Di Ổ", " NXB Thanh Niên", 2020,9, 4, "", "../public/images/romance/gui_thoi_thanh_xuan_tuoi_dep_cua_chung_ta.png"),
(28, "ME BEFORE YOU",180000,"Jojo Moyes", " Michael Joseph", 2012,9, 4, "", "../public/images/romance/Me_Before_You.png"),
(29, "OUTLANDER",120000," Diana Gabaldon", " NXB Văn Học", 1991,9, 4, "", "../public/images/romance/Outlander.png"),
(30, "THE NOTEBOOK",350000,"Time Warner Book Group", " Không rõ", 1996,3, 4, "", "../public/images/romance/The_Notebook.png"),
(31, "IT ENDS WITH US",120000," Colleen Hoover", " Nhã Nam", 2024,9, 4, "", "../public/images/romance/It_Ends_With_Us.png"),
(32, "ĐẮC NHÂN TÂM",127000,"Dale Carnegie", " NXB Trẻ", 1936,7, 5, "", "../public/images/self_help/dac_nhan_tam.png"),
(33, "HẠT GIỐNG TÂM HỒN",80000,"Nhiều Tác Giả", " First News ", 2000,8, 5, "", "../public/images/self_help/hat_giong_tam_hon.png"),
(34, "MAKE YOUR BED",140000,"William H. McRaven", " Nhã Nam", 2020,6, 5, "", "../public/images/self_help/make_your_bed.png"),
(35, "NGƯỜI GIÀU CÓ NHẤT THÀNH BABYLON",79000,"George S. Clason", " Nhà xuất bản TP.HCM", 1926,4, 5, "", "../public/images/nguoi_giau_co_nha_thanh_Babylon/The_Notebook.png"),
(36, "NHÀ GIẢ KIM",130000,"Paulo Coelho ", " NXB Hội Nhà Văn", 1988,8, 5, "", "../public/images/self_help/nha_gia_kim.png"),
(37, "SỨC MẠNH TIỀM THỨC",158000,"Dr. Joseph Murphy", " NXB Tổng hợp TP.HCM.", 2022,8, 5, "", "../public/images/self_help/suc_manh_tiem_thuc.png"),
(38, "TÔI TÀI GIỎI BẠN CŨNG THẾ",80000,"Adam Khoo", " NXB Phụ Nữ", 2007,12, 5, "", "../public/images/self_help/toi_tai_gioi_ban_cung_the.png"),
(39, "THE POWER OF NOW",350000,"Eckhart Tolle.", " NXB Tổng Hợp TP.HCM.", 2021,9, 5, "", "../public/images/self_help/the_power_of_now.png");

CREATE  TABLE book_coopies (
	book_copies_id int(10) NOT NULL PRIMARY KEY,
    book_id int(10) NOT NULL,
    barcode varchar(255),
    book_status enum('Pending', 'Approved') 
    
);

CREATE TABLE users (
	user_id int(10) NOT NULL PRIMARY KEY,
    username varchar(50),
    full_name varchar(50),
    password varchar(255),
    gender bit,
    date_of_birth datetime,
    email varchar(100),
    phone varchar(15),
    address varchar(100),
    role int,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    user_status int(2) DEFAULT 1    
);
INSERT INTO users(user_id, username, full_name, password, gender, date_of_birth, email, phone, address, role) VALUES
(1, "ThuyTrang", "Nguyễn Thùy Trang", "tr@ng150626", 1, 15-06-2006, "nguyenthuytrang2021bd@gmail.com", "0347395104", "Sơn Trà, Đà Nẵng", 1);
SELECT * FROM users;
CREATE TABLE borrow_requests (
	borrow_request_id int(10) NOT NULL PRIMARY KEY,
    user_id int(10) NOT NULL,
    schedule_return_date datetime,
    request_date datetime,
    actual_return_date datetime,
    quantity int,
    request_status enum('Pending', 'Approved', 'Rejected', 'Returned')
);

CREATE TABLE borrow_request_books(
	borrow_request_book_id int(10) NOT NULL PRIMARY KEY,
	borrow_request_id int(10),
    book_categories_name varchar(50)    
);

