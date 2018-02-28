<?php
session_start();

function auth_user($user) {
	session_start();
	$user = null;
	if (isset($_SESSION['user'])) {
		$user['is_auth'] = True;
		$user['user_name'] = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : '';
		$user['user_avatar'] = isset($_SESSION['user']['avatar_path']) ? $_SESSION['user']['avatar_path'] : '';
	}
	return $user;
}

/*
function search_user($email, $users) {
	$result = null;
	foreach ($users as $user) {
		if ($user['email'] == $email) {
			$result = $user;
			break;
		}
	}
	return $result;
}
*/
function format_sum($price) {
	$price = ceil($price);
	If ($price >= 1000) {
		$price = number_format ( $price , 0 , "." , " " );
	};
	$price .= "&nbsp;&#8381";

	return $price;
}

function timelot($timelot) {
	$timelot = $timelot - time();
	$day = floor($timelot/86400);
	$hour = floor(($timelot%86400)/3600);
	$minut = floor(($timelot%3600)/60);
	$timelot = (($day == 0) ? "" : $day.'д ').sprintf("%02d:%02d", $hour, $minut);	
	
	return $timelot;
}

function Include_Template($filename, $arr = array()) {
    $filename = 'templates/' . $filename;
    $result = '';	
	if (file_exists($filename)) {	
		ob_start();
		extract($arr);
		require($filename);
	};
	$result = ob_get_clean();
	return $result;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}
?>