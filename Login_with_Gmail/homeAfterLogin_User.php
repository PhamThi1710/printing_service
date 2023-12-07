<<<<<<< HEAD
<?php
    session_start();
?>

=======
>>>>>>> 9dab8ccedab132acc0b1777cd520808a93df7760
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Dịch vụ sinh viên</title>
=======
    <title>trang chủ</title>

    <!-- swiper css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
>>>>>>> 9dab8ccedab132acc0b1777cd520808a93df7760

    <!-- custom css file link -->
    <link rel="stylesheet" type="text/css" href="style.css" >

</head>
<body>
    <!-- header section starts -->

    <section class="header">
<<<<<<< HEAD
        <div class="left-side">
            <div class="logo">
                <a href="#">
                    <img src="images/logo.png" alt="logo" />
                    <p>ĐẠI HỌC QUỐC GIA TP.HCM<br>TRƯỜNG ĐẠI HỌC BÁCH KHOA</p>
                </a>
            </div>

            <div class="menu-bar">
                <div class="first-option"><a href="">trang chủ</a></div>
                <div class="second-option"><a href="" >dịch vụ của tôi</a></div>
            </div>
        </div>
        
        <div class="right-side">
            <div class="first-option"><a href="infoUser.php">
                <?php
                    if (isset($_SESSION['user_info']) && !empty($_SESSION['user_info']['name'])) {
                        echo '<span class="user-name">' . htmlspecialchars($_SESSION['user_info']['name']) . '</span>';
                    }
                ?>
                </a>
            </div>
            <div class="seperator">|</div>
            <div>
                <a href="home.php" class="logout">Đăng xuất</a>
            </div>
        </div>
=======
        <div class="logo">
            <a href="#">
                <img src="images/logo.png" alt="logo" />
                <p>ĐẠI HỌC QUỐC GIA TP.HCM<br>TRƯỜNG ĐẠI HỌC BÁCH KHOA</p>
            </a>
        </div>
        <a href="home.php" class="logout">Đăng xuất</a> <!--Sửa lại chỗ này thành tên đầy đủ của người đăng nhập-->
>>>>>>> 9dab8ccedab132acc0b1777cd520808a93df7760
    </section>

    <!-- header section ends -->

<<<<<<< HEAD



    <!-- body section starts -->

    <div class="body">
        <h1 class="title">dịch vụ của tôi</h1>

        <div class="service-list">
            <div><a href="">đăng kí in tài liệu</a></div>
            <div><a href="">mua thêm trang in</a></div>
            <div class="last-service"><a href="">nhật kí sử dụng dịch vụ in</a></div>
        </div>
    </div>

    <!-- body section ends -->




    <!-- footer section starts -->
    <div class="footer-container">
        <section class="footer">
            <div class="box-container">
                <div class="box">
                    <h3>student smart printing service</h3>
                    <img src="images/logo.png" alt="logo" />
                </div>

                <div class="box">
                    <h3>website</h3>
                    <a href="https://hcmut.edu.vn/" class="hcmut">HCMUT</a>
                    <a href="https://mybk.hcmut.edu.vn/my/index.action" class="mybk">MyBK</a>
                    <a href="https://mybk.hcmut.edu.vn/bksi/public/vi/" class="bksi">BKSI</a>
                </div>

                <div class="box">
                    <h3>liên hệ</h3>
                    <a href="#"> <div class="location-icon"></div>268 Ly Thuong Kiet Street Ward 14, District 10, Ho Chi Minh City, Vietnam </a>
                    <a href="#"> <div class="phone-icon"></div>(028) 38 651 670 - (028) 38 647 256 (Ext: 5258, 5234) </a>
                    <a href="mailto:elearning@hcmut.edu.vn" class="email"> <div class="email-icon"></div>elearning@hcmut.edu.vn </a>
                </div>
            </div>
        </section>
        <div class="copyright">
            <p>Copyright 2007-2022 BKEL - Phát triển dựa trên Moodle</p>
        </div>
=======
    <section class="main">

    </section>

    <!-- footer section starts -->
    <section class="footer">
        <div class="box-container">

            <div class="left">
                <h3>student smart printing service</h3>
                <img src="images/logo.png" alt="footer" />
            </div>

            <div class="middle">
                <h3>website</h3>
                <br>
                <a href="https://hcmut.edu.vn/" class="hcmut">HCMUT <br></a>
                <a href="https://mybk.hcmut.edu.vn/my/index.action" class="mybk">MyBK <br></a>
                <a href="https://mybk.hcmut.edu.vn/bksi/public/vi/" class="bksi">BKSI </a>
            </div>

            <div class="right">
                <h3>liên hệ</h3>
                <a href="#"> <div class="location-icon"></div>268 Ly Thuong Kiet Street Ward 14, District 10, Ho Chi Minh City, Vietnam </a>
                <a href="#"> <div class="phone-icon"></div>(028) 38 651 670 - (028) 38 647 256 (Ext: 5258, 5234) </a>
                <a href="mailto:elearning@hcmut.edu.vn" class="email"> <div class="email-icon"></div>elearning@hcmut.edu.vn </a>
            </div>

        </div>
    </section>
    <div class="copyright">
        <p>Copyright 2007-2022 BKEL - Phát triển dựa trên Moodle</p>
>>>>>>> 9dab8ccedab132acc0b1777cd520808a93df7760
    </div>
    <!-- footer section ends -->









    <!-- swiper js link -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- custom js file link -->
    <script src="script.js"></script>
</body>
</html>