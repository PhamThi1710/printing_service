$(document).ready(function () {
    $("button.delete-file-type").click(function (e) { 
        
        e.preventDefault();
        
        let value = confirmDelete();

        if(value == false) return false;

        $.ajax({
            type: "POST",
            url: "DeleteAFileType.php",
            data: {
                File_Type: value
            },
            success: function (response) {
                window.alert('Xóa định dạng tập tin thành công!');
                window.location.reload()
            },
            fail: function () {
                window.alert('Xóa định dạng tập tin thất bại. Vui lòng thử lại!');
            }
        });
    });

    $("button.add-file-type").click(function (e) { 
        e.preventDefault();
        
        let value = validateFileType();

        if(value == false) return false;

        $.ajax({
            type: "POST",
            url: "AddAFileType.php",
            data: {
                File_Type: value
            },
            success: function (response) {
                window.alert('Thêm định dạng tập tin thành công!');
                window.location.reload()
            },
            fail: function () {
                window.alert('Thên định dạng tập tin thất bại. Vui lòng thử lại!');
            }
        });
    });
});

function validateInputs(){
    let numberOfPagesInput = document.getElementById('number-of-pages');
    let refillDateInput = document.getElementById('refill-date');
    let paperPriceInput = document.getElementById('paper-price');

    let numberOfPages = String(numberOfPagesInput.value);
    let refillDate = String(refillDateInput.value);
    let paperPrice = String(paperPriceInput.value);

    if (numberOfPages.length == 0){
        window.alert("Vui lòng nhập số trang in mặc định!");
        return false;
    }

    if (paperPrice.length == 0){
        window.alert("Vui lòng nhập số trang in mặc định!");
        return false;
    }

    if (refillDate.length == 0){
        window.alert("Vui lòng nhập ngày cung cấp trang in!");
        return false;
    }

    window.alert("Cập nhật thành công");
}

function confirmDelete() {
    let res = window.confirm('Bạn muốn xóa định dạng tập tin này?');

    if(res == false) return false;
    
    return document.activeElement.value;
}

function validateFileType() {
    let fileType = document.getElementById('file-type').value.trim();

    if(fileType == "") {
        window.alert('Vui lòng nhập định dạng tập tin mà bạn muốn thêm!');
        return false;
    }

    if(fileType.indexOf(".") != 0) {
        window.alert('Định dạng tập tin không hợp lệ!');
        return false;
    }
    
    return fileType;
}