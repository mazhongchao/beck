<?php
if($_SESSION['bkssid']){
    header("Location: ./bk-admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Beck's Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<link href="./asset/css/login-style.css" rel="stylesheet" type="text/css" />
<style>
body {background-color: #f5f5f5;}
</style>
</head>

<body>
    <div class="login-header">Beck</div>
    <div class="longi-wrapper">
        <div class="login-content">
            <form action="" method="POST">
                <p><label>账号名称</label><input type="text" name="acc_name"></p>
                <p><label>账号密码</label><input type="passwd" name="acc_pwd"></p>
                <p><input type="submit" name="submit" value="登录"></p>
            </form>
        </div>
    </div>
</body>
</html>
