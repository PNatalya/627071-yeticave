<?php
require_once('init.php');

$Title='Регистрация';
$user = null;
$user = auth_user($user);

$sql = 'SELECT `id`, `name` FROM Category';
$result = mysqli_query($link, $sql);
if ($result) {
	$category = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$userlog = $_POST;
		$required_fields = ['email' => 'email', 'password' => 'pass', 'name' => 'name', 'message' => 'message'];
		$errors = [];
		foreach ($required_fields as $key=> $val) {
			if (empty($userlog[$key])) {
				$errors[$key] = 'Поле не заполнено';
			}
			if ($key == "email") {
				if (!filter_var($userlog[$key], FILTER_VALIDATE_EMAIL)) {
					$errors[$key] = 'Email должен быть корректным';
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
		if (count($errors)) {
			$page_content = include_template('sign-up.php', ['user' => $userlog, 'errors' => $errors, 'category'=> $category ]);
		}
		else {
			$sql = 'SELECT id, name, password, email FROM Users
				where email = ?';
			$stmt = db_get_prepare_stmt($link, $sql, [$userlog['email']]);
			if ((mysqli_stmt_execute($stmt) == !TRUE)
			or (($result = mysqli_stmt_get_result($stmt)) === FALSE)
			or (mysqli_stmt_close ($stmt) === FALSE)) {
				$error = mysqli_error($link);
				$page_content = include_template('error.php', ['error' => $error]);
			} else {
				$records_count = mysqli_num_rows($result);
				if ($records_count > 0) {
					$errors['email'] = 'Пользователь с таким E-mail уже существует!';
				}
				if (count($errors)) {
					$page_content = include_template('sign-up.php', ['user'=> $userlog, 'category'=> $category, 'errors' => $errors]);
				}
				else {
					$userlog['img'] = '';
					if ($_FILES['photo2']['size'] > 0)	{
						move_uploaded_file($tmp_name, 'img/' . $path);
						$userlog['img'] = 'img/' . $path;
					}
					$sql = 'INSERT INTO Users (dt_add, email, name, password, contacts, avatar_path )
					values (NOW(), ?, ?, ?, ?, ?)';
					$userlog['password'] = password_hash($userlog['password'], PASSWORD_DEFAULT);
					$safe_email = mysqli_real_escape_string($link, $userlog['email']);
					$stmt = db_get_prepare_stmt($link, $sql,[$safe_email, $userlog['name'], $userlog['password'], $userlog['message'], $userlog['img'] ]);
					$result = mysqli_stmt_execute($stmt);
					if ($result) {
						header("Location: login.php");
					}
					else {
						$error = mysqli_error($link);
						$page_content = include_template('error.php', ['error' => $error]);
					}
				}
			}
		}	
	}
	else {
		$page_content = include_template('sign-up.php', ['category'=> $category]);

	}
}	
else {
	$error = mysqli_error($link);
	$page_content = include_template('error.php', ['error' => $error]);
}

$Title="Аутентификация";
$layout_content = Include_Template('layout.php', ['title' => $Title, 'user' => $user, 'content' => $page_content, 'category'=> $category ]);
print($layout_content);
?>
