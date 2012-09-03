<?php
//Contains functions shared by supporting classes
define('DUPLICATE_RECORD', 1062);

//appends the specified text to the specified file name
function writeToLog($text,$fileName){
	$pointer = fopen($fileName,"a+");
	$data = date("d/m/y H:i:s")." ".$text."\n";
	fputs($pointer,$data);
	fclose($pointer);
}


//unloads the contents of the array to the specified object type
//to be used in conjunction with database functions
//@param $arr: an array containing field data passed in from the form
//@param $obj: the object to be unloaded into
//@returns void: $obj has it's fields defined
function unload($arr, &$obj){
	//print_r($arr);
	//echo 'Object Type: '.$obj->type.'<br/>';
	if($obj->type == 'Host'){
		//echo 'Setting Host info<br/>';
		$obj->hostID = $arr['h_hostID'];
		$obj->firstName = $arr['h_firstName'];
		$obj->lastName = $arr['h_lastName'];
		$obj->firstName2 = $arr['h_firstName2'];
		$obj->lastName2 = $arr['h_lastName2'];
		$obj->streetAddr = $arr['h_streetAddr'];
		$obj->town = $arr['h_town'];
		$obj->zip = $arr['h_zip'];
		$obj->region = $arr['h_region'];
		$obj->homePhone = $arr['h_homePhone'];
		$obj->workPhone = $arr['h_workPhone'];
		$obj->cellPhone = $arr['h_cellPhone'];
		$obj->phone = $arr['h_phone'];
		$obj->primaryPhone = $arr['h_primaryPhone'];
		$obj->email = $arr['h_email'];
		$obj->altEmail = $arr['h_altEmail']; 
		$obj->isActive = $arr['h_isActive'];
		//$obj->hasChildren = $arr['h_hasChildren'];
		$obj->hasCats = $arr['h_hasCats'];
		$obj->hasDogs = $arr['h_hasDogs'];
		$obj->smokingHouse = $arr['h_smokingHouse'];
		$obj->smokingAllowed = $arr['h_smokingAllowed'];
		$obj->singlesAllowed = $arr['h_singlesAllowed'];
		$obj->max = $arr['h_max'];
		$obj->rooms = $arr['h_rooms'];
		$obj->singleBeds = $arr['h_singleBeds'];
		$obj->doubleBeds = $arr['h_doubleBeds'];
		$obj->startDate = $arr['h_startDate'];
		$obj->prefMen = $arr['h_prefMen'];
		$obj->prefWomen = $arr['h_prefWomen'];
		//$obj->partnerID = $arr['h_partnerID'];
		//$obj->partner = $arr['h_partner'];
		$obj->directions = $arr['h_directions'];
		$obj->notes = $arr['h_notes'];
	}
	elseif($obj->type == 'Musician'){
		//echo 'Setting Musician info<br/>';
		$obj->musicianID = $arr['m_musicianID'];
		$obj->firstName = $arr['m_firstName'];
		$obj->lastName = $arr['m_lastName'];
		$obj->instrument = $arr['m_instrument'];
		$obj->town = $arr['m_town'];
		$obj->state = $arr['m_state'];
		$obj->smokes = $arr['m_smokes'];
		$obj->smokingAllowed = $arr['m_smokingAllowed'];
		//$obj->allergy = $arr['m_allergy'];
		$obj->allrgCats = $arr['m_allrgCats'];
		$obj->allrgDogs = $arr['m_allrgDogs'];
		$obj->allrgSmoke = $arr['m_allrgSmoke'];
		//$obj->likeBikePath = $arr['m_likeBikePath'];
		//$obj->likeDowntown = $arr['m_likeDowntown'];
		//$obj->carpools = $arr['m_carpools'];
		$obj->primaryHost = $arr['m_primaryHost'];
		$obj->notes = $arr['m_notes'];
	}
	elseif($obj->type == 'Event'){
		//echo 'Setting Event info<br/>';
		$obj->eventID = $arr['e_eventID'];
		$obj->title = $arr['e_title'];
		$obj->region = $arr['e_region'];
		$obj->date = $arr['e_date'];
		$obj->arrivalDate = $arr['e_arrivalDate'];
		$obj->description = $arr['e_description'];
		//$obj->streetAddr = $arr['e_streetAddr'];
		//$obj->town = $arr['e_town'];
		//$obj->zip = $arr['e_zip'];
		$obj->status = $arr['e_status'];
		$obj->notes = $arr['e_notes'];
	}
	elseif($obj->type == 'HostEvent'){
		echo 'Setting HostEvent info<br/>';
		$obj->hostID = $arr['he_hostID'];
		$obj->eventID = $arr['he_eventID'];
		$obj->isActive = $arr['he_isActive'];
		$obj->freeTixReq = $arr['he_freeTixReq'];
		$obj->halfPrTixReq = $arr['he_halfPrTixReq'];
		$obj->fullPrTixReq = $arr['he_fullPrTixReq'];
		$obj->reason = $arr['he_reason'];
		$obj->notes = $arr['he_notes'];
	}
	elseif($obj->type == 'MusicianEvent'){
		echo 'Setting MusicianEvent info<br/>';
		$obj->musicianID = $arr['me_musicianID'];
		$obj->eventID = $arr['me_eventID'];
		$obj->hostID = $arr['me_hostID'];
	}
	else{ echo 'Error: Object type '.$obj->type.' not recognized.';}
}

