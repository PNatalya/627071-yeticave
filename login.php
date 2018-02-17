<?php
require_once('functions.php');
require_once('data.php');
require_once('userdata.php');

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
		if ($user = search_user($userlog['email'], $users)) {
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
	}	

	if (count($errors)) {
		$page_content = include_template('templates/login.php', ['user'=> $userlog, 'category'=> $category, 'errors' => $errors, 'dict' => $dict]);
	}
	else {
		header("Location: /index.php");
		exit();
	}
}
else {
    if (isset($_SESSION['user'])) {
		$user = null;
		$user = auth_user($user);
        $page_content = include_template('templates/index.php', ['ads'=> $ads]);
		
    }
    else {
        $page_content = include_template('templates/login.php', ['category'=> $category]);
    }
}


$Title="Аутентификация";
$layout_content = Include_Template('templates/layout.php', ['title' => $Title, 'user' => $user, 'content' => $page_content, 'category'=> $category ]);
print($layout_content);

?>
