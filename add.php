<?php
require_once('functions.php');
require_once('data.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$lot = $_POST;
	$required_fields = ['name' => 's', 'category' => 's', 'message' => 's', 'rate' => 'n', 'step' => 'n', 'date'  => 'd'];
	$dict = ['name' => 'Наименование', 'category' => 'Категория', 'message' => 'Описание', 'rate' => 'Начальная цена', 'step' => 'Ставка', 'date'  => 'Дата окончания торгов', 'photo2'  => 'Изображение'];
	$errors = [];
	foreach ($required_fields as $key=> $val) {
		if (empty($_POST[$key])) {
			$errors[$key] = 'Поле не заполнено';
		}
		if ($val == 'n') {
			if ((!filter_var($_POST[$key],FILTER_VALIDATE_INT)) or ($_POST[$key] < 0)) {
				$errors[$key] = 'В поле возможны только целые положительные числа'; 
			}
		}
		if ($val == 'd') {
			if ((!strtotime($_POST[$key])) or (strtotime($_POST[$key]) < time())) {
				$errors[$key] = 'Некорректно указана дата';
			}
		}
	}
	
	if (isset($_FILES['photo2']['name'])) {
		$tmp_name = $_FILES['photo2']['tmp_name'];
		$path = $_FILES['photo2']['name'];				
		$file_size = $_FILES['photo2']['size'];

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file_type = finfo_file($finfo, $tmp_name);
		if (!(($file_type == 'image/gif')  or ($file_type == 'image/jpeg'))) {
			$errors['photo2'] = "Загрузите картинку в формате Gif или JPEG";
		}
		elseif ($file_size > 200000) {
			$errors['photo2'] = "Максимальный размер файла: 200Кб";
		}
		else {
			move_uploaded_file($tmp_name, 'img/' . $path);
			$lot['img'] = 'img/' . $path;
		}
	}
	else {
		$errors['photo2'] = 'Вы не загрузили файл';
	}		
	
	
	if (count($errors)) {
		$lot['img']="";
		$page_content = include_template('templates/add.php', ['lot' => $lot, 'errors' => $errors, 'dict' => $dict, 'category'=> $category ]);
	}
	else {
		$page_content = include_template('templates/lot.php', ['lot'=> $lot, 'category'=> $category ]);
	}	
	
}
else {
	$page_content = include_template('templates/add.php', ['lot' => $lot, 'category'=> $category, 'Title'=> 'Добавление лота' ]);
}


if (isset($lot['name'])) {
	$Title = htmlspecialchars($lot['name']);
}
else {
	$Title= "Добавление лота";
}

$layout_content = Include_Template('templates/layout.php', ['title' => $Title, 'content' => $page_content, 'category'=> $category ]);

print($layout_content);
?>
