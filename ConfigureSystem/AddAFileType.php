<?php
    @include_once("../ConnectDB.php");

    $File_Type = $_POST["File_Type"];

    $sql = "INSERT INTO Accepted_File_Types(File_Type)
            VALUE ('$File_Type')
            ";

    $conn->query($sql);
?>