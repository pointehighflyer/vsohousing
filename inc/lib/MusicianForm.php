<?php


class MusicianForm extends Form {//implements FormInterface{

	
	var $type = 'Musician';
	var $form; //contents of the form
	var $errorList = array();
	var $hostList = array();
	
	//fields
	var $musicianID;
	var $firstName;
	var $lastName;
	var $instrument;
	var $town;
	var $state;
	var $smokes;
	var $smokingAllowed;
	var $allergy = 'None';
	var $allrgCats;
	var $allrgDogs;
	var $allrgSmoke;
	var $likeBikePath = 0;
	var $likeDowntown = 0;
	var $carpools = 0;
	var $primaryHost;
	var $notes;
	
	
	function MusicianForm(){
		//echo 'called muscform constructor<br/>';
		parent::Form('post');
	}
	
	function getForm(){
		return $this->form;
	}
	
	function getValues(){
		$text = 'Musician ID: '.$this->musicianID.'<br/>'.
			 'First Name: '.$this->firstName.'<br/>'.
			 'Last Name: '.$this->lastName.'<br/>'.
			 'Town: '.$this->town.'<br/>'.
			 'State/Province: '.$this->state.'<br/>'.
			 'Instrument: '.$this->instrument.'<br/>'.
			 'Smokes: '.$this->smokes.'<br/>'.
			 'Prefers Non-smoking House: '.$this->smokingAllowed.'<br/>'.
			 //'Allergy: '.$this->allergy.'<br/>'.
			 'Allergic to Cats: '.$this->allrgCatsc.'<br/>'.
			 'Allergic to Dogs: '.$this->allrgDogs.'<br/>'.
			 'Allergic to Smoke: '.$this->allrgSmoke.'<br/>'.
			 //'Likes Bike Path: '.$this->likeBikePath.'<br/>'.
			 //'Likes Downtown: '.$this->likeDowntown.'<br/>'.
			 //'Carpools: '.$this->carpools.'<br/>'.
			 'Primary Host: '.$this->primaryHost.'<br/>'.
			 'Notes: '.$this->notes.'<br/>';
		return $text;
	}
	
	function getID(){
		return $this->globalArr['musicianid'];
	}
	
