<?php
require_once('init.php');

/*require_once('functions.php');
require_once('data.php');*/

$Title='Главная';
$user = null;
$user = auth_user($user);

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
}
else {
    $sql = 'SELECT `id`, `name` FROM Category';
    $result = mysqli_query($link, $sql);
    if ($result) {
        $category = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$sql = 'select l.`id`, l.`name`, l.`rate`, UNIX_TIMESTAMP(l.`dt_close`) as dt_close, l.`img`, c.`name` as `category`, l.rate as `price`
			from lots l
			JOIN category c ON l.category_id=c.id
			order by dt_add desc';	
		$result = mysqli_query($link, $sql);
		if ($result) {
			$ads = mysqli_fetch_all($result, MYSQLI_ASSOC);
			$page_content = Include_Template('index.php', ['ads'=> $ads ]);
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
}

$layout_content = Include_Template('layout.php', ['title' => $Title, 'user' => $user, 'content' => $page_content, 'category'=> $category ]);
print($layout_content);
?>
