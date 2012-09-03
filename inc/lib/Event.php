<?php
//Supporting class for all operations related to the Event table
class Event{

	var $type = 'Event';
	
	//fields	
	var $eventID;
	var $title;
	var $region;
	var $date;
	var $arrivalDate;
	var $description;
	var $streetAddr = '742 Evergreen Terrace';
	var $town = 'Springfield';
	var $zip = '?????';
	var $status;
	var $notes;
	
	
	
	function fields(){
		$query = 'fldTitle="'.$this->title.'", '.
				'fldRegion="'.$this->region.'", '.
				'fldDate="'.$this->date.'", '.
				'fldArrivalDate="'.$this->arrivalDate.'", '.
				'fldDescription="'.$this->description.'", '.
				'fldStreetAddr="'.$this->streetAddr.'", '.
				'fldTown="'.$this->town.'", '.
				'fldZip="'.$this->zip.'", '.
				'fldStatus="'.$this->status.'", '.
				'fldNotes="'.$this->notes.'"';
		return $query;
	}
	
	function selectID($id){
		$query = 'SELECT * FROM tblEvent WHERE pkEventID='.$id;
		return $query;
	}
	
	//order by date descending
	function selectTitles(){
		$query = 'SELECT pkEventID, fldTitle, fldDate FROM tblEvent ORDER BY fldDate DESC';
		return $query;
	}
	
	function add(){
		$query = 'INSERT INTO tblEvent SET '.$this->fields();
		return $query;
	}
	
	function update(){
		$query = 'UPDATE tblEvent SET '.$this->fields().' WHERE pkEventID='.$this->eventID;
		return $query;
	}
	
	function delete($id){
		$query = 'DELETE FROM tblEvent WHERE pkEventID='.$id;
		return $query;
	}
	
	function getReport($id){
		$q = 'SELECT fldReport FROM tblEvent WHERE pkEventID='.$id;
		return $q;
	}
	
	function setReport($id,$report){
		$q = 'UPDATE tblEvent SET fldReport="'.$report.'" WHERE pkEventID='.$id;
		return $q;
	}
	
	function report($r){
		$result = mysql_fetch_array($r);
		$text = $result[0];
		return $text;
	}
	
	function getTitles($r){
		$list = array();
		$list['Select'] = -1;
		$data = mysql_fetch_assoc($r);
		while($data){
			$date = explode('-',$data['fldDate']);
			$list[$data['fldTitle'].' '.$date[1].'/'.$date[2].'/'.$date[0]] = $data['pkEventID'];
			$data = mysql_fetch_assoc($r);
		}
		return $list;
	}
	
	function buildList($r){
		$list = '<ul id="recordlist">';
		$data = mysql_fetch_assoc($r);
		while($data){
			$date = explode('-',$data['fldDate']);
			$list .= '<li class="record"><a href="'.$_SERVER['PHP_SELF'].'?id='.$data['pkEventID'].'">'.
			$data['fldTitle'].' '.$date[1].'/'.$date[2].'/'.$date[0].'</a></li>';
			$data = mysql_fetch_assoc($r);
		}
		$list .= '</ul>';
		return $list;
	}
	
	function buildEdit(){
		$text = '<p><a href="'.$_SERVER['PHP_SELF'].'?action=update&id='.$this->eventID.'">Edit Event</a></p>';
		return $text;
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
			'Status: '.$this->status.'<br/>';
			'Notes: '.$this->notes.'<br/>';
		return $text;
	}
	
	function setValues($r){
		$arr = mysql_fetch_assoc($r);
		$this->eventID = $arr['pkEventID'];
		$this->title = $arr['fldTitle'];
		$this->region = $arr['fldRegion'];
		$this->date = $arr['fldDate'];
		$this->arrivalDate = $arr['fldArrivalDate'];
		$this->description = $arr['fldDescription'];
		//$this->streetAddr = $arr['fldStreetAddr'];
		//$this->town = $arr['fldTown'];
		//$this->zip = $arr['fldZip'];
		$this->status = $arr['fldStatus'];
		$this->notes = $arr['fldNotes'];
	}
	
	function display(){
		echo 'EventID: '.$eventID.'<br/>';
		echo 'Type: '.$title.'<br/>';
		echo 'Region: '.$this->region.'<br/>';
		echo 'Date: '.$date.'<br/>';
		echo 'ArrivalDate: '.$arrivalDate.'<br/>';
		echo 'Description: '.$description.'<br/>';
		//echo 'StreetAddr: '.$streetAddr.'<br/>';
		//echo 'Town: '.$town.'<br/>';
		//echo 'Zip: '.$zip.'<br/>';
		echo 'Notes: '.$notes.'<br/>';
	}
	
}

?>