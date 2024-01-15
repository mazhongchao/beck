<?php
require 'base.php';

$view = new Template(ADM_DIR."template/admin");
if (!file_exists(DB_FILE)) {
    $view->display('init.html');
}

if (isset($_SESSION['bk_sess'])) {
    header("Location: ./article.php");
    return;
}

if (isset($_POST['login_acc']) && isset($_POST['login_pwd'])) {
    $login_acc = trim($_POST['login_acc']);
    $login_pwd = trim($_POST['login_pwd']);

    $ret = Auth::verifyUser($login_acc, $login_pwd);
    if ($ret) {
        var_dump(Auth::initStatus($login_acc));
        if (Auth::initStatus($login_acc)) {
            $view->assign(['login_acc' => $login_acc]);
            $view->display('update-init-status.html');
            return;
        }

        $_SESSION['bk_sess'] = session_id();
        header("Location: ./dashboard.php");
        exit;
    }
    else {
        $error_msg = "用户名或密码错误";
        $view->assign(['msg' => $error_msg]);
        $view->display('login.html');
    }
    return;
}

else if (isset($_POST['new_pwd'])) {
    $new_pwd = trim($_POST['new_pwd']);
    $login_acc = trim($_POST['login_acc']);

    if (Auth::updateInitStatus($login_acc, $new_pwd)) {
        $init_msg = "密码更新完成，请使用新密码登录";
        $view->assign(['msg' => $init_msg]);
        $view->display('login.html');
        //unlink(SYS_DIR."admin-template/update-init-status.html");
    }
    return;
}

else {
    echo "xxxx";
    $ret = Auth::init();
    if ($ret !== false) {
        echo "yyyy";
        $init_msg = "初始账号和密码是: admin/{$ret}。该密码仅显示一次，请立即登录并更改密码，否则将无法使用Beck";
        $view->assign(['msg' => $init_msg]);
        $view->display('login.html');
        return;
    }
}