//opposite of unload, loads fields from the object into assoc array
function load(&$arr, $obj){
	if($obj->type == 'Host'){
		$arr['h_hostID'] = $obj->hostID;
		$arr['h_firstName'] = $obj->firstName;
		$arr['h_lastName'] = $obj->lastName;
		$arr['h_firstName2'] = $obj->firstName2;
		$arr['h_lastName2'] = $obj->lastName2;
		$arr['h_streetAddr'] = $obj->streetAddr;
		$arr['h_town'] = $obj->town;
		$arr['h_zip'] = $obj->zip;
		$arr['h_region'] = $obj->region;
		$arr['h_homePhone'] = $obj->homePhone;
		$arr['h_workPhone'] = $obj->workPhone;
		$arr['h_cellPhone'] = $obj->cellPhone;
		$arr['h_phone'] = $obj->phone;
		$arr['h_primaryPhone'] = $obj->primaryPhone;
		$arr['h_email'] = $obj->email;
		$arr['h_altEmail'] = $obj->altEmail;
		$arr['h_isActive'] = $obj->isActive;
		//$arr['h_hasChildren'] = $obj->hasChildren;
		$arr['h_hasCats'] = $obj->hasCats;
		$arr['h_hasDogs'] = $obj->hasDogs;
		$arr['h_smokingHouse'] = $obj->smokingHouse;
		$arr['h_smokingAllowed'] = $obj->smokingAllowed;
		$arr['h_singlesAllowed'] = $obj->singlesAllowed;
		$arr['h_max'] = $obj->max;
		$arr['h_rooms'] = $obj->rooms;
		$arr['h_singleBeds'] = $obj->singleBeds;
		$arr['h_doubleBeds'] = $obj->doubleBeds;
		$arr['h_startDate'] = $obj->startDate;
		$arr['h_prefMen'] = $obj->prefMen;
		$arr['h_prefWomen'] = $obj->prefWomen;
		//$arr['h_partnerID'] = $obj->partnerID;
		//$arr['h_partner'] = $obj->partner;
		$arr['h_directions'] = $obj->directions;
		$arr['h_notes'] = $obj->notes;

	}
	elseif($obj->type == 'Musician'){
		$arr['m_musicianID'] = $obj->musicianID; 
		$arr['m_firstName'] = $obj->firstName; 
		$arr['m_lastName'] = $obj->lastName; 
		$arr['m_instrument'] = $obj->instrument;
		$arr['m_town'] = $obj->town;
		$arr['m_state'] = $obj->state;
		$arr['m_smokes'] = $obj->smokes;
		$arr['m_smokingAllowed'] = $obj->smokingAllowed;
		//$arr['m_allergy'] = $obj->allergy; 
		$arr['m_allrgCats'] = $obj->allrgCats;
		$arr['m_allrgDogs'] = $obj->allrgDogs;
		$arr['m_allrgSmoke'] = $obj->allrgSmoke;
		//$arr['m_likeBikePath'] = $obj->likeBikePath;
		//$arr['m_likeDowntown'] = $obj->likeDowntown;
		//$arr['m_carpools'] = $obj->carpools; 
		$arr['m_primaryHost'] = $obj->primaryHost;
		$arr['m_notes'] = $obj->notes;
		$arr['h_firstName'] = $obj->hostFirst;
		$arr['h_lastName'] = $obj->hostLast;
		$arr['h_firstName2'] = $obj->hostFirst2;
		$arr['h_lastName2'] = $obj->hostLast2;
	}
	elseif($obj->type == 'Event'){	
		$arr['e_eventID'] = $obj->eventID;
		$arr['e_title'] = $obj->title;
		$arr['e_region'] = $obj->region;
		$arr['e_date'] = $obj->date;
		$arr['e_arrivalDate'] = $obj->arrivalDate;
		$arr['e_description'] = $obj->description;
		//$arr['e_streetAddr'] = $obj->streetAddr;
		//$arr['e_town'] = $obj->town;
		//$arr['e_zip'] = $obj->zip;
		$arr['e_status'] = $obj->status;
		$arr['e_notes'] = $obj->notes;
	}
	else{ echo 'Error: Object type '.$obj->type.' not recognized.';}
	
}


