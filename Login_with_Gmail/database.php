<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
<<<<<<< HEAD
    $database = "SSPS";
=======
    $database = "User";
>>>>>>> 9dab8ccedab132acc0b1777cd520808a93df7760

    $conn = mysqli_connect($servername, $username, $password, $database);
    if(!$conn) {
        echo ("Can't connect");
    }
?>