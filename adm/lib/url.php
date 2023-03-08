<?php
class Url
{
    public static function queryData(): array {
        //$query_data = ['page'=>1, 'per_page'=>30, 'filter'=>null];
        $query_data = [];

        if (isset($_REQUEST['page'])) {
            $query_data['page'] = $_REQUEST['page'];
        }
        if (isset($_REQUEST['per_page'])) {
            $query_data['per_page'] = $_REQUEST['per_page'];
        }
        if (isset($_REQUEST['filter'])) {
            //filter_arr = [];
            $filter_arr = explode('&', $_REQUEST['filter']);
            $query_data['filter'] = $filter_arr;
        }
        return $query_data;
    }
}