<?php

class EventForm extends Form{

	var $type = 'Event';
	var $errorList = array();
	var $form;
	var $errorStatus;
		
	//fields	
	var $eventID;
	var $title;
	var $choral;
	var $miv;
	var $masterworks;
	var $pops;
	var $sf;
	var $other;
	var $region;
	var $burl;
	var $derby;
	var $barre;
	var $randolph;
	var $bf;
	var $quechee;
	var $ludlow;
	var $date;
	var $day;
	var $month;
	var $year;
	var $arrivalDate;
	var $aDay;
	var $aMonth;
	var $aYear;
	var $description;
	var $streetAddr = '742 Evergreen Terrace';
	var $town = 'Springfield';
	var $zip = '?????';
	var $status;
	var $notes;	
	
	
	function EventForm(){
		parent::Form('post');
		$this->statusList['Planning'] = 'Planning';
		$this->statusList['Planned'] = 'Planned';
	}
	
	function getForm(){
		return $this->form;
	}
	
	function getValues(){
		$text = 'Event ID: '.$this->eventID.'<br/>'.
			'Type: '.$this->title.'<br/>'.
			'Region: '.$this->region.'<br/>'.
			'Date: '.$this->date.'<br/>'.
			'Arrival Date: '.$this->arrivalDate.'<br/>'.
			'Description: '.$this->description.'<br/>'.
			//'Street Address: '.$this->streetAddr.'<br/>'.
			//'Town: '.$this->town.'<br/>'.
			//'Zip: '.$this->zip.'<br/>'.
			'Status: '.$this->status.'<br/>'.
			'Notes: '.$this->notes.'<br/>';
		return $text;
	}
	
	//returns the value of the hidden field
	function getID(){
		return $this->globalArr['eventid'];
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
		if(!$this->validateGeneric('title')){
			$this->errorList[] = 'You must select an event type';
			$this->errorStatus = 1;
		}
		else{
			if($this->globalArr['title'] == 'Other'){//other was picked, so validate textbox
				if(!$this->validateGeneric('other')){
					$this->errorList[] = 'You did not specify a title for this event';
					$this->errorStatus = 1;
				}
				else{
					//echo '<p>Title: '.$this->globalArr['other'].'</p>';
					//$this->title = $this->globalArr['other'];
					//echo '<p>Title: '.$this->title.'</p>';
					$this->title = $this->sanitize('other');
					//echo '<p>Title: '.$this->title.'</p>';
				}
			}
			else{//not other and not blank, just read it in
				$this->title = $this->sanitize('title');
			}
		}
		
		if(!$this->validateGeneric('region')){
			$this->errorList[] = 'You did not select a region!';
			$this->errorStatus = 1;
		}
		else{
			$this->region = $this->globalArr['region'];
		}
			//$this->title = $this->globalArr['title'];
				
		$this->day = $this->globalArr['day'];
		$this->month = $this->globalArr['month'];
		$this->year = $this->globalArr['year'];	
		$this->aDay = $this->globalArr['aday'];
		$this->aMonth = $this->globalArr['amonth'];
		$this->aYear = $this->globalArr['ayear'];
		$this->description = $this->globalArr['description'];
		$this->streetAddr = $this->globalArr['streetaddr'];
		$this->town = $this->globalArr['town'];
		$this->zip = $this->globalArr['zip'];
		$this->status = $this->globalArr['status'];
		$this->notes = $this->globalArr['notes'];
		$this->eventID = $this->globalArr['eventid'];
		$this->setDate();
		$this->clean();
	}
	
	function clean(){
		//$this->title = $this->sanitize('title');
		$this->description = $this->sanitize('description');
		//$this->streetAddr = $this->sanitize('streetaddr');
		//$this->town = $this->sanitize('town');
		//$this->zip = $this->sanitize('zip');
		$this->notes = $this->sanitize('notes');
	}
	
