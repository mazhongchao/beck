<?php
define('APP_DIR', dirname(__FILE__, 2) .DIRECTORY_SEPARATOR);
define('ADM_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);

const LIB_DIR = ADM_DIR . "lib" . DIRECTORY_SEPARATOR;

$data_dir = "data";
if (file_exists("setting.ini")) {
    $ini_arr = parse_ini_file("setting.ini");
    if (isset($ini_arr['database']) && isset($ini_arr['database']['datafile_dir'])) {
        $data_dir = $ini_arr['database']['datafile_dir'];
    }
}

define('DB_DIR', ADM_DIR . $data_dir . DIRECTORY_SEPARATOR);

//const DB_DIR = ADM_DIR . "data" . DIRECTORY_SEPARATOR;
//const DB_DIR = APP_DIR. "../test" . DIRECTORY_SEPARATOR;

require_once LIB_DIR."autoload.php";
session_start();