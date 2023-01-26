<?php
define('APP_DIR', dirname(__FILE__, 2).DIRECTORY_SEPARATOR);
define('SYS_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('LIB_DIR', dirname(__FILE__)."/lib".DIRECTORY_SEPARATOR);
error_reporting(E_ALL);
ini_set('display_errors','On');
require_once LIB_DIR."/autoload.php";
//session_start();