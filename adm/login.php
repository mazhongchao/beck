<?php
require 'base.php';

if (isset($_SESSION['bk_sess'])) {
    header("Location: ".SYS_DIR."dashboard.php");
    return;
}

$view = new Template(SYS_DIR."admin-template");

if (isset($_POST['login_acc']) && isset($_POST['login_pwd'])) {
    echo "login....";
    $login_acc = trim($_POST['login_acc']);
    $login_pwd = trim($_POST['login_pwd']);
    var_dump($login_acc);
    var_dump($login_pwd);

    $ret = Auth::verifyUser($login_acc, $login_pwd);
    var_dump($ret);
    //exit(0);

    if ($ret == true) {
        var_dump(Auth::initStatus($login_acc));
        if (Auth::initStatus($login_acc)) {
            $view->assign(['login_acc' => $login_acc]);
            $view->display('update-init-status.html');
            return;
        }

        $_SESSION['bk_sess'] = session_id();
        header("Location: ".SYS_DIR."dashboard.php");
    }
    else {
        $error_msg = "用户名或密码错误";
        $view->assign(['msg' => $error_msg]);
        $view->display('login.html');
    }
    return;
}

else if (isset($_POST['new_pwd'])) {
    echo "update....";
    $new_pwd = trim($_POST['new_pwd']);
    $login_acc = trim($_POST['login_acc']);
    var_dump($new_pwd);
    var_dump($login_acc);
    if (Auth::updateInitStatus($login_acc, $new_pwd)) {
        $init_msg = "密码更新完成，请使用新密码登录";
        $view->assign(['msg' => $init_msg]);
        $view->display('login.html');
        //unlink(SYS_DIR."admin-template/update-init-status.html");
    }
    return;
}

else {
    echo "init....<br/>";
    $ret = Auth::init();
    var_dump($ret);
    exit(0);
    if ($ret !== false) {
        $init_msg = "初始账号和密码是: admin/{$ret}。该密码仅显示一次，请立即登录并更改密码，否则将无法使用Beck";
        $view->assign(['msg' => $init_msg]);
        $view->display('login.html');
        return;
    }
}
//else if ($ret = Auth::init()) {
//    echo "init...";
//    $init_msg = "初始账号和密码是: admin/{$ret}。该密码仅显示一次，请立即登录并更改密码，否则将无法使用Beck";
//    $view->assign(['msg' => $init_msg]);
//    $view->display('login.html');
//    return;
//}

