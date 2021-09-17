<?php 
require_once 'crest.php';

/**
*  Returns the date in ISO8601 format
* @var $day integer, specifies how many days to add to the current date
* @return date format ISO8601
*/

function dateISO(int $day = 0){
	if ($day == 0) {
		$date = time();
	}else{
		$date = strtotime('+'.$day.' day');
	}
	return date(DateTime::ISO8601, $date);
}


?>