<?php
session_start();

function auth_user($user) {
	session_start();
	$user = null;
	if (isset($_SESSION['user'])) {
		$user['is_auth'] = True;
		$user['user_name'] = $_SESSION['user'][name];
		$user['user_avatar'] = 'img/user.jpg';
	}
	return $user;
}


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
	$hour = floor($timelot/3600);
	$minut = floor(($timelot%3600)/60);
	$timelot = sprintf("%02d:%02d", $hour, $minut);	
	
	return $timelot;
}

function Include_Template($filename, $arr = array()) {
	if (file_exists($filename)) {	
		ob_start();
		extract($arr);
		require($filename);
	};
	return ob_get_clean();
}

?>