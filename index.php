<?php
require_once('functions.php');

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';
$category = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
$ads = [
	ad1 => [
	'name' => '2014 Rossignol District Snowboard',
	'category' => 'Доски и лыжи',
	'price' => 10999,
	'img' => 'img/lot-1.jpg'
	],
	ad2 => [
	'name' => 'DC Ply Mens 2016/2017 Snowboard',
	'category' => 'Доски и лыжи',
	'price' => 159999,
	'img' => 'img/lot-2.jpg'
	],
	ad3 => [
	'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
	'category' => 'Крепления',
	'price' => 8000,
	'img' => 'img/lot-3.jpg'
	],
	ad4 => [
	'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
	'category' => 'Ботинки',
	'price' => 10999,
	'img' => 'img/lot-4.jpg'
	],
	ad5 => [
	'name' => 'Куртка для сноуборда DC Mutiny Charocal',
	'category' => 'Одежда',
	'price' => 7500,
	'img' => 'img/lot-5.jpg'
	],
	ad6 => [
	'name' => 'Маска Oakley Canopy',
	'category' => 'Разное',
	'price' => 5400,
	'img' => 'img/lot-6.jpg'
	]
	
];
function format_sum($price) {
	$price = ceil($price);
	If ($price >= 1000) {
		$price = number_format ( $price , 0 , "." , " " );
	};
	$price .= "&nbsp;&#8381";

	return $price;
}

$page_content = Include_Template('templates/index.php', ['ads'=> $ads]);

$layout_content = Include_Template('templates/layout.php', ['title' => 'Главная', 'content' => $page_content, 'category'=> $category ]);

print($layout_content);
?>