	function submitted(){
		if(isset($this->globalArr['submit'])){
			return 1;
		}
		else{
			return 0;
		}
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
	
	function validate(){
		//echo '<p>Instrument: '.$_POST['instrument'].' Allergy: '.$_POST['allergy'].'</p>';
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
		if(!$this->validateGeneric('town')){
			$this->errorList[] = 'Town is blank!';
			$this->errorStatus = 1;
		}
		else{
			$this->town = $this->globalArr['town'];
		}
		if(!$this->validateGeneric('state')){
			$this->errorList[] = 'No state selected!';
			$this->errorStatus = 1;
		}
		else{
			$this->state = $this->globalArr['state'];
		}
		if(!$this->validateGeneric('instrument')){
			$this->errorList[] = 'No instrument selected!';
			$this->errorStatus = 1;
		}
		else{
			$this->instrument = $this->globalArr['instrument'];
		}
		//$this->allergy = $this->globalArr['allergy'];
		//echo '<p>Instrument: '.$this->instrument.' Allergy: '.$this->allergy.'</p>';
		//$this->instrument = $this->globalArr['instrument'];
		//echo '<p>Instrument: '.$this->instrument.' Allergy: '.$this->allergy.'</p>';
		$this->allrgCats = (int)$this->globalArr['allrgcats'];
		$this->allrgDogs = (int)$this->globalArr['allrgdogs'];
		$this->allrgSmoke = (int)$this->globalArr['allrgsmoke'];
		$this->smokes = (int)$this->globalArr['smokes'];
		$this->smokingAllowed = (int)$this->globalArr['smokingallowed'];
		//$this->likeBikePath = (int)$this->globalArr['likebikepath'];
		//$this->likeDowntown = (int)$this->globalArr['likedowntown'];
		//$this->carpools = (int)$this->globalArr['carpools'];
		$this->notes = $this->globalArr['notes'];
		$this->primaryHost = $this->globalArr['primaryhost'];
		$this->musicianID = $this->globalArr['musicianid'];
		//echo '<p>Instrument: '.$this->instrument.' Allergy: '.$this->allergy.'</p>';
		$this->clean();
		//echo '<p>Instrument: '.$this->instrument.' Allergy: '.$this->allergy.'</p>';
	}
	
	function clean(){
		$this->firstName = $this->sanitize('firstname');
		$this->lastName = $this->sanitize('lastname');
		$this->town = $this->sanitize('town');
		//echo '<p>Instrument: '.$this->instrument.' Allergy: '.$this->allergy.'</p>';
		$this->instrument = $this->sanitize('instrument');
		//$this->allergy = $this->sanitize('allergy');
		//echo '<p>Instrument: '.$this->instrument.' Allergy: '.$this->allergy.'</p>';
		$this->notes = $this->sanitize('notes');
	}
		
	
	function makeForm(){
		$status = $this->errorStatus;
		$statelist = $this->setState();
		$text = '<form action="'.$_SERVER['PHP_SELF'].'" method="post" id="musicianform">' .
				'<p>Musician Information</p>'.
				'<fieldset id="contact"><legend>Contact Information</legend>'.
				'First Name: '.$this->makeText('firstname',$this->stripChars($this->firstName),$status).'<span class="red">*</span>'.'<br/>' .
				'Last Name: '.$this->makeText('lastname',$this->stripChars($this->lastName),$status).'<span class="red">*</span>'.'<br/>' .
				'Town: '.$this->makeText('town',$this->stripChars($this->town),$status).'<span class="red">*</span>'.'<br/>' .
				'State/Province: '.$this->makeList('state',$statelist).'</fieldset><br/>'.
				'<fieldset id="miscoptions"><legend>Additional Info</legend>'.
				'Instrument: '.$this->makeText('instrument',$this->stripChars($this->instrument),$status).'<span class="red">*</span>'.'<br/>'.
				//'Allergy: '.$this->makeText('allergy',$this->allergy,$status).'<br/>'.
				'Allergic to Cats: '.$this->makeCheck('allrgcats','1',$this->allrgCats).'<br/>'.
				'Allergic to Dogs: '.$this->makeCheck('allrgdogs','1',$this->allrgDogs).'<br/>'.
				'Allergic to Smoke: '.$this->makeCheck('allrgsmoke','1',$this->allrgSmoke).'<br/>'.
				'Smokes: '.$this->makeCheck('smokes','1',$this->smokes).'<br/>'.
				'Prefers Non-smoking House: '.$this->makeCheck('smokingallowed','1',$this->smokingAllowed).'<br/>'.
				//'Likes Bike Path: '.$this->makeCheck('likebikepath','1',$this->likeBikePath).'<br/>'.
				//'Likes Downtown: '.$this->makeCheck('likedowntown','1',$this->likeDowntown).'<br/>'.
				//'Carpools: '.$this->makeCheck('carpools','1',$this->carpools).'<br/>'.
				'Primary Host: '.$this->makeListS('primaryhost',$this->hostList,$this->primaryHost).'<br/>'.
				'Notes <br/>'.$this->makeTextArea('notes',$this->stripChars($this->notes),5,50).'</fieldset><br/>' .
				'<br/>'."\n".
				'<fieldset>'."\n".
				$this->makeHidden('musicianid',$this->musicianID)."\n".
				$this->makeSubmit('submit','Submit/Update')."\n".
				'</fieldset>'."\n";
				if($this->mode == 'update'){
					$text .= '<fieldset>'."\n".
						$this->makeSubmit('delete','Delete')."\n".
						'Are you sure?  '."\n".
						$this->makeCheck('deleteme','1',0)."\n".
						'Yes, I\'m sure'."\n".
						'</fieldset>'."\n";
				}
				$text .= '</form>'."\n";
		return $text;				
	}
	
	function makeFormLite(){
	}
	
	function makeErrList(){
		$list = '<ul id="errorlist">';
		foreach ($this->errorList as $element){
			$list .= '<li>'.$element.'</li>';
		}
		$list .= '</ul>';
		return $list;
	}
	
	
	function setState(){
		$arr = array();
		$arr['Select...'] = 0;
		$arr['Alabama - US'] = 0;
		$arr['Alaska - US'] = 0;
		$arr['Arizona - US'] = 0;
		$arr['Arkansas - US'] = 0;
		$arr['California - US'] = 0;
		$arr['Colorado - US'] = 0;
		$arr['Connecticut - US'] = 0;
		$arr['Delaware - US'] = 0;
		$arr['Florida - US'] = 0;
		$arr['Georgia - US'] = 0;
		$arr['Hawaii - US'] = 0;
		$arr['Idaho - US'] = 0;
		$arr['Illinois - US'] = 0;
		$arr['Indiana - US'] = 0;
		$arr['Iowa - US'] = 0;
		$arr['Kansas - US'] = 0;
		$arr['Kentucky - US'] = 0;
		$arr['Louisiana - US'] = 0;
		$arr['Maine - US'] = 0;
		$arr['Maryland - US'] = 0;
		$arr['Massachusetts - US'] = 0;
		$arr['Michigan - US'] = 0;
		$arr['Minnesota - US'] = 0;
		$arr['Mississippi - US'] = 0;
		$arr['Missouri - US'] = 0;
		$arr['Montana - US'] = 0;
		$arr['Nebraska - US'] = 0;
		$arr['Nevada - US'] = 0;
		$arr['New Hampshire - US'] = 0;
		$arr['New Jersey - US'] = 0;
		$arr['New Mexico - US'] = 0;
		$arr['New York - US'] = 0;
		$arr['North Carolina - US'] = 0;
		$arr['North Dakota - US'] = 0;
		$arr['Ohio - US'] = 0;
		$arr['Oklahoma - US'] = 0;
		$arr['Oregon - US'] = 0;
		$arr['Pennsylvania - US'] = 0;
		$arr['Rhode Island - US'] = 0;
		$arr['South Carolina - US'] = 0;
		$arr['South Dakota - US'] = 0;
		$arr['Tennessee - US'] = 0;
		$arr['Texas - US'] = 0;
		$arr['Utah - US'] = 0;
		$arr['Vermont - US'] = 0;
		$arr['Virginia - US'] = 0;
		$arr['Washington - US'] = 0;
		$arr['West Virginia - US'] = 0;
		$arr['Wisconsin - US'] = 0;
		$arr['Wyoming - US'] = 0;
		$arr['Alberta - Canada'] = 0;
		$arr['British Columbia - Canada'] = 0;
		$arr['Manitoba - Canada'] = 0;
		$arr['New Brunswick - Canada'] = 0;
		$arr['NewFoundland - Canada'] = 0;
		$arr['North West Territories - Canada'] = 0;
		$arr['Nova Scotia - Canada'] = 0;
		$arr['Nunavut - Canada'] = 0;
		$arr['Ontario - Canada'] = 0;
		$arr['Prince Edward Island - Canada'] = 0;
		$arr['Quebec - Canada'] = 0;
		$arr['Saskatchewan - Canada'] = 0;
		$arr['Yukon - Canada'] = 0;
		if(!isset($this->state) || $this->state == ''){
			$arr['Select...'] = 1;
		}
		else{
			$arr[$this->state] = 1;
		}
		return $arr;
	}


}
?>