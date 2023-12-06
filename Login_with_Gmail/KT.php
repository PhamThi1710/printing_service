<?php
<<<<<<< HEAD
    ob_start();
    session_start();

    require_once 'vendor/autoload.php';
    require 'database.php';
    require 'function.php';

    $client = clientGoogle();
    $service = new Google_Service_Oauth2($client);

    if(isset($_GET['code'])){
        $miss = $client->authenticate($_GET['code']);
        if(isset($miss['error'])){ //Nếu nó lỗi 
            header('Location: home.php');
            exit();
        }else{ //Nếu không xảy ra lỗi
            $temp1 = $client->getAccessToken();
            $user = $service->userinfo->get();

            $_SESSION['user_info'] = [
                'email' => $user->email,
                'name' => $user->name,
                'id' => $user->id,
                'picture' => $user->picture,
                'gender' => $user->gender,
                'birthday' => $user->birthday,
                'phone' => $user->phone,
            ];

            $email = mysqli_real_escape_string($conn, $user->email);
            $check = "SELECT Role FROM Users WHERE Email = '$email'";
            $result = mysqli_query($conn, $check);

            if($result){ //Nếu có email xuất hiện thì đó là quản lý 
                if(mysqli_num_rows($result) > 0){
                    $_SESSION['session_id'] = uniqid('session_', true);
                    header('Location: homeAfterLogin_Manage.php');
                    exit();
                }else{
                    $email_gg = $user->email;
                    $domain = "@hcmut.edu.vn";

                    $position = strpos($email_gg, $domain);

                    if($position !== false && $position == strlen($email_gg) - strlen($domain)){
                        $_SESSION['session_id'] = uniqid('session_', true);
                        header('Location: homeAfterLogin_User.php');
                        exit();
                    }
                }
            }else{
                header('Location: home.php');
                exit();
            }
            header('Location: home.php');
            exit();
        }
    }else{
        header('Location: home.php');
        exit();
    }
=======
ob_start();
session_start();

require_once 'vendor/autoload.php';
require 'database.php';
require 'function.php';

$client = clientGoogle();
$service = new Google_Service_Oauth2($client);

if (isset($_GET['code'])) {
    $miss = $client->authenticate($_GET['code']);
    if (isset($miss['error'])) { //Nếu nó lỗi 
        header('Location: home.php');
        exit();
    } else { //Nếu không xảy ra lỗi
        $temp1 = $client->getAccessToken();
        $user = $service->userinfo->get();

        $email = mysqli_real_escape_string($conn, $user->email);
        $check = "SELECT Role_Type FROM User WHERE Email = '$email'";
        $result = mysqli_query($conn, $check);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $roleType = mysqli_fetch_assoc($result)['Role_Type'];
                if ($roleType == 1) { //Nhân viên
                    header('Location: homeAfterLogin_Manage.php');
                    exit();
                } else if ($roleType == 0) { //Người dùng, sinh viên, user
                    header('Location: homeAfterLogin_User.php');
                    exit();
                }
            }
        }
        if ($getUserResult && mysqli_num_rows($getUserResult) > 0) {
            $userId = mysqli_fetch_assoc($result)['ID'];
            $_SESSION['userId'] = $userId;
        }
        header('Location: home.php');
        exit();
    }
} else {
    header('Location: home.php');
    exit();
}



>>>>>>> 9dab8ccedab132acc0b1777cd520808a93df7760
?>