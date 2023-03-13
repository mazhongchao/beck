<?php
class Article
{
    public static function save()
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

    public static function query($page=1, $page_size=30, $filter=null): array
    {
        $start = ($page - 1) * $page_size;
        $rows = $page_size;

        $limit = "{$start},{$rows}";

        $data_object = new DataObject();
        $data_object::setSource();;
        $res = $data_object::query("bk_article", "*", $filter, null, "", "", "",
            $limit);

        $list = [];
        while ($row = $res->fetchArray()) {
            array_push($data, $row);
        }
        return $list;
    }
}