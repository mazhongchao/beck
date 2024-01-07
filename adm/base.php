<?php
define('APP_DIR', dirname(__FILE__, 2) .DIRECTORY_SEPARATOR);
define('ADM_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);

const LIB_DIR = ADM_DIR . "lib" . DIRECTORY_SEPARATOR;
const DB_DIR = ADM_DIR . "data". DIRECTORY_SEPARATOR;

const DB_FILE = DB_DIR . DIRECTORY_SEPARATOR . "beck.db";

#const DB_FILE = ADM_DIR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "test/beck.db";

require_once LIB_DIR."autoload.php";

if (!file_exists(DB_FILE)) {
    $db = new Database(DB_FILE);
    $db->init();
}
session_start();