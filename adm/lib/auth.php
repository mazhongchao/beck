<?php
class Auth
{
    public static function verifyUser($login_acc, $login_pwd): bool
    {
        // $db = new SQLite3(DB_DIR.'beck.db');
        $db = new SQLite3(DB_FILE);
        $password_hash = $db->querySingle("SELECT login_pwd FROM bk_user WHERE login_acc='{$login_acc}'");
        $db->close();
        var_dump($password_hash);

        return password_verify($login_pwd, $password_hash);
    }

    public static function init(): bool|string
    {
        // $db = new SQLite3(DB_DIR.'beck.db');
        $db = new SQLite3(DB_FILE);
        $res = $db->query("SELECT id, status FROM bk_user limit 1 offset 0");

        $offset = rand(3,13);
        $str = md5(time());
        $token = substr($str, $offset, 6);
        $token_hash = password_hash($token, PASSWORD_DEFAULT);

        $row = $res->fetchArray();
        if (!$row) {
            $sql = "INSERT INTO bk_user(login_acc, login_pwd) VALUES ('admin', '{$token_hash}')";
            $db->exec($sql);
        }
        else if ($row['status'] == 0){
            $sql = "UPDATE bk_user set login_pwd='{$token_hash}' where login_acc='admin'";
            $db->exec($sql);
        }
        else {
            $token = false;
        }
        $db->close();
        return $token;
    }

    public static function initStatus($login_acc): bool
    {
        $db = new SQLite3(DB_DIR.'beck.db');
        $status = $db->querySingle("SELECT status FROM bk_user WHERE login_acc='{$login_acc}'");
        $db->close();
        if ($status == 1) {
            return false;
        }
        return true;
    }

    public static function updateInitStatus($login_acc, $new_pwd): bool
    {
        $db = new SQLite3(DB_DIR.'beck.db');
        $token_hash = password_hash($new_pwd, PASSWORD_DEFAULT);
        $db->exec("UPDATE bk_user set login_pwd='{$token_hash}', status=1 WHERE login_acc='{$login_acc}'");
        $db->close();
        return true;
    }
}
