<?php


class HostForm extends Form{
	
	var $type = 'Host';
	//holds the values input by the user
	var $hostID;
	var $firstName;
	var $lastName;
	var $firstName2;
	var $lastName2;
	var $streetAddr;
	var $town;
	var $zip;
	var $region;
	var $burl;
	var $derby;
	var $barre;
	var $randolph;
	var $bf;
	var $quechee;
	var $ludlow;
	var $homePhone;
	var $workPhone;
	var $cellPhone;
	var $phone;
	var $home;
	var $work;
	var $cell;
	var $primaryPhone;
	var $email;
	var $altEmail; 
	var $isActive = 1;
	var $hasChildren = 0;
	var $hasCats;
	var $hasDogs;
	var $smokingHouse;
	var $smokingAllowed;
	var $singlesAllowed;
	var $max;
	var $rooms;
	var $singleBeds;
	var $doubleBeds;
	var $startDate;
	var $day;
	var $month;
	var $year;
	var $prefMen;
	var $prefWomen;
	var $partnerID = 0;
	var $partner;
	var $directions;
	var $notes;
	
	
	
	var $form; //contents of the form
	var $hostList = array();
	var $errorList = array();
	
	
	
	function HostForm(){
		//echo 'called hostform constructor<br/>';
		parent::Form('post');
		$this->startDate = date('Y-m-d');
		//echo '<p>Date: '.date('Y-m-d').'</p>';
	}

	
	//returns an array of all of the values
	function getArray(){
		$arr = array();
		$arr['h_firstName'] = $this->firstName;
		$arr['h_lastName'] = $this->lastName;
		$arr['h_firstName2'] = $this->firstName2;
		$arr['h_lastName2'] = $this->lastName2;
		$arr['h_streetAddr'] = $this->streetAddr;
		$arr['h_town'] = $this->town;
		$arr['h_zip'] = $this->zip;
		$arr['h_region'] = $this->region;
		$arr['h_homePhone'] = $this->homePhone;
		$arr['h_workPhone'] = $this->workPhone;
		$arr['h_cellPhone'] = $this->cellPhone;
		$arr['h_phone'] = $this->phone;
		$arr['h_primaryPhone'] = $this->primaryPhone;
		$arr['h_email'] = $this->email;
		$arr['h_altEmail'] = $this->altEmail;
		$arr['h_isActive'] = $this->isActive;
		//$arr['h_hasChildren'] = $this->hasChildren;
		$arr['h_hasCats'] = $this->hasCats;
		$arr['h_hasDogs'] = $this->hasDogs;
		$arr['h_smokingHouse'] = $this->smokingHouse;
		$arr['h_smokingAllowed'] = $this->smokingAllowed;
		$arr['h_singlesAllowed'] = $this->singlesAllowed;
		$arr['h_max'] = $this->max;
		$arr['h_rooms'] = $this->rooms;
		$arr['h_singleBeds'] = $this->singleBeds;
		$arr['h_doubleBeds'] = $this->doubleBeds;
		$arr['h_startDate'] = $this->startDate;
		$arr['h_prefMen'] = $this->prefMen;
		$arr['h_prefWomen'] = $this->prefWomen;
		//$arr['h_partnerID'] = $this->partnerID;
		//$arr['h_partner'] = $this->partner;
		$arr['h_directions'] = $this->directions;
		$arr['h_notes'] = $this->notes;
	}
	
	
	//returns the contents of the form
	function getForm(){
		return $this->form;
	}
	
