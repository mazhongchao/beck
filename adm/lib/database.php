<?php
class Database
{
    private static object $db;

    public function __construct($source =  DB_FILE)
    {
        self::$db = new SQLite3($source);
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
}