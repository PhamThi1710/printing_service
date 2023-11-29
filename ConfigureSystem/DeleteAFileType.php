<?php
    @include_once("../ConnectDB.php");

    $File_Type = $_POST["File_Type"];

    $sql = "DELETE FROM Accepted_File_Types WHERE File_Type = '$File_Type'";

    $result = $conn->query($sql);
?>
