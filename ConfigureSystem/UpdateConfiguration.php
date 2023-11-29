<?php
    @include_once("../ConnectDB.php");

    if(isset($_POST['submit-configuration'])) {
        // Get Quantity
        $Default_Number_Of_Pages = $_POST['number-of-pages'];
        $Paper_Price = $_POST['paper-price'];
        $Refill_Date = $_POST['refill-date'];
        
        // INSERT into DB
        $sql = "UPDATE `Configuration`
                SET Default_Number_Of_Pages = '$Default_Number_Of_Pages',
                Paper_Price = '$Paper_Price',
                Refill_Date = '$Refill_Date'
                WHERE ID = '0';
            ";
    
        $conn->query($sql);
       
    }

    header("Location: ConfigureSystem.php");
?>