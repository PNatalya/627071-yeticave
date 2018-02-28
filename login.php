<?php
require_once('init.php');

$sql = 'SELECT `id`, `name` FROM Category';
$result = mysqli_query($link, $sql);
if ($result) {
	$category = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	session_start();
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$userlog = $_POST;
		$required_fields = ['email' => 'email', 'password' => 'pass'];
		$dict = ['email' => 'E-mail', 'password' => 'Пароль'];
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
	
		if (!count($errors)) {
			$sql = "SELECT id, name, password, email, avatar_path FROM Users
				where email = ?";
			$safe_email = mysqli_real_escape_string($link, $userlog['email']);
			$stmt = db_get_prepare_stmt($link, $sql, [$safe_email]);
			if ((mysqli_stmt_execute($stmt) == !TRUE)
			or (($result = mysqli_stmt_get_result($stmt)) === FALSE)
			or (mysqli_stmt_close ($stmt) === FALSE)) {
				$error = mysqli_error($link);
				$page_content = include_template('error.php', ['error' => $error]);
			} else {
				$records_count = mysqli_num_rows($result);
				if ($records_count > 0) {
					$user = mysqli_fetch_assoc($result);
					if (password_verify($userlog['password'], $user['password'])) {
						$_SESSION['user'] = $user;
					}
					else {
						$errors['password'] = 'Вы ввели неверный пароль';
					}
				}
				else {
					$errors['email'] = 'Такой пользователь не найден';
				}
				if (count($errors)) {
					$page_content = include_template('login.php', ['user'=> $userlog, 'category'=> $category, 'errors' => $errors, 'dict' => $dict]);
				}
				else {
					header("Location: /index.php");
					exit();
				}
			}
		}	
		else {
			$page_content = include_template('login.php', ['user'=> $userlog, 'category'=> $category, 'errors' => $errors, 'dict' => $dict]);
		}
	}
	else {
		if (isset($_SESSION['user'])) {
			$user = null;
			$user = auth_user($user);
			$sql = 'select l.`id`, l.`name`, l.`rate` as `price`, UNIX_TIMESTAMP(l.`dt_close`) as dt_close, l.`img`, c.`name` as `category` 
				from lots l
				JOIN category c ON l.category_id=c.id
				order by dt_add desc';	
			$result = mysqli_query($link, $sql);
			if ($result) {
				$ads = mysqli_fetch_all($result, MYSQLI_ASSOC);
				$page_content = include_template('index.php', ['ads'=> $ads]);
			}
			else {
				$error = mysqli_error($link);
				$page_content = include_template('error.php', ['error' => $error]);
			}
		}
		else {
			$page_content = include_template('login.php', ['category'=> $category]);
		}
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
