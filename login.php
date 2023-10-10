<?php
@include 'database.php';

session_start();

if (isset($_POST['submit'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = md5($_POST['password']);

    $select = " SELECT * FROM account WHERE username = '$username' && password = '$pass' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);
        $_SESSION['name'] = $row['username'];
        $_SESSION['rule'] = $row['rule'];
        header("Location: home.php");

    } else {
        $error[] = 'Incorrect username or password!';
    }

}
;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
    <form action="" method="post">
        <div>
            <label for="username">Username: </label>
            <input type="text"  name="username"  maxlength="10"
                required placeholder="Enter your username">
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu: </label>
            <input type="password" name="password" minlength="7"
                maxlength="20" required placeholder="Enter your password">
        </div>
        <div>
            <a href="" style="color:blue;">Thay đổi mật khẩu?</a>
        </div>
        <div>
            <button type="submit" name="submit">Submit</button>
            <button type="reset" >Reset</button>
        </div>
    </form>
</body>
</html>