<?php

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
		require_once($filename);
	};
	
	return ob_get_clean();
}

?>