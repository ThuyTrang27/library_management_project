<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php?action=do_import_book" method="POST" enctype="multipart/form-data">
    <label for="fileExcel">Chọn file Excel để Import:</label>
    <input type="file" name="excel_file" id="fileExcel" accept=".xlsx, .xls" required>
    <button type="submit">Import ngay</button>
</form>
</body>
</html>