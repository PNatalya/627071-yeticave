<?php
require_once('init.php');

$user = null;
$user = auth_user($user,$link);

$lot = null;

$sql = 'SELECT `id`, `name` FROM Category';
$result = mysqli_query($link, $sql);
if ($result) {
	$category = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ((!isset($user['is_auth'])) || (!$user['is_auth'])) {
		http_response_code(403);
		$error = "Доступ к добавлению ставок запрещен для незарегистрированных пользователей";
		$page_content = include_template('error.php', ['error' => $error]);
	}
	else {
		$res = $_POST;
		if ((empty($res['cost'])) or ((!filter_var($res['cost'],FILTER_VALIDATE_INT)) or ($res['cost'] < 0))) { 
			$errors['cost'] = 'В поле возможны только целые положительные числа';
		}
		
	}
	if (isset($_GET['lot_id'])) {
		$lot_id = $_GET['lot_id'];
		$sql = 'select l.id, l.name, l.description, UNIX_TIMESTAMP(l.dt_close) as dt_close, l.img, c.name as category, 
			IFNULL(r.max_rate, l.rate) as price, (IFNULL(r.max_rate, l.rate) + l.step) as minrate
			from lots l
			JOIN category c ON l.category_id=c.id
			LEFT JOIN (Select max(summa) as max_rate, lot_id from rates
			where lot_id = ?
			group by lot_id	) r 
			ON r.lot_id = l.id
			where l.dt_close > NOW() and l.id =? ';	
		$stmt = db_get_prepare_stmt($link, $sql, [$lot_id, $lot_id]);
		if ((mysqli_stmt_execute($stmt) == !TRUE)
			or (($result = mysqli_stmt_get_result($stmt)) === FALSE)
			or (mysqli_stmt_close ($stmt) === FALSE)) {
			$error = mysqli_error($link);
			$page_content = include_template('error.php', ['error' => $error]);
		} 
		else {
			$lot = mysqli_fetch_assoc($result);
			if (!$lot) {
				http_response_code(404);
				header('Location:./404.php');
				exit(); 
			}
			if ($res['cost'] < $lot['minrate']) {
				$errors['cost'] = 'Указана неверная ставка. Минимальная ставка '.$lot['minrate'] ;
			}
			
			If (!count($errors)) {
				$sql = 'INSERT INTO rates (dt_add, summa, lot_id, user_id)
					values (NOW(), ?, ?, ?)';
				$stmt = db_get_prepare_stmt($link, $sql, [$res['cost'], $lot_id, $user['user_id']]);
				$result = mysqli_stmt_execute($stmt);
				if ($result) {
				}
				else {
					$error = mysqli_error($link);
					$page_content = include_template('error.php', ['error' => $error]);
				}
			}
		}
	}
	else {
		http_response_code(404);
		header('Location:./404.php');
		exit(); 
	}
}

if (isset($_GET['lot_id'])) {
	$lot_id = $_GET['lot_id'];
	$sql = 'SELECT COUNT(*) as cnt FROM rates where user_id =? and lot_id=?';
	$stmt = db_get_prepare_stmt($link, $sql, [$user['user_id'], $lot_id ]);
	if ((mysqli_stmt_execute($stmt) == !TRUE)
		or (($result = mysqli_stmt_get_result($stmt)) === FALSE)
		or (mysqli_stmt_close ($stmt) === FALSE)) {
			$error = mysqli_error($link);
			$page_content = include_template('error.php', ['error' => $error]);
		}
	else {
		$rates_count = mysqli_fetch_assoc($result)['cnt'];
	}
	$sql = 'select l.id, l.name, l.description, UNIX_TIMESTAMP(l.dt_close) as dt_close, l.img, l.user_id, c.name as category, 
		IFNULL(r.max_rate, l.rate) as price, (IFNULL(r.max_rate, l.rate) + l.step) as minrate
		from lots l
		JOIN category c ON l.category_id=c.id
		LEFT JOIN (Select max(summa) as max_rate, lot_id from rates
		where lot_id = ?
		group by lot_id	) r 
		ON r.lot_id = l.id
		where l.dt_close > NOW() and l.id =? ';	
	$stmt = db_get_prepare_stmt($link, $sql, [$lot_id, $lot_id]);
	if ((mysqli_stmt_execute($stmt) == !TRUE)
		or (($result = mysqli_stmt_get_result($stmt)) === FALSE)
		or (mysqli_stmt_close ($stmt) === FALSE)) {
		$error = mysqli_error($link);
		$page_content = include_template('error.php', ['error' => $error]);
	} 
	else {
		$lot = mysqli_fetch_assoc($result);
		if (!$lot) {
			http_response_code(404);
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
			$Title=htmlspecialchars($lot['name']);
			$show_rate = ($lot['dt_close'] > (new DateTime())) && ($user['user_id'] !== $lot['user_id']) && ($rates_count==0);  
			$sql = "SELECT UNIX_TIMESTAMP(r.dt_add) as dt_add, summa, u.name FROM rates r
				LEFT JOIN users u ON u.id = r.user_id
				WHERE lot_id=? ORDER BY dt_add DESC LIMIT 10";
			$stmt = db_get_prepare_stmt($link, $sql, [$lot_id]);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$rates = mysqli_fetch_all($result, MYSQLI_ASSOC);
			$tpl_data = [
				'lot'=> $lot,
				'user' => $user,
				'errors' => $errors , 
				'rescost' => $res['cost'],
				'show_rate' => $show_rate,
				'rates' => $rates  
				];
			$page_content = Include_Template('lot.php', $tpl_data);
		}	
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