//functions to display hosts, musicians and events

function getHost($arr){
	$text = //'Host ID: '.$arr['h_hostID'].'<br/>'.
		'<table id="info"><tbody>'."\n".
		'<tr class="alt"><th>First Name: </th><td>'.stripChars($arr['h_firstName']).'</td></tr>'.
		'<tr><th>Last Name: </th><td>'.stripChars($arr['h_lastName']).'</td></tr>'.
		'<tr class="alt"><th>First Name 2: </th><td>'.stripChars($arr['h_firstName2']).'</td></tr>'.
		'<tr><th>Last Name 2: </th><td>'.stripChars($arr['h_lastName2']).'</td></tr>'.
		'<tr class="alt"><th>Street Address: </th><td>'.stripChars($arr['h_streetAddr']).'</td></tr>'.
		'<tr><th>Town: </th><td>'.stripChars($arr['h_town']).'</td></tr>'.
		'<tr class="alt"><th>Zip: </th><td>'.stripChars($arr['h_zip']).'</td></tr>'.
		'<tr><th>Region: </th><td>'.$arr['h_region'].'</td></tr>'.
		'<tr class="alt"><th>Home Phone: </th><td>'.$arr['h_homePhone'].'</td></tr>'.
		'<tr><th>Work Phone: </th><td>'.$arr['h_workPhone'].'</td></tr>'.
		'<tr class="alt"><th>Cell Phone: </th><td>'.$arr['h_cellPhone'].'</td></tr>'.
		'<tr><th>Primary Phone: </th><td>'.$arr['h_primaryPhone'].'</td></tr>'.
		'<tr class="alt"><th>Email: </th><td>'.$arr['h_email'].'</td></tr>'.
		'<tr><th>Alternate Email: </th><td>'.$arr['h_altEmail'].'</td></tr>'.
		'<tr class="alt"><th>Is Active: </th><td>'.boolToStr($arr['h_isActive']).'</td></tr>'.
		//'<tr><th>Has Children: '.$arr['h_hasChildren'].'</td></tr>'.
		'<tr><th>Has Cats: </th><td>'.boolToStr($arr['h_hasCats']).'</td></tr>'.
		'<tr class="alt"><th>Has Dogs: </th><td>'.boolToStr($arr['h_hasDogs']).'</td></tr>'.
		'<tr><th>Smoking House: </th><td>'.boolToStr($arr['h_smokingHouse']).'</td></tr>'.
		'<tr class="alt"><th>Smoking Allowed: </th><td>'.boolToStr($arr['h_smokingAllowed']).'</td></tr>'.
		'<tr><th>Unmarried Couples Allowed: </th><td>'.boolToStr($arr['h_singlesAllowed']).'</td></tr>'.
		'<tr class="alt"><th>Number of Guests Allowed: </th><td>'.$arr['h_max'].'</td></tr>'.
		'<tr><th>Number of Rooms: </th><td>'.$arr['h_rooms'].'</td></tr>'.
		'<tr class="alt"><th>Number of Single Beds: </th><td>'.$arr['h_singleBeds'].'</td></tr>'.
		'<tr><th>Number of Double Beds: </th><td>'.$arr['h_doubleBeds'].'</td></tr>'.
		'<tr class="alt"><th>Start Date: </th><td>'.parseDate($arr['h_startDate']).'</td></tr>'.
		'<tr><th>Prefers Men: </th><td>'.boolToStr($arr['h_prefMen']).'</td></tr>'.
		'<tr class="alt"><th>Prefers Women: </th><td>'.boolToStr($arr['h_prefWomen']).'</td></tr>'.
		//'<tr><th>Partner ID: </th><td>'.$arr['h_partnerID'].'</td></tr>'.
		//'<tr><th>Partner: </th><td>'.$arr['h_partner'].'</td></tr>'.
		'<tr><th>Directions: </th><td>'.stripChars($arr['h_directions']).'</td></tr>'.
		'<tr class="alt"><th>Notes: </th><td>'.stripChars($arr['h_notes']).'</td></tr></tbody></table>';
	return $text;
}

