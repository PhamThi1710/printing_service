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
            <!-- TODO: press confirm THEN send the request, not press the button -->
            <div class="change-printer-state">
                <div class="c-s-1-group">
                    <div class="c-s-12">
                        <button class="choose-button" name="selection" onclick="setPrinterState('Bật')"></button>
                        <div class="bt">Bật</div>
                    </div>
                    <div class="c-s-12">
                        <button class="choose-button" name="selection" onclick="setPrinterState('Tắt')"></button>
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
            setPrinterState(this.textContent.trim()); // Set the printer state based on the button text
        });
    });

    var upcomingPrinterState = ''; // Variable to store the upcoming printer state

    function setPrinterState(state) {
        upcomingPrinterState = state === 'Bật' ? 'Y' : state === 'Tắt' ? 'N' : '';
    }

    function executeQuery() {
        var printerID = document.querySelector('input[name="printerID"]').value;

        if (printerID.trim() === '') {
            $('#idExistsText').text("ID is NULL").css('display', 'inline');
            return;
        }

        // Store the selected printer ID
        var selectedPrinterID = printerID;

        // Execute the query only when the "Tiếp tục" button is clicked
        if (upcomingPrinterState === 'Y' || upcomingPrinterState === 'N') {
            $.ajax({
                type: "POST",
                url: "changeState.php",
                data: { printerID: selectedPrinterID, selection: upcomingPrinterState },
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
</script>

</html>