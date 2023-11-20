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
    <link rel="stylesheet" type="text/css" href="../SPSO_log/spsolog_style.css">
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
    <?php
    $result = mysqli_query($conn, "select perform.starttime, perform.endtime, requestprint.state as state_requestprint, 
    requestprint.total_sheet, file.name as filename, user.fullname as student_name, printer.model as printer_model
    from perform join requestprint on perform.requestid = requestprint.id 
    join printer on perform.printerId = printer.id 
    join file on requestprint.fileid = file.id 
    join user on requestprint.userid = user.id order by starttime desc;");
    ?>
    <div class="body">
        <h2>NHẬT KÝ SỬ DỤNG DỊCH VỤ IN CỦA SINH VIÊN</h2>
        <div style="float:right; width:500px;height:30px; margin-right:5%;">
            <div class="delete_range"
                style="width: 50%;align-items: left;text-align: left; padding: 0;margin: 0;float:left">
                <div class="delete_range1" style="float: left;width: 70%;">
                    <p style="font-size:15px">Chọn ngày bắt đầu</p>
                </div>
                <div class="delete_range1" style="float: right;width: 30%;"><i class="ri-calendar-2-fill"
                        onclick="_('calendar-start').classList.add('display_calendar')"></i>

                </div>

            </div>
            <div class="wrapper" id="calendar-start">
                <div class="header-calendar">
                    <p class="current-date"></p>
                    <div class="icons">
                        <i id="prev" class="ri-arrow-left-line"></i>
                        <i id="next" class="ri-arrow-right-line"></i>
                    </div>
                </div>
                <div class="calendar">
                    <ul class="weeks">
                        <li>Sun</li>
                        <li>Mon</li>
                        <li>Tue</li>
                        <li>Wed</li>
                        <li>Thu</li>
                        <li>Fri</li>
                        <li>Sat</li>
                    </ul>
                    <ul class="days"></ul>
                </div>
            </div>
            <div class="delete_range"
                style="width: 50%;align-items: left;text-align: left; padding: 0;margin: 0;float:left">
                <div class="delete_range1" style="float: left;width: 70%;">
                    <p style="font-size:15px">Chọn ngày kết thúc</p>
                </div>
                <div class="delete_range1" style="float: left;width: 30%;"><i class="ri-calendar-2-fill"
                        onclick="_('calendar-end').classList.add('display_calendar')"></i></div>

            </div>
            <div class="wrapper" id="calendar-end">
                <div class="header-calendar">
                    <p class="current-date"></p>
                    <div class="icons">
                        <i id="prev" class="ri-arrow-left-line"></i>
                        <i id="next" class="ri-arrow-right-line"></i>
                    </div>
                </div>
                <div class="calendar">
                    <ul class="weeks">
                        <li>Sun</li>
                        <li>Mon</li>
                        <li>Tue</li>
                        <li>Wed</li>
                        <li>Thu</li>
                        <li>Fri</li>
                        <li>Sat</li>
                    </ul>
                    <ul class="days"></ul>
                </div>
            </div>
        </div>

        <section>
            <table id="spso_log_table" style="overflow-y:scroll;height:300px;display:block;">
                <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <style>
                    #spso_log_table col {
                        width: calc(100% /6);
                    }
                </style>
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
                <?php $data = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($data as $row): ?>
                    <tbody>
                        <tr>
                            <td>
                                <?= $row['student_name'] ?>
                            </td>
                            <td>
                                <?= $row['filename'] ?>
                            </td>
                            <td>
                                <?= $row['total_sheet'] ?>
                            </td>
                            <td>
                                <?= $row['starttime'] ?>
                            </td>
                            <td>
                                <?= $row['endtime'] ?>
                            </td>

                            <td>
                                <?php
                                if ($row['state_requestprint'] == '0')
                                    $state = '<a  class="payment_link_text">Đã lưu</a>';
                                else if ($row['state_requestprint'] == '1')
                                    $state = 'Đã hoàn thành';
                                else
                                    $state = 'Đã gửi in';
                                ?>
                                <?= $state ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <div>
                <button style="float:right; margin: 1%; padding:0.3%" class="button" type="button">Xem nhật ký máy
                    in</button>
            </div>
        </section>
    </div>
    <style>
        /* Design Calendar */
        #calendar-start,
        #calendar-end {
            width: 250px;
            background-color: #ffffff;
            margin-left: auto;
            margin-right: auto;
            font-size: 15px;
            text-align: center;
            transition: all 2s ease;
            border-radius: 0%;
            display: none;
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