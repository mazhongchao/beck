<?php
require 'base.php';

$query_data = Url::queryData();
$list = Article::show($query_data['page'], $query_data['per_page'], $query_data['filter']);

