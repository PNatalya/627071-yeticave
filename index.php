<?php
date_default_timezone_set("Europe/Moscow");
require_once('functions.php');
require_once('data.php');

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

/*
$timelot = (mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"))) - time();
$hour = floor($timelot/3600);
$minut = floor(($timelot%3600)/60);
$timelot = sprintf("%02d:%02d", $hour, $minut);
*/
if (isset($_GET['lot_id'])) {
	$lot = null;
	$lot_id = $_GET['lot_id'];
	foreach ($ads as $key=> $val) {
		if ($key == $lot_id) {
			$lot = $val;
			break;
		}
	}
	if (!$lot) {
		http_response_code(404);
	}
	$Title=$lot['name'];
	$page_content = Include_Template('templates/lot.php', ['lot'=> $lot, 'category'=> $category ]);
}	
else {
	$Title='Главная';
	$page_content = Include_Template('templates/index.php', ['ads'=> $ads ]);
}

$layout_content = Include_Template('templates/layout.php', ['title' => $Title, 'content' => $page_content, 'category'=> $category ]);
print($layout_content);
?>
