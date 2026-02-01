<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Book</title>
    <link rel="stylesheet" href="../../../public/css/style.css" class="">
</head>
<body>
    <?php  require_once __DIR__ . '/../layouts/headerAdmin.php';?>
    <div class="container-import">
        <form action="index.php?action=do_import_book" method="POST" enctype="multipart/form-data">
            <h3>Import Book</h3>
            <div class="input-file">
                <label for="fileExcel">Chọn file Excel để Import:</label>
                <input type="file" name="excel_file" id="fileExcel" accept=".xlsx, .xls" required>
            </div>       
            <button type="submit" class="button-import">Import Now</button>
        </form>
    </div>
    
</body>
</html>