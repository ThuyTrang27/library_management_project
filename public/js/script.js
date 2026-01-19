
    // Tìm tất cả các ô input có thuộc tính 'required'
    const inputs = document.querySelectorAll('input[required]');
    
    inputs.forEach(input => {
        // Khi ô đó bị trống lúc nhấn Submit
        input.oninvalid = function(e) {
            e.target.setCustomValidity("Please fill out this field.");
        };
        // Khi người dùng bắt đầu gõ thì xóa thông báo lỗi đi để họ nhấn Submit lại được
        input.oninput = function(e) {
            e.target.setCustomValidity("");
        };
    });
