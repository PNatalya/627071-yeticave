<?php
require_once('init.php');
/*require_once('functions.php');
require_once('data.php');*/

$user = null;
$user = auth_user($user);

$lot = null;
if (isset($_GET['lot_id'])) {
	$lot_id = $_GET['lot_id'];
	$sql = 'select l.`id`, l.`name`, l.`description`, l.`rate`, UNIX_TIMESTAMP(l.`dt_close`) as dt_close, l.`img`, c.`name` as `category`, l.rate as `price`
		from lots l
		JOIN category c ON l.category_id=c.id
		where l.id ='.$lot_id;	
	$result = mysqli_query($link, $sql);
	if ($result) {
		$lot = mysqli_fetch_assoc($result);
		if (!$lot) {
			http_response_code(404);
			header('Location:./404.php');
			exit(); 
		}
		else {
			$name = "openLots";
			$expire = strtotime("+30 days");;
			$path = "/";
			$array_value = [];
	
			if (isset($_COOKIE[$name])) {
				$array_value = json_decode($_COOKIE[$name]);
			}
			If (!in_array($lot_id, $array_value)) {
				$array_value[] = $lot_id;
			}
			$value = json_encode($array_value);
			setcookie($name, $value, $expire, $path);
		}	
		$sql = 'SELECT `id`, `name` FROM Category';
		$result = mysqli_query($link, $sql);
		if ($result) {
			$category = mysqli_fetch_all($result, MYSQLI_ASSOC);
			$Title=htmlspecialchars($lot['name']);
			$page_content = Include_Template('lot.php', ['lot'=> $lot, 'user' => $user, 'category'=> $category ]);
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
