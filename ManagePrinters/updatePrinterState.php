<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./globalManagePrinter.css" />
    <link rel="stylesheet" href="./updatePrinterState.css" />
    <!-- <link rel="stylesheet" href="./addPrinter.css" /> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" />

    <!-- swiper css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <p class="bt-tt">BẬT / TẮT MÁY IN</p>
        <form method="POST">
            <div class="input-ID">
                <div class="menu">
                    <div class="input-text">Nhập ID máy in</div>
                    <div class="input">
                        <input type="text" name="printerID" class="ID-text .input-text1" required
                            oninput="checkPrinterID(this.value)"></input>
                    </div>
                    <!-- <span id="idExistsText" class="id-check-text"></span> -->
                </div>
                <div class="menu">
                    <div class="input-text">Xác nhận ID máy in</div>
                    <div class="input">
                        <input type="text" name="validatePrinterID" class="ID-text" required></input>
                    </div>
                    <!-- <button class="check-button" onclick="clearTextID()">Check</button> -->

                </div>
            </div>

            <div class="change-printer-state">
                <div class="c-s-1-group">
                    <div class="c-s-12">
                        <button class="choose-button" name="selection" onclick="setPrinterState('ON')"></button>
                        <div class="bt">Bật</div>
                    </div>
                    <div class="c-s-12">
                        <button class="choose-button" name="selection" onclick="setPrinterState('OFF')"></button>
                        <div class="bt">Tắt</div>
                    </div>
                </div>
            </div>

            <div class="confirm-change">
                <button class="button" id="back">
                    <div class="tip-tc">Quay lại</div>
                </button>
                <button class="button1" id="confirm" onclick="executeQuery()">
                    <div class=" tip-tc">Tiếp tục
                    </div>
                </button>
            </div>
        </form>


    </div>
</body>
<script>
    // turn clicked button black
    var buttons = document.querySelectorAll('.choose-button');

    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            buttons.forEach(function (btn) {
                btn.classList.remove('active-button');
            });

            this.classList.add('active-button');
        });
    });
    var selectedState = '';

    function executeQuery() {
        var printerID = document.querySelector('input[name="printerID"]').value;

        if (printerID.trim() === '') {
            $('#idExistsText').text("ID is NULL").css('display', 'inline');
            return;
        }

        // Store the selected printer ID
        var selectedPrinterID = printerID;

        var confirmButton = document.getElementById('confirm');
        if (!confirmButton.classList.contains('clicked')) {
            confirmButton.classList.add('clicked');
            return;
        }

        // Execute the query only when the "Tiếp tục" button is clicked
        if (selectedState === 'Bật' || selectedState === 'Tắt') {
            $.ajax({
                type: "POST",
                url: "changeState.php",
                data: { printerID: selectedPrinterID, selection: selectedState },
                success: function (response) {
                    // Display the response message
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    // Display the error message
                    console.log(error);
                }
            });
        }
    }

    // Function to set the selected state when the Bật or Tắt button is clicked
    function setPrinterState(state) {
        selectedState = state;
    }
    // function clearTextID() {

    //     var inputElement = $('.input-text1');
    //     var inputValue = inputElement.val();

    //     if (inputValue.trim() === '') {
    //         $('#idExistsText').text("ID is NULL").css('display', 'inline');
    //         return;
    //     }

    //     inputElement.css('color', 'black');
    //     $.ajax({
    //         type: "POST",
    //         url: "checkID.php",
    //         data: { name="printerID" },
    //         success: function (response) {
    //             // If the ID exists, change the color to red
    //             if (response == 'exists') {
    //                 inputElement.css('color', 'red');
    //                 inputElement.css('font-weight', 'bold');
    //                 $('#idExistsText').text("ID already exists").css('display', 'inline');
    //             }
    //             // If the ID does not exist, change the color to green
    //             else {
    //                 inputElement.css('color', 'green');
    //                 inputElement.css('font-weight', 'bold');
    //                 $('#idExistsText').text("This ID is valid").css('display', 'inline');
    //             }
    //         }
    //     });
    // }

</script>

</html>