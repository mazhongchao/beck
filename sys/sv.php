<?php
session_start();

if(!$_SESSION['bkssid']){
    header("Location: ./login.php");
    exit();
}
