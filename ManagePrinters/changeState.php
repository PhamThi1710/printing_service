<?php

@include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $printerID = $_POST['printerID'];
    $selection = $_POST['selection'];
    if ($selection == 'ON' or $selection == 'Bật') {
        $query = "UPDATE PRINTERS_LIST SET PRINTERS_AVAI = 'Y' WHERE PRINTERS_ID = '$printerID'";
    } elseif ($selection == 'OFF' or $selection == 'Tắt') {
        $query = "UPDATE PRINTERS_LIST SET PRINTERS_AVAI = 'N' WHERE PRINTERS_ID = '$printerID'";
    }
    if (!empty($query)) {
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
        } else {
            if ($stmt->execute()) {
                echo "Printer state updated successfully";
            } else {
                echo "Error updating printer state: " . $stmt->error;
            }
        }
    }
}

?>