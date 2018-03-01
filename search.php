<?php
require_once('init.php');

$user = null;
$user = auth_user($user);

$sql = 'SELECT `id`, `name` FROM Category';
$result = mysqli_query($link, $sql);
if ($result) {
	$category = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$search = trim($_GET['search'] ?? '');
		if ($search) {
			$search = mysqli_real_escape_string($link, $search);
			
			$cur_page = intval($_GET['page'] ?? 1);
			$result = mysqli_query($link, "SELECT COUNT(*) as cnt FROM lots l where l.dt_close > NOW() and (l.`name` LIKE '%$search%' OR `description` LIKE '%$search%')");
			$items_count = mysqli_fetch_assoc($result)['cnt'];
			$pages_count = ceil($items_count / $page_items);
			$offset = ($cur_page - 1) * $page_items;
			$pages = range(1, $pages_count);
			
			$sql = "select l.`id`, l.`name`, l.`rate`, UNIX_TIMESTAMP(l.`dt_close`) as dt_close, l.`img`, c.`name` as `category`, l.rate as `price`
			from lots l
			JOIN category c ON l.category_id=c.id
			WHERE l.dt_close > NOW() and (l.`name` LIKE '%$search%' OR `description` LIKE '%$search%') ORDER BY dt_add DESC LIMIT ".$page_items." OFFSET ".$offset;
			if ($ads = mysqli_query($link, $sql)) {
				$tpl_data = [
					'ads'=> $ads,
					'Union' => $search,
					'category'=> $category,
					'pages' => $pages,
					'pages_count' => $pages_count,
					'cur_page' => $cur_page,
					'cur_cat_name' => $cur_cat_name,
					'par_url' => '&search='.$search
					];
				$page_content = include_template('search.php', $tpl_data);
			}
			else {
				$error = mysqli_error($link);
				$page_content = include_template('error.php', ['error' => $error]);
			}
		}
	}
}
else {
	$error = mysqli_error($link);
	$page_content = include_template('error.php', ['error' => $error]);
}


$layout_content = Include_Template('layout.php', ['title' => $Title, 'user' => $user, 'content' => $page_content, 'category'=> $category ]);

print($layout_content);
?>
