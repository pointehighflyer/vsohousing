<?php
//some helpful functions
	
	//parses a date from mysql format (YYYY-MM-DD) to standard U.S format (MM/DD/YYYY)
	function parseDate($date){
		$parse = explode('-',$date);
		return $parse[1].'/'.$parse[2].'/'.$parse[0];
	}
?>