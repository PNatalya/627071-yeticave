<?php
require_once('init.php');

$user = null;
$user = auth_user($user,$link);

$sql = 'SELECT `id`, `name` FROM Category';
$result = mysqli_query($link, $sql);
if ($result) {
	$category = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$search = trim($_GET['search'] ?? '');
		if ($search) {
			$ads =[];
			$cur_page = intval($_GET['page'] ?? 1);
			$sql = "SELECT COUNT(*) as cnt FROM lots l 
			where l.dt_close > NOW() 
			and (MATCH(l.name, l.description) AGAINST(?))";
			$stmt = db_get_prepare_stmt($link, $sql, [$search]);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$items_count = mysqli_fetch_assoc($result)['cnt'];
			$pages_count = ceil($items_count / $page_items);
			$offset = ($cur_page - 1) * $page_items;
			$pages = range(1, $pages_count);

			$sql = "select l.id, l.name, l.rate, UNIX_TIMESTAMP(l.dt_close) as dt_close, 
			l.img, l.rate as `price`
			from lots l
			WHERE l.dt_close > NOW() 
			and (MATCH(name, description) AGAINST(?)) 			
			ORDER BY l.dt_add DESC LIMIT ".$page_items." OFFSET ".$offset;
			$stmt = db_get_prepare_stmt($link, $sql, [$search]);
			if ((mysqli_stmt_execute($stmt) == !TRUE)
				or (($result = mysqli_stmt_get_result($stmt)) === FALSE)
				or (mysqli_stmt_close ($stmt) === FALSE)) {
				$error = mysqli_error($link);
				$page_content = include_template('error.php', ['error' => $error]);
			} else {
				$ads = mysqli_fetch_all($result, MYSQLI_ASSOC);
				$tpl_data = [
					'ads'=> $ads,
					'Union' => $search,
					'pages' => $pages,
					'pages_count' => $pages_count,
					'cur_page' => $cur_page,
					'par_url' => '&search='.$search
					];
				$page_content = include_template('search.php', $tpl_data);
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
