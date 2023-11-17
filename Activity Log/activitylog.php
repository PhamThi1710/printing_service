<?php
@include '../local/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log</title>

    <!-- swiper css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <!-- remix icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <!-- custom css file link -->
    <link rel="stylesheet" type="text/css" href="/printing_service/local/style.css">
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



    <!--POP UP -->
    <!-- Send print request POP UP  -->
    <?php

    if (isset($_GET['send_id'])) {
        $send_id = $_GET['send_id'];
        // Get request ID
        $filter_requestid = mysqli_query($conn, "select * from perform where id ='$send_id'");
        $get_requestid = mysqli_fetch_array($filter_requestid);
        $requestid_ = $get_requestid["requestid"];
        // Get file info
        $popup_dtfile = mysqli_query($conn, "SELECT * FROM file where id in (select fileid from requestprint where id='$requestid_')");
        $get_file_ = mysqli_fetch_array($popup_dtfile);
        // Get request info
        $printerid_ = $get_requestid['printerId'];
        $popup_dtrequest = mysqli_query($conn, "select * from requestprint where id ='$requestid_'");
        $get_request_ = mysqli_fetch_array($popup_dtrequest);
        //Get printer info
        $popup_dtprinter = mysqli_query($conn, "SELECT * FROM printer where id='$printerid_'");
        $get_printer_info_ = mysqli_fetch_array($popup_dtprinter);
        $display_printer_info_ = $get_printer_info_['model'] . ' - Cơ sở ' . $get_printer_info_['Unibranch'] . ' - ' . $get_printer_info_['building'] . ' - ' . $get_printer_info_['room'];
        //Get user info
        $popup_dtuser = mysqli_query($conn, "SELECT * FROM user where id in (select userid from requestprint where id='$requestid_')");
        $get_user = mysqli_fetch_array($popup_dtuser);
        $Now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));

        //  <!--End get data task -->
        echo '<div class="popup" id="sendprint_popup">
            <img src="/printing_service/image/message.jpg" width="50px" height="50px">
            <div class="popup_text">
                <h3 style="margin-top:5%; color:var(--main-color)">Gửi yêu cầu in</h3>
                <table>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-timer-fill"></i>Thời gian:</th>
                        </td>
                        <td>
                          ' . $Now->format('Y-m-d H:i:s') . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-user-fill"></i>Tên người dùng:</th>
                        </td>
                        <td>
                           ' . $get_user["fullname"] . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-file-fill"></i>Tập tin đã chọn:</th>
                        </td>
                        <td>
                           ' . $get_file_["name"] . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-file-paper-2-fill"></i>Số mặt in:</th>
                        </td>
                        <td>
                            ' . $get_request_["numbersides"] . ' 
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-file-copy-fill"></i>Số bản copy:</th>
                        </td>
                        <td>
                            ' . $get_request_["numbercopies"] . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-file-list-3-fill"></i>Số trang trên một tờ giấy in:</th>
                        </td>
                        <td>
                            ' . $get_request_["paper_per_sheet"] . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-file-paper-fill"></i>Khổ giấy:</th>
                        </td>
                        <td>
                            ' . $get_request_["papersize"] . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-printer-fill"></i>Máy in:</th>
                        </td>
                        <td>
                           ' . $display_printer_info_ . '
                        </td>
                    </tr>';
        $popup_dtlistpages = mysqli_query($conn, "select page from listpages where performid='$send_id'");
        $list = array();
        while ($list_child = mysqli_fetch_assoc($popup_dtlistpages)) {
            $list[] = $list_child['page'];
        }
        $display = implode(", ", $list);
        echo '<tr>
                        <td>
                        <th class="title_"><i class="ri-list-check"></i>Số trang muốn in:</th>
                        </td>
                        <td>
                           ' . $display . '
                        </td>
                    </tr>
                </table>
        <div class="button-group">
            <button onclick="ClosePopup(\'sendprint_popup\')" class="button" type="button">Thoát</button>
            <a class="button" href="send_activitylog.php?send_confirm_id=' . $send_id . '" type="button">Xác nhận</a>
        </div>
        </div>
    </div>';
    } ?>
    <!-- END Send print request POP UP  -->
    <!-- ---------------------------------------------------------------------------------------------------------- -->
    <!-- Confirm delete request POP UP -->
    <?php
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        echo ' <div class="popup" id="DELETE_popup">
            <img src="/printing_service/image/message.jpg" width="50px" height="50px">
            <div class="popup_text">
                <h2 style="margin-top:5%; color:var(--main-color)">Message:</h2>
                <h4 style="color:var(--text-color)">Bạn có chắc chắn muốn xóa không?</h4>
            </div>
            <div class="button-group">
                <button onclick="ClosePopup(\'DELETE_popup\')" class="button" type="button">Thoát</button>
                <a class="button" href="delete_activitylog.php?id=' . $delete_id . '">Xóa</a>
            </div>
        </div>';
    } ?>
    <!-- END Confirm delete request POP UP  -->
    <!-- ---------------------------------------------------------------------------------------------------------- -->
    <!-- Delete multiple request POP UP -->
    <?php
    if (isset($_GET['DELETE_range'])) {
        echo ' <div class="popup" id="DELETE_range">
        <img src="/printing_service/image/message.jpg" width="50px" height="50px">
        <div class="popup_text">
            <div class="delete_range">
                <div class="delete_range1">
                    <p>Xóa theo khoảng thời gian:</p>
                </div>
                <div class="delete_range1">
                    <select id="delete_range_select">
                        <option value="delete_start">Chọn khoảng thời gian</option>
                        <option value="delete_hour=true">1 giờ trước</option>
                        <option value="delete_day=true">1 ngày trước</option>
                        <option value="delete_week=true">1 tuần trước</option>
                        <option value="delete_month=true">1 tháng trước</option>
                        <option value="delete_year=true">1 năm trước</option>
                    </select>
                </div>

            </div>
            <div class="button-group">
                <a href="delete_activitylog.php?confirm_delete_range=true" class="button" type="button">Xác
                    nhận
                    xóa</a>
                <button onclick="ClosePopup(\'DELETE_range\')" class="button" type="button">Thoát</button>
            </div>
        </div>
    </div>';
    }
    ;
    if (isset($_GET['DELETE_particularDay'])) {
        echo '<div class="popup" id="DELETE_particularDay">
        <img src="/printing_service/image/message.jpg" width="50px" height="50px">
        <div class="popup_text">
            <div class="delete_range">
                <div class="delete_range1">
                    <p>Chọn một ngày cụ thể:</p>
                </div>
                <div class="delete_range1"><i class="ri-calendar-2-fill"
                        onclick="_(\'calendar\').classList.add(\'display_calendar\')"></i></div>

            </div>
            <div class="button-group">
                <button onclick="deleteActiveClass()" class="button" type="button">Xác nhận xóa</button>
                <button onclick="ClosePopup(\'DELETE_particularDay\')" class="button" type="button">Thoát</button>
            </div>
            <p style="font-size:10px">Note: Chỉ có thể xóa các yêu cầu in ở trạng thái "Đã hoàn thành" </p>
            <div class="wrapper" id="calendar">
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
    </div>';
    } ?>

    <script>
        function deleteActiveClass() {
            var listActiveDays = document.querySelectorAll('.active');
            for (var i = 0; i < listActiveDays.length; ++i) {
                let date = listActiveDays[i].textContent;
                const splitDate = date.split(" ");
                $.post("delSelectDay.php", { day: splitDate[0], month: splitDate[1], year: splitDate[2] },
                    function (data, status) {
                        ClosePopup('DELETE_particularDay');
                        alert("\nStatus: " + status);
                    });
            }

        }
    </script>
    <!-- END Delete multiple request POP UP  -->
    <!-- END POP UP -->

    <?php
    $result = mysqli_query($conn, "select perform.id, perform.starttime, perform.endtime,file.name as filename,
    file.totalpage, requestprint.numbersides, requestprint.numbercopies, requestprint.paper_per_sheet, 
    requestprint.papersize, printer.model as printer_model,requestprint.state as state_requestprint from perform 
    join requestprint on perform.requestid = requestprint.id 
    join printer on perform.printerId = printer.id 
    join file on requestprint.fileid = file.id;");
    $data = $result->fetch_all(MYSQLI_ASSOC);
    ?>
    <div class="body">
        <h2>NHẬT KÝ SỬ DỤNG DỊCH VỤ IN</h2>
        <section>
            <table border="1" style="   overflow-y:scroll;
   height:300px;
   display:block;">
                <tr>
                    <th>Thời gian bắt đầu in</th>
                    <th>Thời gian kết thúc in</th>
                    <th>Nội dung đăng ký in</th>
                    <th>Tổng số page</th>
                    <th>Số mặt</th>
                    <th>Số bản copy</th>
                    <th>Số<br>trang<br>trên<br>giấy in</th>
                    <th>Khổ giấy</th>
                    <th>Mã máy in</th>
                    <th>Trạng thái</th>
                    <th>Tùy chọn</th>
                </tr>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td>
                            <?= $row['starttime'] ?>
                        </td>
                        <td>
                            <?= $row['endtime'] ?>
                        </td>
                        <td>
                            <?= $row['filename'] ?>
                        </td>
                        <td>
                            <?= $row['totalpage'] ?>
                        </td>
                        <td>
                            <?= $row["numbersides"] ?>
                        </td>
                        <td>
                            <?= $row["numbercopies"] ?>
                        </td>
                        <td>
                            <?= $row["paper_per_sheet"] ?>
                        </td>
                        <td>
                            <?= $row["papersize"] ?>
                        </td>
                        <td>
                            <?= $row['printer_model'] ?>
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
                        <td>
                            <div class="dropdown" style="float:right;">
                                <i style="font-size:25px " class="ri-arrow-down-s-fill dropbtn"></i>
                                <div class="dropdown-content">
                                    <a href="activitylog.php?send_id=<?= $row['id'] ?>">Send</a>
                                    <?php
                                    if ($row['state_requestprint'] == '0' || $row['state_requestprint'] == '1')
                                        echo '<a href="activitylog.php?delete_id=' . $row['id'] . '">Delete</a>';
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>

            </table>
            <div class="dropdown" style="float:right; margin: 1%; padding:0.3%">
                <button type="button" class="button" id="delete_multi"><i class="ri-arrow-down-s-fill dropbtn"></i>Xóa
                    nhiều file</button>
                <div class="dropdown-content">
                    <a type="button" href="activitylog.php?DELETE_range=true">Xóa theo khoảng thời gian</a>
                    <a type="button" href="activitylog.php?DELETE_particularDay=true">Xóa theo ngày cụ thể</a>
                </div>
            </div>
        </section>
    </div>


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
    <!--<script src="activitylog_script.js"></script>-->
    <script src="/printing_service/local/script.js"></script>
    <!--jquery cdn link-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

</body>

</html>