function getMusician($arr){
	if($arr['m_primaryHost'] == -1){
		$host = 'Unspecified';
	}
	else{
		if($arr['h_firstName2'] != ''){
			if($arr['h_lastName2'] != ''){
				$host = $arr['h_firstName'].' '.$arr['h_lastName'].' and '.$arr['h_firstName2'].' '.$arr['h_lastName2'];
			}
			else{
				$host = $arr['h_firstName'].' and '.$arr['h_firstName2'].' '.$arr['h_lastName'];
			}
		}
		else{
			$host = $arr['h_firstName'].' '.$arr['h_lastName'];
		}
	}
	$text = //'Musician ID: '.$arr['m_musicianID'].'<br/>'.
		'<table id="info"><tbody>'."\n".
		'<tr class="alt"><th>First Name: </th><td>'.stripChars($arr['m_firstName']).'</td></tr>'.
		'<tr><th>Last Name: </th><td>'.stripChars($arr['m_lastName']).'</td></tr>'.
		'<tr class="alt"><th>Town: </th><td>'.stripChars($arr['m_town']).'</td></tr>'.
		'<tr><th>State/Province: </th><td>'.$arr['m_state'].'</td></tr>'.
		'<tr class="alt"><th>Instrument: </th><td>'.stripChars($arr['m_instrument']).'</td></tr>'.
		'<tr><th>Smokes: </th><td>'.boolToStr($arr['m_smokes']).'</td></tr>'.
		'<tr class="alt"><th>Prefers Non-smoking House: </th><td>'.boolToStr($arr['m_smokingAllowed']).'</td></tr>'.
		//'Allergy: '.$arr['m_allergy'].'</td></tr>'.
		'<tr><th>Allergic to Cats: </th><td>'.boolToStr($arr['m_allrgCats']).'</td></tr>'.
		'<tr class="alt"><th>Allergic to Dogs: </th><td>'.boolToStr($arr['m_allrgDogs']).'</td></tr>'.
		'<tr><th>Allergic to Smoke: </th><td>'.boolToStr($arr['m_allrgSmoke']).'</td></tr>'.
		//'Likes Bike Path: '.$arr['m_likeBikePath'].'</td></tr>'.
		//'Likes Downtown: '.$arr['m_likeDowntown'].'</td></tr>'.
		//'Carpools: '.$arr['m_carpools'].'</td></tr>'.
		'<tr class="alt"><th>Primary Host: </th><td>'.$host.'</td></tr>'.
		'<tr><th>Notes: </th><td>'.stripChars($arr['m_notes']).'</td></tr></tbody></table>';
	return $text;
}

function getEvent($arr){
	$text = //'Event ID: '.$arr['e_eventID'].'<br/>'.
		'<table id="info"><tbody>'."\n".
		'<tr class="alt"><th>Type: </th><td>'.stripChars($arr['e_title']).'</td></tr>'.
		'<tr><th>Region: </th><td>'.$arr['e_region'].'</td></tr>'.
		'<tr class="alt"><th>Concert Date: </th><td>'.parseDate(stripChars($arr['e_date'])).'</td></tr>'.
		'<tr><th>Arrival Date: </th><td>'.parseDate(stripChars($arr['e_arrivalDate'])).'</td></tr>'.
		'<tr class="alt"><th>Description: </th><td>'.stripChars($arr['e_description']).'</td></tr>'.
		//'Street Address: '.$arr['e_streetAddr'].'</td></tr>'.
		//'Town: '.$arr['e_town'].'</td></tr>'.
		//'Zip: '.$arr['e_zip'].'</td></tr>'.
		'<tr><th>Status: </th><td>'.$arr['e_status'].'</td></tr>'.
		'<tr class="alt"><th>Notes: </th><td>'.stripChars($arr['e_notes']).'</td></tr></tbody></table>';
	return $text;
}
//takes a date entered as YYYY-MM-DD and converts it to MM/DD/YYYY
function parseDate($date){
	$parse = explode('-',$date);
	return $parse[1].'/'.$parse[2].'/'.$parse[0];
}	

//convert bool 0/1 to yes/no for displaying
function boolToStr($int){
	if($int == 0){
		return '<span class="item">No</span>';
	}
	else{
		return '<span class="item">Yes</span>';
	}
}

function stripChars($str){
	$match = array('\r\n','\n','\\');
	$replace = array("\r\n","\n",'');
	$str = str_replace($match,$replace,$str);
	//$str = str_replace('\\','^^^',$str);
	//$str = htmlspecialchars($str);
	return $str;
}

?>