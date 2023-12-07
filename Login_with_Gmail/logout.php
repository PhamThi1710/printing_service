<?php

session_start(); // Khai báo hàm session cho File logout trước

session_destroy(); // hàm hủy tất cả các session trên trang web

<<<<<<< HEAD
header('location: /home.php');
=======
header('location: home.php');
>>>>>>> 9dab8ccedab132acc0b1777cd520808a93df7760

?>