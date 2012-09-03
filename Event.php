<?php
//Supporting class for all operations related to the Event table
class Event{

	var $type = 'Event';
	
	//fields	
	var $eventID;
	var $title;
	var $date;
	var $arrivalDate;
	var $description;
	var $streetAddr;
	var $town;
	var $zip;
	var $notes;
	
	
	function add(){
		$query = "INSERT INTO tblEvent 
				(fldTitle,fldDate,fldArrivalDate,
				fldDescription,fldStreetAddr,fldTown,
				fldZip,fldNotes) VALUES ($title,$date,
				$arrivalDate,$description,$streetAddr,
				$town,$zip,$notes)";
		return $query;
	}
	
	function display(){
		echo 'EventID: '.$this->eventID.'<br/>';
		echo 'Title: '.$this->title.'<br/>';
		echo 'Date: '.$this->date.'<br/>';
		echo 'ArrivalDate: '.$this->arrivalDate.'<br/>';
		echo 'Description: '.$this->description.'<br/>';
		echo 'StreetAddr: '.$this->streetAddr.'<br/>';
		echo 'Town: '.$this->town.'<br/>';
		echo 'Zip: '.$this->zip.'<br/>';
		echo 'Notes: '.$this->notes.'<br/>';
	}
	
}

?>