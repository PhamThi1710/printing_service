<?php
@include '../local/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPSO_Log</title>

    <!-- swiper css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <!-- remix icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <!-- custom css file link -->
    <link rel="stylesheet" type="text/css" href="../local/style.css">
</head>

<body>
    <!-- header section starts -->

    <section class="header">
        <div class="logo">
            <a href="#">
                <img src="/printing_service/image/logo.png" alt="logo" />
                <p>ĐẠI HỌC QUỐC GIA TP.HCM<br>TRƯỜNG ĐẠI HỌC BÁCH KHOA</p>
            </a>
        </div>

        <a href="login.php" class="login">Đăng nhập</a>
    </section>
    <!-- header section ends -->

    <div class="body-side">
        <h2>NHẬT KÝ SỬ DỤNG DỊCH VỤ IN CỦA SINH VIÊN</h2>
        <div style="width:800px;height:30px; ">
            <div>
                <form id="wrapper-selectDate" action="../SPSO_log/spso_log.php" method="post">
                    <p style="font-size:15px">Chọn ngày bắt đầu:</p>
                    <input type="date" id="selectedDate" name="startday" />
                    <p style="font-size:15px">Chọn ngày kết thúc:</p>
                    <input type="date" id="selectedDate" name="endday" />
                    <p><button class="button" type="submit">Submit</button></p>
                </form>
                <form action="../SPSO_log/spso_log.php" method="post">
                    <input class="button" type="submit" name="all" value="Xem tất cả" />
                </form>
            </div>
        </div>
        <style>
            #spso_log_table {
                table-layout: fixed;
            }

            #spso_log_table col {
                width: 240px;
            }

            #spso_log_table thead th {
                padding: 10px;
            }

            #spso_log_table tbody tr td {
                padding: 10px;
            }

            #wrapper-selectDate {
                display: flex;
            }

            #wrapper-selectDate p,
            #wrapper-selectDate input {
                margin-right: 1%;
            }

            #wrapper-selectDate p {
                color: var(--main-color);
                font-weight: 600;
            }
        </style>
        <section>

            <table border="1" id="spso_log_table" style="overflow-y:scroll;height:300px;display:block;">
                <colgroup>
                    <col span="6">
                </colgroup>

                <thead>
                    <tr>
                        <th>Tên sinh viên</th>
                        <th>Nội dung đăng ký in</th>
                        <th>Số giấy đã trả</th>
                        <th>Thời gian bắt đầu in</th>
                        <th>Thời gian kết thúc in</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    function changeNumForm($date)
                    {
                        if ($date / 10 == 0)
                            $res = '0' . $date;
                        else
                            $res = $date;
                        return $res;
                    }
                    function handle_date($date)
                    {
                        $date = explode("-", $date);
                        $getDay = changeNumForm($date[2]);
                        $getMonth = changeNumForm($date[1]);
                        $getYear = $date[0];
                        return array($getYear, $getMonth, $getDay);

                    }
                    if (isset($_POST['startday']) && isset($_POST['endday'])) {
                        list($start_Year, $start_Month, $start_Day) = handle_date($_POST['startday']);
                        list($end_Year, $end_Month, $end_Day) = handle_date($_POST['endday']);
                        $result = mysqli_query($conn, "select perform.starttime, perform.endtime, requestprint.state as state_requestprint, 
                            requestprint.total_sheet, file.name as filename, user.fullname as student_name, printer.model as printer_model
                            from perform join requestprint on perform.requestid = requestprint.id 
                            join printer on perform.printerId = printer.id 
                            join file on requestprint.fileid = file.id 
                            join user on requestprint.userid = user.id
                                where starttime between '$start_Year-$start_Month-$start_Day 00:00:00' and '$end_Year-$end_Month-$end_Day 23:59:00' order by starttime desc;");
                    } else {
                        $result = mysqli_query($conn, "select perform.starttime, perform.endtime, requestprint.state as state_requestprint, 
                        requestprint.total_sheet, file.name as filename, user.fullname as student_name, printer.model as printer_model
                        from perform join requestprint on perform.requestid = requestprint.id 
                        join printer on perform.printerId = printer.id 
                        join file on requestprint.fileid = file.id 
                        join user on requestprint.userid = user.id order by starttime desc;");
                    }
                    $data = $result->fetch_all(MYSQLI_ASSOC);
                    foreach ($data as $row) {
                        echo '
                        <tr>
                            <td>
                                ' . $row["student_name"] . '
                            </td>
                            <td>
                                ' . $row['filename'] . '
                            </td>
                            <td>
                                ' . $row['total_sheet'] . '
                            </td>
                            <td>
                                ' . $row['starttime'] . '
                            </td>
                            <td>
                                ' . $row['endtime'] . '
                            </td>
                            <td> ';
                        if ($row['state_requestprint'] == '0')
                            $state = '<a  class="payment_link_text">Đã lưu</a>';
                        else if ($row['state_requestprint'] == '1')
                            $state = 'Đã hoàn thành';
                        else
                            $state = 'Đã gửi in';
                        echo $state;
                        echo '
                            </td>
                        </tr> 
                 ';
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
    <style>
        /* Design Calendar */
        #calendar-start {
            background-color: #ffffff;
            text-align: center;
            border-radius: 0%;
            z-index: 100000;
            display: block;
        }

        #calendar-start .days li.today,
        #calendar-end .days li.today {
            color: rgba(255, 0, 0, 0.321);
            font-weight: 1000;
        }
    </style>
    <!-- footer section starts -->
    <div class="footer-container">
        <section class="footer">
            <div class="box-container">
                <div class="box">
                    <h3>STUDENT SMART PRINTING SERVICE</h3>
                    <img src="/printing_service/image/logo.png" alt="logo" />
                </div>

                <div class="box">
                    <h3>WEBSITE</h3>
                    <a href="https://hcmut.edu.vn/" class="hcmut">HCMUT</a>
                    <a href="https://mybk.hcmut.edu.vn/my/index.action" class="mybk">MyBK</a>
                    <a href="https://mybk.hcmut.edu.vn/bksi/public/vi/" class="bksi">BKSI</a>
                </div>

                <div class="box">
                    <h3>CONTACT</h3>
                    <a href="#">
                        <div class="location-icon"></div>268 Ly Thuong Kiet Street Ward 14, District 10, Ho Chi Minh
                        City, Vietnam
                    </a>
                    <a href="#">
                        <div class="phone-icon"></div>(028) 38 651 670 - (028) 38 647 256 (Ext: 5258, 5234)
                    </a>
                    <a href="mailto:elearning@hcmut.edu.vn" class="email">
                        <div class="email-icon"></div>elearning@hcmut.edu.vn
                    </a>
                </div>
            </div>
        </section>
        <div class="copyright">
            <p>Copyright 2007-2022 BKEL - Phát triển dựa trên Moodle</p>
        </div>
    </div>
    <!-- footer section ends -->
    <!-- swiper js link -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- custom js file link -->
    <script src="../local/script.js"></script>
    <!--jquery cdn link-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

</body>

</html>