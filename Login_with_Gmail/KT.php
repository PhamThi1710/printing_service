<?php
ob_start();
session_start();

require_once 'vendor/autoload.php';
require 'database.php';
require 'function.php';

function insertUser($Fname, $Lname, $Email, $Role, $Sex, $Date_of_Birth, $Balance)
{

    $insert = 'INSERT INTO `users`("Fname","Lname","Email","Role","Sex","Date_Of_Birth","Balance")VALUES(?, ?, ?, ?, ?, ?, ?)';

    mysqli_query($conn, $insert);
}

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
        $check = "SELECT Count(*) FROM Users WHERE Email = '$email'";
        $result = mysqli_query($conn, $check);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        var_dump($email);
        echo $email;
        if (!empty($data)) { //Nếu có email xuất hiện
            $email_gg = $user->email;
            $domain = "@hcmut.edu.vn";

            $position = strpos($email_gg, $domain);

            if ($position !== false) { // && $position == strlen($email_gg) - strlen($domain)){
                $_SESSION['student_id'] = uniqid('session_', true);
                $get = mysqli_query($conn, "select id,role from users where email = '$user->email' ");
                $getData = $get->fetch_all(MYSQLI_ASSOC);
                $ID = $getData[0]['id'];
                $Role = $getData[0]['Role'];
                $_SESSION['student_id'] = $ID;
                if ($Role == "Student") {
                    header('Location: homeAfterLogin_User.php');
                } else {
                    header('Location: homeAfterLogin_Manage.php');
                }
            } else {
                $_SESSION['Fail_Login'] = True;
                header('Location: home.php');
                exit();
            }
        } else {
            insertUser($_SESSION['user_info']['name'], '', $_SESSION['user_info']['email'], 'Student', $_SESSION['user_info']['gender'], $_SESSION['user_info']['birthday'], '0');
        }
    }
}
?>