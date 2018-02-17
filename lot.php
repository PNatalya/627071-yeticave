<?php
require_once('functions.php');
require_once('data.php');

$lot = null;
if (isset($_GET['lot_id'])) {
	$lot_id = $_GET['lot_id'];
	foreach ($ads as $key=> $val) {
		if ($key == $lot_id) {
			$lot = $val;
			break;
		}
	}
}
if (!$lot) {
	http_response_code(404);
	header ("HTTP/1.1 404 Not Found");
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

$Title=htmlspecialchars($lot['name']);
$page_content = Include_Template('templates/lot.php', ['lot'=> $lot, 'category'=> $category ]);
$layout_content = Include_Template('templates/layout.php', ['title' => $Title, 'content' => $page_content, 'category'=> $category ]);
print($layout_content);

?>
