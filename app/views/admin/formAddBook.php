<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book borrow information</title>
    <link rel="stylesheet" href="../../../public/css/formAddBook.css" class="">
</head>
<body>
    <?php  require_once __DIR__ . '/../layouts/headerAdmin.php';?>
    <div class="add-book-container">
    <h2 class="title-blue" style="text-align:center;">Add new book</h2>  
   
    <form action="index.php?action=addbook" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label>Book title</label>
        <input type="text" name="book_title" required placeholder="Book title">
    </div>

    <div class="form-group">
        <label>Author</label>
        <input type="text" name="author" required placeholder="Author">
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <select id="category" name="categories_id" >
            <option value="">Category</option>
            <option value="1">Fantasy</option>
            <option value="2">Literature</option>
            <option value="3">Mystery</option>
            <option value="4">Romantic</option>
            <option value="5">Self-help</option>
            <option value="6">Science Fiction</option>
        </select>
    </div>  

    <div class="form-group-flex">
        <div class="form-group">
            <label>Price</label>
            <input type="text" name="price" class="price" required placeholder="Price">
        </div>
        <div class="form-group">
            <label>Stock quantity</label>
            <input type="number" name="stock_quantity" class="stock_quantity" required placeholder="Stock quantity">
        </div>        
    </div>

    <div class="form-group-flex">
        <div class="form-group">
            <label>Pulisher</label>
            <input type="text" name="publisher" required placeholder="Pulisher">
        </div>
        <div class="form-group">
            <label>Pulish year</label>
            <input type="text" name="publish_year" class="publish_year" required placeholder="Pulish year">
        </div>        
    </div>

    <div class="form-group">
        <label for="book_image">Book Image</label>
        <input type="file" name="book_image" class="book_image"style="background-color: white;">
    </div>  
    
    <div class="form-group" style="flex-direction: column; align-items: flex-start; gap: 10px;">
        <label>Content</label>
        <input name="content" class="content-area"></input>
    </div>

    <div class="button-group">
        <button type="submit" class="btn-submit">Submit</button>
        <button type="button" class="btn-cancel" onclick="window.history.back()">Cancel</button>
    </div>
</form>
</div>
</form>
 <?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>