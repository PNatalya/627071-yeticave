<?php
session_start();


/**
 * Отправляет письмо победителю
 *
 * @param $email Адрес эл.почты победителя
 * @param $user_name Имя победителя
 * @param $lot_name Наименование лота
 * @param $price Цена лота
 *
 * @return 
 */
function send_mail($email, $user_name, $lot_name, $price) {

	$subject = "Победитель аукциона"; 

	$message = ' <p>Поздравляем! '.$user_name.'! Вы победили в аукционе!</p> </br> <b>Лот '.$lot_name.' </b> </br><i>Цена '.$price.' </i> </br>';

	$headers  = "Content-type: text/html; charset=windows-1251 \r\n"; 

	mail($email, $subject, $message, $headers); 
	
}

/**
 * Определяет победителей аукциона
 *
 * @param $link Соединение с БД
 *
 * @return 
 */
function set_winner($link) {
    $sql = 'SELECT l.id, l.name
			FROM lots l
			WHERE l.winner_id is null and l.dt_close <= NOW() ';
		$result = mysqli_query($link, $sql);
		if ($result) {
			$win_lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
		foreach ($win_lots as $win_lot) {
			$lot_id = $win_lot['id'];
			$lot_name = $win_lot['name'];
			$sql = 'SELECT r.summa, r.lot_id, u.id,  u.name, u.email 
				FROM rates r, users u
				WHERE lot_id ='.$lot_id.'
				and u.id = r.user_id
				order by summa desc limit 1 ';
			$result = mysqli_query($link, $sql);
			if ($result) {
				$win_user = mysqli_fetch_assoc($result);
				$win_id = $win_user['id'];
				$win_name = $win_user['name'];
				$win_email = $win_user['email'];
				$win_sum = $win_user['summa'];

				$sql = 'UPDATE lots SET winner_id='.$win_id .' WHERE id ='.$lot_id ; 
		
				$stmt = db_get_prepare_stmt($link, $sql, [$lot['name'], $lot['message'], $lot['img'], $lot['rate'], $lot['step'], $lot['date'], $user['user_id'] ]);
				$result = mysqli_stmt_execute($stmt);
				if ($result) {
					send_mail($win_email, $win_name, $lot_name, $win_sum);
				}
			}
		}
	}
}


/**
 * Проверяет была ли выполнена авторизация пользователя
 *
 * @param $user array
 *
 * @return $user заполненный(пустой) массив с параметрами авторизованного пользователя
 */
function auth_user($user, $link) {
	session_start();
	$user = null;
	if (isset($_SESSION['user'])) {
		$safe_email = mysqli_real_escape_string($link, (isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : ''));
		$result = mysqli_query($link, 'SELECT COUNT(*) as cnt FROM users WHERE email="'.$safe_email.'"');
		$user_count = mysqli_fetch_assoc($result)['cnt'];

		if ($user_count == 0) {
			$_SESSION=[];
		}
		else {
			$user['is_auth'] = TRUE;
			$user['user_id'] = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';
			$user['user_name'] = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : '';
			$user['user_avatar'] = isset($_SESSION['user']['avatar_path']) ? $_SESSION['user']['avatar_path'] : '';
		}
	}
	return $user;
}

/**
 * Определяет прошешдшее время от указанной даты и 
 * возвращает в формате указанной строки
 * 
 * @param $dt date 
 *
 * @return форматированная строка времени
 */
function passed_time($dt){
	$dt_dif = time() - $dt;	
	$minutes_ago = floor($dt_dif/60);
	$hour_ago = floor($dt_dif/3600);
	$tm = date('H:i', $dt);
	$d = date('d', $dt);
	$m = date('m', $dt);
	$y = date('y', $dt);

	
	if ($hour_ago <1 ) {
		$dt = sprintf('%s мин. назад', $minutes_ago);}
	elseif ($hour_ago == 1 ) {
		$dt = sprintf('%s час назад', $hour_ago);}
	elseif ($hour_ago > 1 && $hour_ago <= 4) {
		$dt = sprintf('%s часа назад', $hour_ago);}
	elseif($d.$m.$y == date('dmy',time())) {
		$dt = sprintf('Сегодня в %s', $tm);}
	elseif($d.$m.$y == date('dmy', strtotime('-1 day'))){
		$dt = sprintf('Вчера в %s', $tm);}
	else {$dt = sprintf('%s.%s.%s в %s', $d, $m, $y, $tm);}
	
	return $dt;
}

/**
 * Форматирует сумму для вывода и добавляет символ рубля
 *
 * @param $price float Сумма
 *
 * @return $price string форматированнная сумма
 */
function format_sum($price) {
	$price = ceil($price);
	If ($price >= 1000) {
		$price = number_format ( $price , 0 , "." , " " );
	};
	$price .= "&nbsp;&#8381"; /* Пробел, знак рубля */

	return $price;
}

/**
 * Форматирует время, оставшееся до окончания лота дни, часы:минуты
 *
 * @param $timelot date Дата закрытия лота
 *
 * @return $timelot string форматированнный период
 */
function timelot($timelot) {
	$timelot = $timelot - time();
	$day = floor($timelot/86400);
	$hour = floor(($timelot%86400)/3600);
	$minut = floor(($timelot%3600)/60);
	$timelot = (($day == 0) ? "" : $day.'д ').sprintf("%02d:%02d", $hour, $minut);	
	
	return $timelot;
}

/**
 * Функция шаблонизации
 *
 * @param $filename string Имя подключаемого файла
 * @param $arr array Массив параметров подключения
 *
 * @return $result Сонтейнер с результатом файла
 */

function include_template($filename, $arr = array()) {
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