<?php
date_default_timezone_set("Europe/Moscow");
require_once 'functions.php';
require_once 'config/db.php';
error_reporting(0);

ini_set('display_errors', 'Off');
$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");
ini_set('display_errors', 'On');

$category = [];
?>