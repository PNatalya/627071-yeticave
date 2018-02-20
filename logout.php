<?php
require_once('functions.php');
require_once('data.php');
require_once('userdata.php');

session_start();
$_SESSION=[];
header("Location: /index.php");
exit();

?>
