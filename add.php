<?php
require_once('functions.php');
require_once('data.php');

$user = null;
$user = auth_user($user);

if ((!isset($user['is_auth'])) || (!$user['is_auth'])) {
	http_response_code(403);
/*	header( 'HTTP/1.1 403 Forbidden', true, 403 ); 
	header('Location:./login.php');*/
	echo("Доступ к добавлению лотов запрещен для незарегистрированных пользователей");
	echo("<br> <a href='index.php'>На главную</a>");
	exit(); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$lot = $_POST;
	$required_fields = ['name' => 's', 'category' => 'c', 'message' => 's', 'rate' => 'n', 'step' => 'n', 'date'  => 'd'];
	$dict = ['name' => 'Наименование', 'category' => 'Категория', 'message' => 'Описание', 'rate' => 'Начальная цена', 'step' => 'Ставка', 'date'  => 'Дата окончания торгов', 'photo2'  => 'Изображение'];
	$errors = [];
	foreach ($required_fields as $key=> $val) {
		if (empty($lot[$key])) {
			$errors[$key] = 'Поле не заполнено';
		}
		if ($val == 'c') {
			if (!in_array($lot[$key], $category)) {
				$errors[$key] = 'Не выбрана категория'; 
			}
		}
		if ($val == 'n') {
			if ((!filter_var($lot[$key],FILTER_VALIDATE_INT)) or ($lot[$key] < 0)) {
				$errors[$key] = 'В поле возможны только целые положительные числа'; 
			}
		}
		if ($val == 'd') {
			if ((!strtotime($lot[$key])) or (strtotime($lot[$key]) < time())) {
				$errors[$key] = 'Некорректно указана дата';
			}
		}
	}
	
	if ($_FILES['photo2']['size'] > 0)	{
/*	if (isset($_FILES['photo2']['name'])) {*/
		$tmp_name = $_FILES['photo2']['tmp_name'];
		$path = $_FILES['photo2']['name'];				
		$file_size = $_FILES['photo2']['size'];

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file_type = finfo_file($finfo, $tmp_name);
		if (!(($file_type == 'image/png')  or ($file_type == 'image/jpeg'))) {
			$errors['photo2'] = "Загрузите картинку в формате PNG или JPEG";
		}
		elseif ($file_size > 200000) {
			$errors['photo2'] = "Максимальный размер файла: 200Кб";
		}
	}
	else {
		$errors['photo2'] = 'Вы не загрузили файл';
	}		
	
	
	if (count($errors)) {
		$page_content = include_template('templates/add.php', ['lot' => $lot, 'errors' => $errors, 'dict' => $dict, 'category'=> $category ]);
	}
	else {
		move_uploaded_file($tmp_name, 'img/' . $path);
		$lot['img'] = 'img/' . $path;
		$page_content = include_template('templates/lot.php', ['lot'=> $lot, 'user' => $user, 'category'=> $category ]);
	}	
	
}
else {
	$page_content = include_template('templates/add.php', ['lot' => $lot, 'category'=> $category, 'Title'=> 'Добавление лота' ]);
}


if ((!count($errors)) && (isset($lot['name']))) {
	$Title = htmlspecialchars($lot['name']);
}
else {
	$Title= "Добавление лота";
}

$layout_content = Include_Template('templates/layout.php', ['title' => $Title, 'user' => $user, 'content' => $page_content, 'category'=> $category ]);

print($layout_content);
?>