	function makeForm(){
		$status = $this->errorStatus;
		$this->setType();
		$this->setTown();
		$this->parseDate();
		//$statelist = $this->setState();
		$text = '<form action="'.$_SERVER['PHP_SELF'].'" method="post" id="eventform">' ."\n".
				'<p>Event Information</p>'."\n".
				'<fieldset id="contact">'."\n".
				'<legend>Event Type<span class="red">*</span></legend>'."\n".
				'Choral '.$this->makeRadio('title','Choral',$this->choral)."\n".
				'<br/>'."\n".
				'Made in Vermont '.$this->makeRadio('title','Made In Vermont',$this->miv)."\n".
				'<br/>'."\n".
				'Master Works '.$this->makeRadio('title','Master Works',$this->masterworks)."\n".
				'<br/>'."\n".
				'Pops '.$this->makeRadio('title','Pops',$this->pops)."\n".
				'<br/>'."\n".
				'Summer Festival '.$this->makeRadio('title','Summer Festival',$this->sf)."\n".
				'<br/>'."\n".
				'Other '.$this->makeRadio('title','Other',$this->other).' '.$this->makeText('other',$this->stripChars($this->title),$status)."\n".
				'<br/>'."\n".
				'</fieldset>'."\n".
				'<fieldset id="region">'."\n".
				'<legend>Region<span class="red">*</span></legend>'."\n".
				'Burlington '.$this->makeRadio('region','Burlington',$this->burl)."\n".
				'<br/>'."\n".
				'Newport/Derby '.$this->makeRadio('region','Derby',$this->derby)."\n".
				'<br/>'."\n".
				'Randolph '.$this->makeRadio('region','Randolph',$this->randolph)."\n".
				'<br/>'."\n".
				'Montpelier/Barre '.$this->makeRadio('region','Barre',$this->barre)."\n".
				'<br/>'."\n".
				'Quechee/Woodstock '.$this->makeRadio('region','Qechee',$this->quechee)."\n".
				'<br/>'."\n".
				'Bellows Falls '.$this->makeRadio('region','Bellows Falls',$this->bf)."\n".
				'<br/>'."\n".
				'Ludlow '.$this->makeRadio('region','Ludlow',$this->ludlow)."\n".
				'<br/>'."\n".
				'</fieldset>'."\n".
				'<fieldset>'."\n".
				'<legend>Additional Info</legend>'."\n".
				'Concert Date: '.$this->makeListS('month',$this->monthList,$this->month).' '.$this->makeListS('day',$this->dayList,$this->day).' '.$this->makeListS('year',$this->yearList,$this->year)."\n".
				'<br/>'."\n".
				'Arrival Date: '.$this->makeListS('amonth',$this->monthList,$this->aMonth).$this->makeListS('aday',$this->dayList,$this->aDay).' '.$this->makeListS('ayear',$this->yearList,$this->aYear)."\n".
				'<br/>'."\n".
				//'Street Address: '.$this->makeText('streetaddr',$this->streetAddr,$status).'<br/>' .
				//'Town: '.$this->makeText('town',$this->town,$status).'<br/>' .
				//'Zip Code: '.$this->makeText('zip',$this->zip,$status).'<br/>' .
				'Description'."\n". 
				'<br/>'."\n".
				$this->makeTextArea('description',$this->stripChars($this->description),5,50)."\n".
				'<br/>'."\n".
				'Status: '.$this->makeListS('status',$this->statusList,$this->status)."\n".
				'<br/>'."\n".
				'Notes'."\n". 
				'<br/>'."\n".
				$this->makeTextArea('notes',$this->stripChars($this->notes),5,50)."\n".
				'</fieldset>'."\n".
				'<br/>'."\n".
				'<fieldset>'."\n".
				$this->makeHidden('eventid',$this->eventID)."\n".
				$this->makeSubmit('submit','Submit/Update')."\n".
				'</fieldset>'."\n";
				if($this->mode == 'update'){
					$text .= '<fieldset>'."\n".
						//'<input type="submit" name="delete" value="Delete" onclick="return confirm(\'Are you sure you want to delete this?\');"/>'."\n".
						$this->makeSubmit('delete','Delete')."\n".
						'Are you sure?  '."\n".
						$this->makeCheck('deleteme','1',0)."\n".
						'Yes, I\'m sure'."\n".
						'</fieldset>'."\n";
				}
				$text .= '</form>'."\n";
		return $text;
	}
				
				
	function makeErrList(){
		$list = '<ul id="errorlist">';
		foreach ($this->errorList as $element){
			$list .= '<li>'.$element.'</li>';
		}
		$list .= '</ul>';
		return $list;
	}
	
	function parseDate(){
		$parse = explode('-',$this->date);
		$this->year = $parse[0];
		$this->month = $parse[1];
		$this->day = $parse[2];
		$parse = explode('-',$this->arrivalDate);
		$this->aYear = $parse[0];
		$this->aMonth = $parse[1];
		$this->aDay = $parse[2];
	}
	
	function setDate(){
		$this->date = $this->year.'-'.$this->month.'-'.$this->day;
		$this->arrivalDate = $this->aYear.'-'.$this->aMonth.'-'.$this->aDay;
	}
	
	function setType(){
		$this->choral = 0;
		$this->miv = 0;
		$this->masterworks = 0;   //reset them to 0 just in case
		$this->pops = 0;
		$this->sf = 0;
		switch($this->title){
			case 'Choral':
				$this->choral = 1;
				unset($this->title);
				break;
			case 'Made In Vermont':
				$this->miv = 1;
				unset($this->title);
				break;
			case 'Master Works':
				$this->masterworks = 1;
				unset($this->title);
				break;
			case 'Pops':
				$this->pops = 1;
				unset($this->title);
				break;
			case 'Summer Festival':
				$this->sf = 1;
				unset($this->title);
				break;
			default:
				$this->other = 1;
				break;
		}
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
}


?>