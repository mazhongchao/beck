<?php
define('APP_DIR', dirname(__FILE__, 2) .DIRECTORY_SEPARATOR);
define('ADM_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);
const LIB_DIR = ADM_DIR . "lib" . DIRECTORY_SEPARATOR;
const DB_DIR = ADM_DIR . "data" . DIRECTORY_SEPARATOR;

require_once LIB_DIR."autoload.php";
session_start();