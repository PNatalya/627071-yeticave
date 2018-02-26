<?php
require_once('init.php');

$user = null;
$user = auth_user($user);

$sql = 'SELECT `id`, `name` FROM Category';
$result = mysqli_query($link, $sql);
if ($result) {
	$category = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ((!isset($user['is_auth'])) || (!$user['is_auth'])) {
	http_response_code(403);
	$error = "Доступ к добавлению лотов запрещен для незарегистрированных пользователей";
    $page_content = include_template('error.php', ['error' => $error]);
}
else {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$lot = $_POST;
	$required_fields = ['name' => 's', 'category' => 'c', 'message' => 's', 'rate' => 'n', 'step' => 'n', 'date'  => 'd'];
	$errors = [];
	foreach ($required_fields as $key=> $val) {
		if (empty($lot[$key])) {
			$errors[$key] = 'Поле не заполнено';
		}
		if ($val == 'c') {
			$sql = 'SELECT `id` FROM Category where name="'.$lot[$key].'"';
			$result = mysqli_query($link, $sql);
			if ($result) {
				$records_count = mysqli_num_rows($result);
				if ($records_count < 1) {
					$errors[$key] = 'Не выбрана категория'; 
				}
			}
			else {
				$errors[$key] = 'Ошибка подключения к таблице Категории'; 
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
		$page_content = include_template('add.php', ['lot' => $lot, 'errors' => $errors, 'category'=> $category ]);
	}
	else {
		move_uploaded_file($tmp_name, 'img/' . $path);
		$lot['img'] = 'img/' . $path;
		
		$sql = 'INSERT INTO lots (dt_add, name, description, img, rate, dt_close, user_id, category_id) 
		values (NOW(), ?, ?, ?, ?, ?, 1, (Select  c.id from category c where c.name="'.$lot['category'].'" limit 1))';
		
		$stmt = db_get_prepare_stmt($link, $sql, [$lot['name'], $lot['message'], $lot['img'], $lot['rate'], $lot['date'] ]);
        $result = mysqli_stmt_execute($stmt);
		if ($result) {
			$lot_id = mysqli_insert_id($link);
			header("Location: lot.php?lot_id=" . $lot_id);
		}
		else {
			$error = mysqli_error($link);
			$page_content = include_template('error.php', ['error' => $error]);
		}
	}	
}
else {
	$page_content = include_template('add.php', ['lot' => $lot, 'category'=> $category, 'Title'=> 'Добавление лота' ]);
}


if ((!count($errors)) && (isset($lot['name']))) {
	$Title = htmlspecialchars($lot['name']);
}
else {
	$Title= "Добавление лота";
}
}
}
else {
	$error = mysqli_error($link);
	$page_content = include_template('error.php', ['error' => $error]);
}

$layout_content = Include_Template('layout.php', ['title' => $Title, 'user' => $user, 'content' => $page_content, 'category'=> $category ]);

print($layout_content);
?>
