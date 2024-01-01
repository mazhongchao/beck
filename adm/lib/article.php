<?php
class Article
{
    public static function add()
    {
        //
    }

    public static function preview()
    {
        //
    }

    public static function publish()
    {
        //
    }

    public static function remove()
    {
        //
    }

    public static function edit()
    {
        //
    }

    public static function update()
    {
        //
    }

    public static function list($page=1, $page_size=30, $filter=null): array
    {
        $start = ($page - 1) * $page_size;
        $rows = $page_size;

        $limit = "{$start},{$rows}";

        $db = new Database();
        $res = $db->query("bk_article", "*", $filter, null, "", "", "",
            $limit);

        $list = [];
        while ($row = $res->fetchArray()) {
            $list[] = $row;
        }
        return $list;
    }
}