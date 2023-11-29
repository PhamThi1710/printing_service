<?php
@include '../local/database.php';
if (isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year'])) {
    if ($_POST['day'] / 10 == 0)
        $day = '0' . $_POST['day'];
    else
        $day = $_POST['day'];
    if ($_POST['month'] / 10 == 0)
        $month = '0' . $_POST['month'];
    else
        $month = $_POST['month'];
    $year = $_POST['year'];
    $sql = "select perform.starttime, perform.endtime, requestprint.state as state_requestprint, 
        requestprint.total_sheet, file.name as filename, user.fullname as student_name, printer.model as printer_model
        from perform join requestprint on perform.requestid = requestprint.id 
        join printer on perform.printerId = printer.id 
        join file on requestprint.fileid = file.id 
        join user on requestprint.userid = user.id
            where YEAR(starttime)=$year and MONTH(starttime)=$month and DAY(starttime)=$day order by starttime desc;";
    $res = mysqli_query($conn, $sql);
} else {
    $result = mysqli_query($conn, "select perform.starttime, perform.endtime, requestprint.state as state_requestprint, 
    requestprint.total_sheet, file.name as filename, user.fullname as student_name, printer.model as printer_model
    from perform join requestprint on perform.requestid = requestprint.id 
    join printer on perform.printerId = printer.id 
    join file on requestprint.fileid = file.id 
    join user on requestprint.userid = user.id order by starttime desc;");
} ?>