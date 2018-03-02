<?php
require_once('init.php');

$user = null;
$user = auth_user($user,$link);

$sql = 'SELECT `id`, `name` FROM Category';
$result = mysqli_query($link, $sql);
if ($result) {
	$category = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	$cur_cat_id = 1;
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$cur_cat_id = intval($_GET['cur_cat_id'] ?? 1);
		
		$sql = 'SELECT `id`, `name` FROM Category where id='.$cur_cat_id;
		$result = mysqli_query($link, $sql);
		$cur_cat_name = mysqli_fetch_assoc($result)['name'];
		
		$cur_page = intval($_GET['page'] ?? 1);
		$result = mysqli_query($link, "SELECT COUNT(*) as cnt FROM lots where dt_close > NOW() and category_id=".$cur_cat_id);
		$items_count = mysqli_fetch_assoc($result)['cnt'];
		$pages_count = ceil($items_count / $page_items);
		$offset = ($cur_page - 1) * $page_items;
		$pages = range(1, $pages_count);

		$sql = 'select l.`id`, l.`name`, l.`rate`, UNIX_TIMESTAMP(l.`dt_close`) as dt_close, l.`img`, c.`name` as `category`, l.rate as `price`
			from lots l
			JOIN category c ON l.category_id=c.id
			where l.dt_close > NOW() and c.id=? 
			order by l.dt_add desc LIMIT '.$page_items.' OFFSET '.$offset;
		$stmt = db_get_prepare_stmt($link, $sql, [$cur_cat_id]);
		if ((mysqli_stmt_execute($stmt) == !TRUE)
			or (($result = mysqli_stmt_get_result($stmt)) === FALSE)
			or (mysqli_stmt_close ($stmt) === FALSE)) {
			$error = mysqli_error($link);
			$page_content = include_template('error.php', ['error' => $error]);
		} else {
			$ads = mysqli_fetch_all($result, MYSQLI_ASSOC);
			$tpl_data = [
				'ads'=> $ads,
				'pages' => $pages,
				'pages_count' => $pages_count,
				'cur_page' => $cur_page,
				'cur_cat_name' => $cur_cat_name,
				'par_url' => '&cur_cat_id='.$cur_cat_id
				];
			$page_content = include_template('all-lots.php', $tpl_data);
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
