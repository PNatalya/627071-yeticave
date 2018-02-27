<?php
require_once('init.php');

$user = null;
$user = auth_user($user);

$sql = 'SELECT `id`, `name` FROM Category';
$result = mysqli_query($link, $sql);
if ($result) {
	$category = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$search = $_GET['search'] ?? '';
		$search = mysqli_real_escape_string($link, $search);
		}
		$sql = "select l.`id`, l.`name`, l.`rate`, UNIX_TIMESTAMP(l.`dt_close`) as dt_close, l.`img`, c.`name` as `category`, l.rate as `price`
			from lots l
			JOIN category c ON l.category_id=c.id
			WHERE l.`name` LIKE '%$search%' OR `description` LIKE '%$search%'";
		if ($ads = mysqli_query($link, $sql)) {
			$page_content = include_template('search.php', ['Union' => $search,'ads'=> $ads, 'category'=> $category ]);
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