	//returns the current values of all form fields
	function getValues(){
		$text = 'Host ID: '.$this->hostID.'<br/>'.
			 'First Name: '.$this->firstName.'<br/>'.
			 'Last Name: '.$this->lastName.'<br/>'.
			 'First Name 2: '.$this->firstName2.'<br/>'.
			 'Last Name 2: '.$this->lastName2.'<br/>'.
			 'Street Address: '.$this->streetAddr.'<br/>'.
			 'Town: '.$this->town.'<br/>'.
			 'Zip: '.$this->zip.'<br/>'.
			 'Region: '.$this->region.'<br/>'.
			 'Home Phone: '.$this->homePhone.'<br/>'.
			 'Work Phone'.$this->workPhone.'<br/>'.
			 'Cell Phone'.$this->cellPhone.'<br/>'.
			 'Email: '.$this->email.'<br/>'.
			 'Alternate Email: '.$this->altEmail.'<br/>'.
			 'Is Active: '.$this->isActive.'<br/>'.
			 //'Has Children: '.$this->hasChildren.'<br/>'.
			 'Has Cats: '.$this->hasCats.'<br/>'.
			 'Has Dogs: '.$this->hasDogs.'<br/>'.
			 'Smoking House: '.$this->smokingHouse.'<br/>'.
			 'Smoking Allowed: '.$this->smokingAllowed.'<br/>'.
			 'Unmarried Couples Allowed: '.$this->singlesAllowed.'<br/>'.
			 'Number of Guests Allowed: '.$this->max.'<br/>'.
			 'Number of Rooms: '.$this->rooms.'<br/>'.
			 'Number of Single Beds: '.$this->singleBeds.'<br/>'.
			 'Number of Double Beds: '.$this->doubleBeds.'<br/>'.
			 'Start Date(not implemented yet): '.$this->startDate.'<br/>'.
			 'Prefers Men: '.$this->prefMen.'<br/>'.
			 'Prefers Women: '.$this->prefWomen.'<br/>'.
			 //'Partner ID: '.$this->partnerID.'<br/>'.
			 //'Partner: '.$this->partner.'<br/>'.
			 'Directions: '.$this->directions.'<br/>'.
			 'Notes: '.$this->notes.'<br/>';
		return $text;
	}
	
