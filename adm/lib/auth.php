<?php
class Auth
{
    //public function __construct() {}

    public static function verifyUser($login_acc, $login_pwd): bool
    {
        $db = new SQLite3(SYS_DIR.'data/beck.db');
        $password_hash = $db->querySingle("SELECT login_pwd FROM bk_user WHERE login_acc='{$login_acc}'");
        $db->close();
        var_dump($password_hash);

        return password_verify($login_pwd, $password_hash);
    }

    public static function init(): bool|string
    {
        $db = new SQLite3(SYS_DIR.'data/beck.db');
        $res = $db->query("SELECT id, status FROM bk_user limit 1 offset 0");
//        while ($row = $res->fetchArray()) {
//            print_r($row);
//        }
        echo ".....<br/>";
        $row = $res->fetchArray();
        print_r($row);
        $offset = rand(3,13);
        if ($res->fetchArray() == false) {
            echo "no rows<br/>";
            $str = md5(time());
            $token = substr($str, $offset, 6);
            echo "token1={$token}<br/>";
            $token_hash = password_hash($token, PASSWORD_DEFAULT);
            $sql = "INSERT INTO bk_user(login_acc, login_pwd, user_name) VALUES ('admin', '{$token_hash}', '{$token}')";
            echo "sql1 = {$sql}<br/>";
            $db->exec($sql);
            $db->close();
            echo "token1.={$token}<br/>";
            return $token;
        }
//        else {
//            echo "have rows<br/>";
//            var_dump($res->fetchArray());
//            if ($res->fetchArray()[0]['status'] == 0) {
//                $str = md5(time());
//                $token = substr($str, $offset, 6);
//                echo "token2={$token}<br/>";
//                $token_hash = password_hash($token, PASSWORD_DEFAULT);
//                $sql = "UPDATE bk_user set login_pwd='{$token_hash}', user_name='{$token}' where login_acc='admin'";
//                $db->exec($sql);
//                echo "sql1 = {$sql}<br/>";
//                $db->close();
//                echo "token2.={$token}<br/>";
//                return $token;
//            }
//            else {
//                return false;
//            }
//        }
        //return false;
    }

    public static function initStatus($login_acc): bool
    {
        $db = new SQLite3(SYS_DIR.'data/beck.db');
        $status = $db->querySingle("SELECT status FROM bk_user WHERE login_acc='{$login_acc}'");
        $db->close();
        if ($status == 1) {
            return false;
        }
        return true;
    }

    public static function updateInitStatus($login_acc, $new_pwd): bool
    {
        $db = new SQLite3(SYS_DIR.'data/beck.db');
        $token_hash = password_hash($new_pwd, PASSWORD_DEFAULT);
        $db->exec("UPDATE bk_user set login_pwd='{$token_hash}', status=1 WHERE login_acc='{$login_acc}'");
        $db->close();
        return true;
    }
}
