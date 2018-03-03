<?php
require_once('init.php');

$user = null;
$user = auth_user($user,$link);

$page_content ='';

$new_array=[];
$array_value=[];
if (isset($_COOKIE['openLots'])) {
	$array_value = json_decode($_COOKIE['openLots']);
}
$sql = 'SELECT id, name FROM category';
$result = mysqli_query($link, $sql);
if ($result) {
	$category = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$cur_cat_id = 1;
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$cur_cat_id = isset($_GET['cur_cat_id']) ? $_GET['cur_cat_id'] : $cur_cat_id;
		$sql = 'SELECT id, name FROM category WHERE id='.intval($cur_cat_id);
		$result = mysqli_query($link, $sql);
		
		$cur_page = intval($_GET['page'] ?? 1);
		$result = mysqli_query($link, 'SELECT COUNT(*) as cnt FROM lots l
		WHERE l.id in ('. implode(',', array_map('intval', $array_value)) . ')');
		$items_count = mysqli_fetch_assoc($result)['cnt'];
		$pages_count = ceil($items_count / $page_items);
		$offset = ($cur_page - 1) * $page_items;
		$pages = range(1, $pages_count);
		
		$sql = 'SELECT l.id, l.name, l.rate, UNIX_TIMESTAMP(l.dt_close) as dt_close, l.img, c.name as category, l.rate as price
			FROM lots l
			JOIN category c ON l.category_id=c.id
			WHERE l.id in ('. implode(',', array_map('intval', $array_value)) . ')
			LIMIT '.$page_items.' OFFSET '.$offset;
		if ($ads = mysqli_query($link, $sql)) {	
			$tpl_data = [
				'ads'=> $ads,
				'pages' => $pages,
				'pages_count' => $pages_count,
				'cur_page' => $cur_page,
				'cur_cat_name' => $cur_cat_name
				];
			$page_content = include_template('history.php', $tpl_data);
		}
		else {
			$error = mysqli_error($link);
			$page_content = include_template('error.php', ['error' => $error]);
		}
	}
}
else {
	$error = mysqli_error($link);
	$page_content = include_template('error.php', ['error' => $error]);
}

$title="История просмотров";
$layout_content = include_template('layout.php', ['title' => $title, 'user' => $user, 'content' => $page_content, 'category'=> $category ]);
print($layout_content);

?>