	//returns whether the form is submitted or not
	function submitted(){
		if(isset($this->globalArr['submit'])){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	function getID(){
		return $this->globalArr['hostid'];
	}
	
	function delete(){
		return isset($this->globalArr['delete']);
	}
	
	function deleteCheck(){
		if ($this->globalArr['deleteme'] == 1){
			return 1;
		}
		else{ return 0;}
	}
	
	//validates form elements, adds entry to errorList for each error & sets error status
	//if error free copies input from global array to local fields
	function validate(){
		if(!$this->validateGeneric('firstname')){
			$this->errorList[] = 'First name is blank!';
			$this->errorStatus = 1;
		}
		else{
			$this->firstName = $this->globalArr['firstname'];
		}
		if(!$this->validateGeneric('lastname')){
			$this->errorList[] = 'Last name is blank!';
			$this->errorStatus = 1;
		}
		else{
			$this->lastName = $this->globalArr['lastname'];
		}
		$this->firstName2 = $this->globalArr['firstname2'];
		$this->lastName2 = $this->globalArr['lastname2'];
		//echo '<p>Last Name 2: '.$this->globalArr['lastname2'].'</p>';
		//echo '<p>Last Name 2: '.$this->lastName2.'</p>';
		if($this->firstName2 != '' && $this->lastName2 == ''){
			$this->lastName2 = $this->lastName;
		}
		//echo '<p>Last Name 2: '.$this->lastName2.'</p>';
		if(!$this->validateGeneric('streetaddr')){
			$this->errorList[] = 'Street address is blank!';
			$this->errorStatus = 1;
		}
		else{
			$this->streetAddr = $this->globalArr['streetaddr'];
		}
		if(!$this->validateGeneric('town')){
			$this->errorList[] = 'Town is blank!';
			$this->errorStatus = 1;
		}
		else{
			$this->town = $this->globalArr['town'];
		}
		if(!$this->validateGeneric('zip')){
			$this->errorList[] = 'Zip code is blank!';
			$this->errorStatus = 1;
		}
		else{
			$this->zip = $this->globalArr['zip'];
		}
		if(!$this->validateGeneric('region')){
			$this->errorList[] = 'You did not select a region!';
			$this->errorStatus = 1;
		}
		else{
			$this->region = $this->globalArr['region'];
		}
		if($this->getNumeric('max') == -1){
			$this->errorList[] = 'Number of guests must be a non-negative integer!';
			$this->errorStatus = 1;
		}
		else{$this->max = $this->getNumeric('max');}
		if($this->getNumeric('rooms') == -1){
			$this->errorList[] = 'Number of rooms must be a non-negative integer!';
			$this->errorStatus = 1;
		}
		else{$this->rooms = $this->getNumeric('rooms');}
		if($this->getNumeric('singlebeds') == -1){
			$this->errorList[] = 'Number of single beds must be a non-negative integer!';
			$this->errorStatus = 1;
		}
		else{$this->singleBeds = $this->getNumeric('singlebeds');}
		if($this->getNumeric('doublebeds') == -1){
			$this->errorList[] = 'Number of double beds must be a non-negative integer!';
			$this->errorStatus = 1;
		}
		else{$this->doubleBeds = $this->getNumeric('doublebeds');}
		if($this->globalArr['day'] == 'Day'){
			$this->day = '1';
		}
		else{$this->day = $this->globalArr['day'];}
		if($this->globalArr['month'] == 'Month'){
			$this->month = '1';
		}
		else{$this->month = $this->globalArr['month'];}
		if($this->globalArr['year'] == 'Year'){
			$this->year = '2011';
		}
		else{$this->year = $this->globalArr['year'];}
		$this->setDate();
		//check that each phone number is valid if entered
		if($this->globalArr['homephone'] != ''){
			if(!$this->validatePhone('homephone')){
				$this->errorList[] = 'The home phone mumber must be a valid 10 digit number';
				$this->errorStatus = 1;
			}
			else{$this->homePhone = $this->globalArr['homephone'];}
		}
		if($this->globalArr['workphone'] != ''){
			if(!$this->validatePhone('workphone')){
				$this->errorList[] = 'The work phone mumber must be a valid 10 digit number';
				$this->errorStatus = 1;
			}
			else{$this->workPhone = $this->globalArr['workphone'];}
		}
		if($this->globalArr['cellphone'] != ''){
			if(!$this->validatePhone('cellphone')){
				$this->errorList[] = 'The cell phone mumber must be a valid 10 digit number';
				$this->errorStatus = 1;
			}
			else{$this->cellPhone = $this->globalArr['cellphone'];}
		}
		$this->primaryPhone = $this->globalArr['primaryphone'];
		$this->getPhone();
		/*$this->homePhone = $this->globalArr['homephone'];
		$this->workPhone = $this->globalArr['workphone'];
		$this->cellPhone = $this->globalArr['cellphone'];*/
		//copy values from checkboxes and notes
		$this->email = $this->globalArr['email'];
		$this->altEmail = $this->globalArr['altemail'];
		$this->isActive = (int)$this->globalArr['isactive'];
		//$this->hasChildren = (int)$this->globalArr['haschildren'];
		$this->hasCats = (int)$this->globalArr['hascats'];
		$this->hasDogs = (int)$this->globalArr['hasdogs'];
		$this->smokingHouse = (int)$this->globalArr['smokinghouse'];
		$this->smokingAllowed = (int)$this->globalArr['smokersallowed'];
		$this->singlesAllowed = (int)$this->globalArr['singlesallowed'];
		$this->prefMen = (int)$this->globalArr['prefmen'];
		$this->prefWomen = (int)$this->globalArr['prefwomen'];
		$this->directions = $this->globalArr['directions'];
		$this->notes = $this->globalArr['notes'];
		$this->hostID = $this->globalArr['hostid'];
		//$this->partnerID = $this->globalArr['partnerid'];
		$this->clean();
		//echo '<p>'.$this->rooms.'</p>';
	}
	
	//sanitizes all text based input
	function clean(){
		$this->firstName = $this->sanitize('firstname');
		$this->lastName = $this->sanitize('lastname');
		$this->streetAddr = $this->sanitize('streetaddr');
		$this->town = $this->sanitize('town');
		$this->zip = $this->sanitize('zip');
		//$this->partner = $this->sanitize('partner');
		//echo '<p>Partner: '.$this->partner.'</p>';
		$this->notes = $this->sanitize('notes');
	}
		
	
	
	function make(){
		$this->setTown();
		$this->setPhone();
		$status = $this->errorStatus;
		$this->parseDate();
		//$day = $this->setDay();
		//$month = $this->setMonth();
		//$year = $this->setYear();
		//$monthList = $this->monthLabel();
		$this->form = '<form action="'.$_SERVER['PHP_SELF'].'" method="post" id="hostform">' ."\n".
			'<p>Host Information</p>' ."\n".
			'<fieldset id="contact"><legend>Contact Information</legend>'."\n".
			'<fieldset class="left">'.
			$this->makeLabel('firstname','First Name: ')."\n".$this->makeText('firstname',$this->stripChars($this->firstName),$status).'<span class="red">*</span>'.'<br/>' ."\n".
			$this->makeLabel('lastname','Last Name: ')."\n".$this->makeText('lastname',$this->stripChars($this->lastName),$status).'<span class="red">*</span>'.'<br/>' ."\n".
			$this->makeLabel('firstname2','First Name 2: ')."\n".$this->makeText('firstname2',$this->stripChars($this->firstName2),$status).'<br/>'."\n".
			$this->makeLabel('lastname2','Last Name 2: ')."\n".$this->makeText('lastname2',$this->stripChars($this->lastName2),$status).'<br/>'.
			$this->makeLabel('streetaddr','Street Address: ')."\n".$this->makeText('streetaddr',$this->stripChars($this->streetAddr),$status).'<span class="red">*</span>'.'<br/>' .
			$this->makeLabel('town','Town')."\n".$this->makeText('town',$this->stripChars($this->town),$status).'<span class="red">*</span>'.'<br/>' .
			$this->makeLabel('zip','Zip Code')."\n".$this->makeText('zip',$this->stripChars($this->zip),$status).'<span class="red">*</span>'.'<br/>' .'</fieldset>'.
			'<fieldset class="right">'.
			$this->makeLabel('email','Email: ')."\n".$this->makeText('email',$this->email,$status).'<span class="red">*</span>'.'<br/>' ."\n".
			$this->makeLabel('altemail','Alternate Email: ')."\n".$this->makeText('altemail',$this->altEmail,$status).'<br/>'.
			$this->makeLabel('homephone','Home Phone: ')."\n".$this->makeText('homephone',$this->homePhone,$status).'<br/>' .
			$this->makeLabel('workphone','Work Phone: ')."\n".$this->makeText('workphone',$this->workPhone,$status).'<br/>' .
			$this->makeLabel('cellphone','Cell Phone: ')."\n".$this->makeText('cellphone',$this->cellPhone,$status).'<br/>' .
			'Primary Phone: '."\n".'<br/>'."\n".
			$this->makeRadio('primaryphone','Home',$this->home).' Home <br/>'."\n".
			$this->makeRadio('primaryphone','Work',$this->work).' Work <br/>'."\n".
			$this->makeRadio('primaryphone','Cell',$this->cell).' Cell <br/>'."\n".'</fieldset></fieldset><br/>' ."\n".
			'<p>Additional Information</p>' ."\n".
			'<fieldset id="region"><legend>Region<span class="red">*</span></legend>' ."\n".
			'Burlington '."\n".$this->makeRadio('region','Burlington',$this->burl).'<br/>'."\n".
			'Newport/Derby '."\n".$this->makeRadio('region','Derby',$this->derby).'<br/>' ."\n".
			'Randolph '."\n".$this->makeRadio('region','Randolph',$this->randolph).'<br/>' ."\n".
			'Montpelier/Barre '."\n".$this->makeRadio('region','Barre',$this->barre).'<br/>' ."\n".
			'Quechee/Woodstock '."\n".$this->makeRadio('region','Qechee',$this->quechee).'<br/>' ."\n".
			'Bellows Falls '."\n".$this->makeRadio('region','Bellows Falls',$this->bf).'<br/>' ."\n".
			'Ludlow '."\n".$this->makeRadio('region','Ludlow',$this->ludlow).'<br/>'."\n".
			'</fieldset>'."\n".'<fieldset id="rooms"><legend>Accommodations</legend>'."\n".
			$this->makeLabel('max','Number of Guests Allowed: ')."\n".$this->makeText('max',$this->max,$status).'<span class="red">*</span>'.'<br/>' ."\n".			
			$this->makeLabel('rooms','Number of Rooms: ')."\n".$this->makeText('rooms',$this->rooms,$status).'<span class="red">*</span>'.'<br/>' ."\n".
			$this->makeLabel('singlebeds','Number of Single Beds: ')."\n".$this->makeText('singlebeds',$this->singleBeds,$status).'<span class="red">*</span>'.'<br/>' ."\n".
			$this->makeLabel('doublebeds','Number of Double Beds: ')."\n".$this->makeText('doublebeds',$this->doubleBeds,$status).'<span class="red">*</span>'.'<br/>'."\n".'</fieldset>' ."\n".
			'<fieldset id="miscoptions"><legend>Misc</legend>' ."\n".
			$this->makeLabel('isactive','Is Active: ')."\n".$this->makeCheck('isactive','1',$this->isActive).'<br/>' ."\n".
			$this->makeLabel('hascats','Has Cats: ')."\n".$this->makeCheck('hascats','1',$this->hasCats).'<br/>' ."\n".
			$this->makeLabel('hasdogs','Has Dogs: ')."\n".$this->makeCheck('hasdogs','1',$this->hasDogs).'<br/>' ."\n".
			//'Has Children: '.$this->makeCheck('haschildren','1',$this->hasChildren).'<br/>' .
			$this->makeLabel('smokinghouse','Smoking House: ')."\n".$this->makeCheck('smokinghouse','1',$this->smokingHouse).'<br/>' ."\n".
			$this->makeLabel('smokersallowed','Smokers Allowed: ')."\n".$this->makeCheck('smokersallowed','1',$this->smokingAllowed).'<br/>' ."\n".
			$this->makeLabel('singlesallowed','Unmarried Couples Allowed: ')."\n".$this->makeCheck('singlesallowed','1',$this->singlesAllowed).'<br/>' ."\n".
			$this->makeLabel('prefmen','Prefers Men: ')."\n".$this->makeCheck('prefmen','1',$this->prefMen).'<br/>' ."\n".
			$this->makeLabel('prefwomen','Prefers Women: ')."\n".$this->makeCheck('prefwomen','1',$this->prefWomen).'<br/>' ."\n".
			'Start Date: '.$this->makeListS('month',$this->monthList,$this->month).' '.$this->makeListS('day',$this->dayList,$this->day).' '.$this->makeListS('year',$this->yearList,$this->year)."\n".'<br/>'."\n".
			//'Partner: '.$this->makeText('partner',$this->partner,$status).'<br/>'.
			$this->makeLabel('directions','Directions')."\n".'<br/>'.$this->makeTextArea('directions',$this->stripChars($this->directions),5,50)."\n".'<br/>' ."\n".
			$this->makeLabel('notes','Notes').'<br/>'."\n".$this->makeTextArea('notes',$this->stripChars($this->notes),5,50).'</fieldset>'."\n".'<br/>' ."\n".
			'<br/>'."\n".
			'<fieldset>'."\n".
			$this->makeHidden('hostid',$this->hostID)."\n".
			$this->makeSubmit('submit','Submit/Update')."\n".
			'</fieldset>'."\n";
			if($this->mode == 'update'){
				$this->form .= '<fieldset>'."\n".
					$this->makeSubmit('delete','Delete')."\n".
					'Are you sure?  '."\n".
					$this->makeCheck('deleteme','1',0)."\n".
					'Yes, I\'m sure'."\n".
					'</fieldset>'."\n";
			}
			$this->form .= '</form>'."\n";
	}
	
	function makeErrList(){
		$list = '<ul id="errorlist">';
		foreach ($this->errorList as $element){
			$list .= '<li>'.$element.'</li>';
		}
		$list .= '</ul>';
		return $list;
	}
	
	//display the form in its current state
	function display(){
		echo $this->form;
	}
	
	//set all of the values from an array, opposite of getValues
	function setValues($arr){
		$this->firstName = $arr['h_firstName'];
		$this->lastName = $arr['h_lastName'];
		$this->firstName2 = $arr['h_firstName2'];
		$this->lastName2 = $arr['h_lastName2'];
		$this->streetAddr = $arr['h_streetAddr'];
		$this->town = $arr['h_town'];
		$this->zip = $arr['h_zip'];
		$this->region = $arr['h_region'];
		$this->homePhone = $arr['h_homePhone'];
		$this->workPhone = $arr['h_workPhone'];
		$this->cellPhone = $arr['h_cellPhone'];
		$this->phone = $arr['h_phone'];
		$this->primaryPhone = $arr['h_primaryPhone'];
		$this->email = $arr['h_email'];
		$this->altEmail = $arr['h_altEmail']; 
		$this->isActive = $arr['h_isActive']; 
		//$this->hasChildren = $arr['h_hasChildren'];
		$this->hasCats = $arr['h_hasCats'];
		$this->hasDogs = $arr['h_hasDogs'];
		$this->smokingHouse = $arr['h_smokingHouse'];
		$this->smokingAllowed = $arr['h_smokingAllowed'];
		$this->singlesAllowed = $arr['h_singlesAllowed'];
		$this->max = $arr['h_max'];
		$this->rooms = $arr['h_rooms'];
		$this->singleBeds = $arr['h_singleBeds'];
		$this->doubleBeds = $arr['h_doubleBeds'];
		$this->startDate = $arr['h_startDate'];
		$this->prefMen = $arr['h_prefMen'];
		$this->prefWomen = $arr['h_prefWomen'];
		//$this->partnerID = $arr['h_partnerID'];
		//$this->partner = $arr['h_partner'];
		$this->directions = $arr['h_directions'];
		$this->notes = $arr['h_notes'];
	}
	
	//sets radio buttons
	function setTown(){
		$this->burl = 0;
		$this->derby = 0;
		$this->barre = 0;   //reset them to 0 just in case
		$this->randolph = 0;
		$this->bf = 0;
		$this->quechee = 0;
		$this->ludlow = 0;
		switch($this->region){
			case 'Burlington':
				$this->burl = 1;
				break;
			case 'Derby':
				$this->derby = 1;
				break;
			case 'Randolph':
				$this->randolph = 1;
				break;
			case 'Barre':
				$this->barre = 1;
				break;
			case 'Quechee':
				$this->quechee = 1;
				break;
			case 'Bellows Falls':
				$this->bf = 1;
				break;
			case 'Ludlow':
				$this->ludlow = 1;
				break;
		}
	}
	
	function getPhone(){
		switch($this->primaryPhone){
			case 'Home':
				$this->phone = $this->homePhone;
				break;
			case 'Work':
				$this->phone = $this->workPhone;
				break;
			case 'Cell':
				$this->phone = $this->cellPhone;
				break;
		}
	}
		
	
	
	function setPhone(){
		$this->home = 0;
		$this->work = 0;
		$this->cell = 0;
		switch($this->primaryPhone){
			case 'Home':
				$this->home = 1;
				break;
			case 'Work':
				$this->work = 1;
				break;
			case 'Cell':
				$this->cell = 1;
				break;
			default:
				$this->home = 1;
			break;
		}
	}

	
	function parseDate(){
		$parse = explode('-',$this->startDate);
		$this->year = $parse[0];
		$this->month = $parse[1];
		$this->day = $parse[2];
		//echo '<p>Day: '.$this->day.' Month: '.$this->month.' Year: '.$this->year.'</p>';
	}
	
	function setDate(){
		$this->startDate = $this->year.'-'.$this->month.'-'.$this->day;
	}
	
	
	
				
			
			
			
	
	
	
}


	



?>