<?php 
    switch ($action) {
    case 'add_to_mybook':
        $controller->addToMyBook($_GET['id'], $_GET['title'], $_GET['author'], $_GET['img']);
        break;
        
    case 'mybook':
        $controller->showMyBook();
        break;
        
    case 'show_borrow_form':
        // Hiển thị file formBorrowRequest.php
        include 'views/formBorrowRequest.php'; 
        break;
        
    case 'submit_borrow':
        $controller->submitRequest(); // Hàm mình viết ở câu trả lời trước
        break;
}
?>