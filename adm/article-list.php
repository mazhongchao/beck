<?php
$query_data = Url::queryData();

$do = new DataObject('../test/beck.db');

$artile_list = $do::articles($query_data['page'], $query_data['per_page'], $query_data['filter']);

