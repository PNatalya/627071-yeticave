<?php
date_default_timezone_set("Europe/Moscow");
require_once('functions.php');
require_once('data.php');

$user = null;
$user = auth_user($user);

$Title='Главная';
$page_content = Include_Template('templates/index.php', ['ads'=> $ads ]);
$layout_content = Include_Template('templates/layout.php', ['title' => $Title, 'user' => $user, 'content' => $page_content, 'category'=> $category ]);
print($layout_content);
?>
