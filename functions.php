<?php


function Include_Template($filename, $arr = array()) {
	
	if (file_exists($filename)) {	
		ob_start();
		extract($arr);
		require_once($filename);
	};
	
	return ob_get_clean();
}

?>