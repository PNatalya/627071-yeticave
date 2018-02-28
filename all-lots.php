<?php
require_once('init.php');

$user = null;
$user = auth_user($user);

$sql = 'SELECT `id`, `name` FROM Category';
$result = mysqli_query($link, $sql);
if ($result) {
	$category = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	$cur_cat_id = 1;
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$cur_cat_id = $_GET['cur_cat_id'] ?? $cur_cat_id ;
		
		$sql = 'SELECT `id`, `name` FROM Category where id='.intval($cur_cat_id);
		$result = mysqli_query($link, $sql);
		$cur_cat_name = mysqli_fetch_assoc($result)['name'];
		
		$sql = 'select l.`id`, l.`name`, l.`rate`, UNIX_TIMESTAMP(l.`dt_close`) as dt_close, l.`img`, c.`name` as `category`, l.rate as `price`
			from lots l
			JOIN category c ON l.category_id=c.id
			where  c.id=? 
			order by l.dt_add desc ';
		$stmt = db_get_prepare_stmt($link, $sql, [$cur_cat_id]);
		if ((mysqli_stmt_execute($stmt) == !TRUE)
			or (($result = mysqli_stmt_get_result($stmt)) === FALSE)
			or (mysqli_stmt_close ($stmt) === FALSE)) {
			$error = mysqli_error($link);
			$page_content = include_template('error.php', ['error' => $error]);
		} else {
			$ads = mysqli_fetch_all($result, MYSQLI_ASSOC);
			$page_content = include_template('all-lots.php', ['ads'=> $ads, 'cur_cat_name' => $cur_cat_name ]);
		}
	}
}
else {
	$error = mysqli_error($link);
	$page_content = include_template('error.php', ['error' => $error]);
}


$layout_content = Include_Template('layout.php', ['title' => $Title, 'user' => $user, 'cur_cat_id' => $cur_cat_id, 'content' => $page_content, 'category'=> $category ]);

print($layout_content);
?>
