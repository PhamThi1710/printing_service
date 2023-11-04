<?php
@include 'database.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $del = " DELETE FROM request_perform_printer WHERE id = '$id'; ";
    mysqli_query($conn, $del);
    header('location:activitylog.php');
}
?>