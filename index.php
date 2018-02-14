<?php
date_default_timezone_set("Europe/Moscow");
require_once('functions.php');
require_once('data.php');

$is_auth = (bool) rand(0, 1);

$Title='Главная';
$page_content = Include_Template('templates/index.php', ['ads'=> $ads ]);
$layout_content = Include_Template('templates/layout.php', ['title' => $Title, 'content' => $page_content, 'category'=> $category ]);
print($layout_content);
?>
