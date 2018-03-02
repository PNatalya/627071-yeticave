<?php
require_once('init.php');

$user = null;
$user = auth_user($user);

$page_content ='';

$new_array=[];
$array_value=[];
if (isset($_COOKIE['openLots'])) {
	$array_value = json_decode($_COOKIE['openLots']);
}
$sql = 'SELECT `id`, `name` FROM Category';
$result = mysqli_query($link, $sql);
if ($result) {
	$category = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$cur_cat_id = 1;
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$cur_cat_id = isset($_GET['cur_cat_id']) ? $_GET['cur_cat_id'] : $cur_cat_id;
		$sql = 'SELECT `id`, `name` FROM Category where id='.intval($cur_cat_id);
		$result = mysqli_query($link, $sql);
		$cur_cat_name = mysqli_fetch_assoc($result)['name'];
		$sql = 'select l.`id`, l.`name`, l.`rate`, UNIX_TIMESTAMP(l.`dt_close`) as dt_close, l.`img`, c.`name` as `category`, l.rate as `price`
			from lots l
			JOIN category c ON l.category_id=c.id
			where l.dt_close > NOW() and c.id=? and l.id in ('. implode(',', array_map('intval', $array_value)) . ')';
		$stmt = db_get_prepare_stmt($link, $sql, [$cur_cat_id ]);
		if ((mysqli_stmt_execute($stmt) == !TRUE)
			or (($result = mysqli_stmt_get_result($stmt)) === FALSE)
			or (mysqli_stmt_close ($stmt) === FALSE)) {
			$error = mysqli_error($link);
			$page_content = include_template('error.php', ['error' => $error]);
		} else {
			$ads = mysqli_fetch_all($result, MYSQLI_ASSOC);
			$page_content = include_template('history.php', ['cur_cat_name' => $cur_cat_name, 'ads'=> $ads]);
		}
	}
}
else {
	$error = mysqli_error($link);
	$page_content = include_template('error.php', ['error' => $error]);
}

$Title="История просмотров";
$layout_content = Include_Template('layout.php', ['title' => $Title, 'user' => $user, 'content' => $page_content, 'category'=> $category ]);
print($layout_content);

?>
