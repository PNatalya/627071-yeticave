<?php
require_once('init.php');
/*
require_once('functions.php');
require_once('data.php');
*/
$user = null;
$user = auth_user($user);

$sql = 'SELECT `id`, `name` FROM Category';
$result = mysqli_query($link, $sql);
if ($result) {
	$category = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$cur_cat_id = 1;
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$cur_cat_id = $_GET['cur_cat_id'];
		}
		$sql = 'select l.`id`, l.`name`, l.`rate`, UNIX_TIMESTAMP(l.`dt_close`) as dt_close, l.`img`, c.`name` as `category`, l.rate as `price`
			from lots l
			JOIN category c ON l.category_id=c.id
			where  c.id='.$cur_cat_id;	
		$result = mysqli_query($link, $sql);
		if ($result) {
			$ads = mysqli_fetch_all($result, MYSQLI_ASSOC);
			$page_content = include_template('all-lots.php', ['cur_cat_id' => $cur_cat_id, 'ads'=> $ads, 'category'=> $category ]);
		}
		else {
			$error = mysqli_error($link);
			$page_content = include_template('error.php', ['error' => $error]);
		}
}
else {
	$error = mysqli_error($link);
	$page_content = include_template('error.php', ['error' => $error]);
}


$layout_content = Include_Template('layout.php', ['title' => $Title, 'user' => $user, 'content' => $page_content, 'category'=> $category ]);

print($layout_content);
?>
