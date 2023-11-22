function validateInputs(){
    let numberOfPagesInput = document.getElementById('number-of-pages');
    let refillDateInput = document.getElementById('refill-date');

    let numberOfPages = String(numberOfPagesInput.value);
    let refillDate = String(refillDateInput.value)

    if (numberOfPages.length == 0){
        window.alert("Vui lòng nhập số trang in mặc định!");
        return false;
    }

    if (refillDate.length == 0){
        window.alert("Vui lòng nhập ngày cung cấp trang in!");
        return false;
    }

    window.alert("Cập nhật thành công");
}