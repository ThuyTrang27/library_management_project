
function updateQty(bookId, change) {
    let qtyElement = document.getElementById('qty-' + bookId);
    let currentQty = parseInt(qtyElement.innerText);
    let newQty = currentQty + change;

    // Nếu số lượng mới > 0, cập nhật như bình thường
    if (newQty > 0) {
        qtyElement.innerText = newQty;
        fetch(`index.php?action=update_cart_qty&id=${bookId}&qty=${newQty}`);
    } 
    // Nếu số lượng mới bằng 0, thực hiện xóa
    else {
        if (confirm("Do you want to remove this book from the list?")) {
            fetch(`index.php?action=remove_from_cart&id=${bookId}`)
                .then(() => {
                    // Tìm phần tử cha (book-card) và xóa nó khỏi giao diện
                    let bookCard = qtyElement.closest('.book-card');
                    bookCard.remove();
                    
                    // Nếu sau khi xóa mà không còn sách nào, có thể reload để hiện thông báo trống
                    location.reload(); 
                });
        }
    }
}