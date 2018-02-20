<?php
require_once('functions.php');
require_once('data.php');

$user = null;
$user = auth_user($user);

$cur_cat_id = null;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$cur_cat_id = $_GET['cur_cat_id'];
}

$page_content = include_template('templates/all-lots.php', ['cur_cat_id' => $cur_cat_id, 'ads'=> $ads, 'category'=> $category, 'Title'=> 'Все лоты' ]);
$layout_content = Include_Template('templates/layout.php', ['title' => $Title, 'user' => $user, 'content' => $page_content, 'category'=> $category ]);

print($layout_content);
?>
