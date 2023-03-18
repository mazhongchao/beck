<?php
require 'base.php';

$query_data = Url::queryData();
$list = Article::list($query_data['page'], $query_data['per_page'], $query_data['filter']);

