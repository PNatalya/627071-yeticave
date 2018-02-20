<?php
require_once('functions.php');
require_once('data.php');

$user = null;
$user = auth_user($user);

$new_array=[];
$array_value=[];
if (isset($_COOKIE['openLots'])) {
	$array_value = json_decode($_COOKIE['openLots']);
	foreach ($ads as $key => $val){
       	If (in_array($key, $array_value)) {
               $new_array[$key] = $val;
        }    
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$cur_cat_id = $_GET['cur_cat_id'];
}

$Title="История просмотров";
$page_content = Include_Template('templates/history.php', ['cur_cat_id' => $cur_cat_id, 'ads'=> $new_array, 'category'=> $category ]);
$layout_content = Include_Template('templates/layout.php', ['title' => $Title, 'user' => $user, 'content' => $page_content, 'category'=> $category ]);
print($layout_content);

?>
