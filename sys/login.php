<?php
require 'config.php';

if($_SESSION['bkssid']){
    header("Location: ./bk-admin.php");
    exit();
}
if (!empty($login_acc = $_POST['login_acc']) && !empty($login_pwd = $_POST['login_pwd'])) {
    $ret = Auth::user_signin($login_acc, $login_acc);
    if ($ret == true) {
        header("Location: ./bk-admin.php");
        exit();
    }
    else {
        echo "Error";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Beck's Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<link href="./static/css/login-style.css" rel="stylesheet" type="text/css" />
<style>
body {background-color: #f5f5f5;}
</style>
</head>

<body>
    <div class="login-header">Beck</div>
    <div class="login-wrapper">
        <div class="login-content">
            <form action="login.php" method="POST">
                <p><label>账号</label><input type="text" name="login_acc"></p>
                <p><label>密码</label><input type="password" name="login_pwd"></p>
                <p><input type="submit" name="submit" value="登录"></p>
            </form>
        </div>
    </div>
</body>
</html>
