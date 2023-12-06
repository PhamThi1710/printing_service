<?php
@include '../ConnectDB.php';
if (isset($_GET['send_confirm_id'])) {
    $id = $_GET['send_confirm_id'];
    $del = " UPDATE requestprint set state=2 WHERE id in (select requestid from request_perform_printer where id='$id')";
    mysqli_query($conn, $del);
    header('location:activitylog.php');
}
?>