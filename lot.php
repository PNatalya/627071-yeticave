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
	$Title=htmlspecialchars($lot['name']);


}
if (!$lot) {
	http_response_code(404);
	header ("HTTP/1.1 404 Not Found");
	header('Location:./404.php');
	exit(); 
}
else {
}	

$page_content = Include_Template('templates/lot.php', ['lot'=> $lot, 'category'=> $category ]);
$layout_content = Include_Template('templates/layout.php', ['title' => $Title, 'content' => $page_content, 'category'=> $category ]);
print($layout_content);

?>
