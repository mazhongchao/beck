<?php
class Database
{
    private static object $db;

    public function __construct($source =  DB_FILE)
    {
        self::$db = new SQLite3($source);
        return self::$db;
    }

    public function rawQuery($sql): bool|SQLite3Result|null
    {
        if (!empty($sql) && is_string($sql)) {
            return self::$db->query($sql);
        }
        return null;
    }

    public function query($tb, $cols="*", $cond=null, $cond_arg=null, $group_by="", $having="", $order_by="",
                                 $limit=""): bool|SQLite3Result|null
    {
        if (!empty($tb) && is_string($tb) && !empty($cols) && is_string($cols)) {
            $where = "where 1=1";
            if (isset($cond) && is_array($cond)) {
                $cond_arr = [];
                foreach ($cond as $col=>$val) {
                    $cond_arr[] = "{$col}='{$val}'";
                }
                $where .= implode(" and ", $cond_arr);
            }

            $sql = "select {$cols} from {$tb} {$where}";
            if (!empty($limit)) {
                $limit_arr = explode(",", $limit);
                if(is_array(($limit_arr)) && count($limit_arr)>1) {
                    $start = trim($limit_arr[0]);
                    $rows = trim($limit_arr[1]);
                    $sql .= " limit {$rows} offset {$start}";
                }
            }

            if (!empty($group_by)) {
                $sql .= " group by {$group_by}";
            }
            if (!empty($having)) {
                $sql .= " having {$having}";
            }
            if (!empty($order_by)) {
                $sql .= " order by {$order_by}";
            }
            return self::rawQuery($sql);
        }
        return null;
    }

    public function save()
    {
        //
    }

    public function delete()
    {
        //
    }

    public function update()
    {
        //
    }

    public function init()
    {
        $sql =<<<EOF
CREATE TABLE `bk_article` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `title` VARCHAR(255) NOT NULL DEFAULT '',
  `alias` VARCHAR(255) NOT NULL DEFAULT '',
  `content` TEXT NOT NULL,
  `category_id` INT NOT NULL DEFAULT 1,
  `tag` VARCHAR(100) NOT NULL DEFAULT '',
  `keywords` VARCHAR(255) NOT NULL DEFAULT '',
  `description` VARCHAR(500) NOT NULL DEFAULT '',
  `text_type` VARCHAR(5) NOT NULL DEFAULT 'html',
  `published` TINYINT NOT NULL DEFAULT 0,
  `trash` TINYINT NOT NULL DEFAULT 0,
  `remote_sync` TINYINT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT (datetime(CURRENT_TIMESTAMP,'localtime')),
  `updated_at` DATETIME NOT NULL DEFAULT (datetime(CURRENT_TIMESTAMP,'localtime'))
);
CREATE INDEX idx_cate ON bk_article (category_id);
CREATE INDEX idx_tag ON bk_article (tag);
CREATE TABLE `bk_page` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `title` VARCHAR(255) NOT NULL DEFAULT '',
  `alias` VARCHAR(255) NOT NULL DEFAULT '',
  `content` TEXT NOT NULL,
  `keywords` VARCHAR(255) NOT NULL DEFAULT '',
  `summary` VARCHAR(255) NOT NULL DEFAULT '',
  `text_type` VARCHAR(5) NOT NULL DEFAULT 'html',
  `published` TINYINT NOT NULL DEFAULT 0,
  `trash` TINYINT NOT NULL DEFAULT 0,
  `remote_sync` TINYINT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT (datetime(CURRENT_TIMESTAMP,'localtime')),
  `updated_at` DATETIME NOT NULL DEFAULT (datetime(CURRENT_TIMESTAMP,'localtime'))
);
CREATE TABLE `bk_category` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` VARCHAR(255) NOT NULL DEFAULT '',
    `alias` VARCHAR(255) NOT NULL DEFAULT '',
    `parent_id` INT NOT NULL DEFAULT 0,
    `index_page_id` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT (datetime(CURRENT_TIMESTAMP,'localtime')),
    `updated_at` DATETIME NOT NULL DEFAULT (datetime(CURRENT_TIMESTAMP,'localtime'))
);
INSERT INTO bk_category(id, name, alias) VALUES (1, 'default', 'a');
CREATE TABLE `bk_tag` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` VARCHAR(255) NOT NULL DEFAULT '',
    `alias` VARCHAR(255) NOT NULL DEFAULT '',
    `article_count` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT (datetime(CURRENT_TIMESTAMP,'localtime')),
    `updated_at` DATETIME NOT NULL DEFAULT (datetime(CURRENT_TIMESTAMP,'localtime'))
);
CREATE TABLE `bk_user` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `login_acc` VARCHAR(255) NOT NULL DEFAULT '',
  `login_pwd` VARCHAR(255) NOT NULL DEFAULT '',
  `user_name` VARCHAR(50) NOT NULL DEFAULT '',
  `user_email` VARCHAR(50) NOT NULL DEFAULT '',
  `status` TINYINT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT (datetime(CURRENT_TIMESTAMP,'localtime')),
  `updated_at` DATETIME NOT NULL DEFAULT (datetime(CURRENT_TIMESTAMP,'localtime'))
);
CREATE TABLE `bk_settings` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `setting_type` VARCHAR(255) NOT NULL DEFAULT '',
  `option` VARCHAR(255) NOT NULL DEFAULT '',
  `value` VARCHAR(255) NOT NULL DEFAULT '',
  `created_at` DATETIME NOT NULL DEFAULT (datetime(CURRENT_TIMESTAMP,'localtime')),
  `updated_at` DATETIME NOT NULL DEFAULT (datetime(CURRENT_TIMESTAMP,'localtime'))
);
EOF;
        return self::$db->exec($sql);
    }
}