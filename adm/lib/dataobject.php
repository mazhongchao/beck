<?php
class DataObject
{
    private static $source = '../data/beck.db';
    private static $db = null;

    public function __construct($source) {
        //
    }

    public static function setSource($source) {
        if (!empty($source)) {
            self::$source = $source;
        }
    }

    public static function source() {
        self::$db = new SQLite3(self::$source);
    }

    public static function rawQuery ($sql) {
        if (!empty($sql) && is_string($sql)) {
            return self::$db->query($sql);
        }
        return null;
    }
    public static function query($tb, $cols="*", $cond=null, $cond_arg=null, $group_by="", $having="", $order_by="",
                                 $limit="") {
        if (!empty($tb) && is_string($tb) && !empty($cols) && is_string($cols)) {
            $where = "where 1=1";
            if (isset($cond) && is_array($cond)) {
                $cond_arr = [];
                foreach ($cond as $col=>$val) {
                    array_push($cond_arr, "{$col}='{$val}'");
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
                $sql .= " {$group_by}";
            }
            if (!empty($having)) {
                $sql .= " {$having}";
            }
            if (!empty($order_by)) {
                $sql .= " {$order_by}";
            }
            return self::$db->query($sql);
        }
        return null;
    }
    public static function articles($page=1, $page_size=30, $filter=null): array
    {
        $start = ($page - 1) * $page_size;
        $rows = $page_size;

        $limit = "{$start},{$rows}";
        $res = self::query("bk_article", "*", $filter, null, "", "", "",
            $limit);

        $list = [];
        while ($row = $res->fetchArray()) {
            array_push($data, $row);
        }
        return $list;
    }
}