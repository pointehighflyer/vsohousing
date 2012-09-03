<?php

class MEForm extends Form{
	var $type = 'MEForm';
	var $id; //the event we're working with
	var $data;
	var $musicianList;
	var $hostList;
	var $statusList = array('Tentative' => 'Tentative', 'Confirmed' => 'Confirmed');
	
	
	function MEForm(){
		parent::Form('post');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
			//$_SESSION['id'] = $this->id;
		}
		/*elseif(isset($_SESSION['id'])){
			$this->id = $_SESSION['id'];
		}*/
		else{die('<p>Error: could not get an event ID</p>');}
	}
	
	function isAdd(){
		if(isset($this->globalArr['add'])){
			//echo '<p>Adding</p>';
			return 1;
		}
		else{
			//echo '<p>Not Adding</p>';
			return 0;
		}
	}
	
	function isMatch(){
		if(isset($this->globalArr['match'])){
			//echo '<p>Adding</p>';
			return 1;
		}
		else{
			//echo '<p>Not Adding</p>';
			return 0;
		}
	}
	
	function isUpdate(){
		if(isset($this->globalArr['update'])){
			//echo '<p>Adding</p>';
			return 1;
		}
		else{
			//echo '<p>Not Adding</p>';
			return 0;
		}
	}
	

	function isDelete(){
		if(isset($this->globalArr['deletechecked'])){
			//echo '<p>Adding</p>';
			return 1;
		}
		else{
			//echo '<p>Not Adding</p>';
			return 0;
		}
	}
		
	//get the id of the musician we're adding
	function getMusician(){
		if(isset($this->globalArr['musician'])){
			return $this->globalArr['musician'];
		}
		else{die('<p>Error: Could not get the id of the musician</p>');}
	}
	
	//get all of the updated field info and put into a 2D array
	function getUpdateData(){
		$data = array();
		$count = $this->globalArr['count'];
		for($i=0;$i<$count;$i++){
			if((int)$this->globalArr['select'.$i] == 1){
				$row = array();
				$startDate = $this->globalArr['syear'.$i].'-'.$this->globalArr['smonth'.$i].'-'.$this->globalArr['sday'.$i];
				$endDate = $this->globalArr['eyear'.$i].'-'.$this->globalArr['emonth'.$i].'-'.$this->globalArr['eday'.$i];
				$row['me_musicianID'] = $this->globalArr['musician'.$i];
				$row['me_startDate'] = $startDate;
				$row['me_endDate'] = $endDate;
				$row['me_hostID'] = $this->globalArr['host'.$i];
				$row['me_match'] = 'Manual';
				$row['me_status'] = $this->globalArr['status'.$i];
				$data[] = $row;
			}
		}
		return $data;
	}
	
	//returns an array containing the ids of all checked rows
	function getSelected(){
		//echo '<p>Getting ids to delete</p>'; 
		$data = array();
		$count = $this->globalArr['count'];
		for($i=0;$i<$count;$i++){
			//echo '<p>count: '.$i.', '.$this->globalArr['delete'.$i].'</p>';
			if((int)$this->globalArr['select'.$i] == 1){
				$data[] = $this->globalArr['musician'.$i];
			}
		}
		return $data;
	}
	
	function getMatchData(){
	}

	
	function makeMEForm($data){
		$counter = 0;
		$form = "\n".'<form action="'.$_SERVER['PHP_SELF'].'?id='.$this->id.'" method="post">'."\n".
				'<table border="1">'."\n".
					'<tr>'."\n".
						'<th>Select</th>'."\n".
						'<th>Musician</th>'."\n".
						'<th>Start Date</th>'."\n".
						'<th>End Date</th>'."\n".
						'<th>Host</th>'."\n".
						'<th>Select Host</th>'."\n".
						'<th>Matched By</th>'."\n".
						'<th>Status</th>'."\n".
					'</tr>'."\n";
		
		//generate dynamic fields
		foreach($data as $row){
			if($row['me_hostID'] == -1){
				//echo '<p>fkHostID: '.$row['me_hostID'].'</p>';
				$host = 'Unspecified';
				//echo '<p>Text: '.$host.'</p>';
			}
			else{ 
				$host = $row['h_firstName'].' '.$row['h_lastName'];
			}
			$form .= '<fieldset tabindex="'.($counter+1).'">'."\n".
					'<tr>'."\n".
					'<td>'."\n".
					$this->makeCheck('select'.$counter,'1',0)."\n".
					$this->makeHidden('musician'.$counter,$row['me_musicianID'])."\n".
					'</td>'."\n".
					'<td>'.$row['m_firstName'].' '.$row['m_lastName'].'</td>'."\n".
					'<td>'.$this->makeDateSelect('sday'.$counter,'smonth'.$counter,'syear'.$counter,$row['me_startDate']).'</td>'."\n".
					'<td>'.$this->makeDateSelect('eday'.$counter,'emonth'.$counter,'eyear'.$counter,$row['me_endDate']).'</td>'."\n".
					'<td>'.$host.'</td>'."\n".
					'<td>'.$this->makeListS('host'.$counter,$this->hostList,$row['me_hostID']).'</td>'."\n".
					'<td>'.$row['me_match'].'</td>'."\n".
					'<td>'.$this->makeListS('status'.$counter,$this->statusList,$row['me_status']).'</td>'."\n".
					'</tr>'."\n".
					'</fieldset>'."\n";
					$counter++;
		}
		$form .= '</table>'."\n";
		$form .= '<fieldset>'."\n".
				$this->makeHidden('count',$counter)."\n".
				$this->makeSubmit('match','Match Selected')."\n".
				$this->makeSubmit('update','Update Checked')."\n".
				$this->makeSubmit('deletechecked','Delete Checked')."\n".
				$this->makeSubmit('request','Housing Request')."\n".
				$this->makeSubmit('report','Housing Report')."\n".
				'</fieldset>'."\n";
		$form .= '<fieldset id="addmusician">'."\n".
				'<label for="mlist">Musician: </label>'."\n".
				$this->makeListS('musician',$this->musicianList,-1).
				$this->makeSubmit('add','Add').
				'</fieldset>';
		$form .= '</form>'."\n";
		return $form;
	}
	
	function makeMusicianHst($data){
		$t = '<table border="1">'."\n".
				'<tr>'."\n".
					'<th>Event</th>'."\n".
					'<th>Date</th>'."\n".
					'<th>Host</th>'."\n".
				'</tr>'."\n";
		foreach($data as $row){
			if($row['h_firstName2'] != ''){
				$host = $row['h_firstName'].' '.$row['h_lastName'].' and '.$row['h_firstName2'].' '.$row['h_lastName2'];
			}
			else{
				$host = $row['h_firstName'].' '.$row['h_lastName'];
			}
			$t .= 	'<tr>'."\n".
						'<td>'.$row['e_title'].'</td>'."\n".
						'<td>'.$this->parseDate($row['e_date']).'</td>'."\n".
						'<td>'.$host.'</td>'."\n".
					'</tr>'."\n";
		}
		$t .= '</table>'."\n";
		return $t;			
	}
	
	function makeHostHst($data){
		$t = '<table border="1">'."\n".
				'<tr>'."\n".
					'<th>Event</th>'."\n".
					'<th>Date</th>'."\n".
					'<th>Musician</th>'."\n".
				'</tr>'."\n";
		foreach($data as $row){
			$t .= 	'<tr>'."\n".
						'<td>'.$row['e_title'].'</td>'."\n".
						'<td>'.$this->parseDate($row['e_date']).'</td>'."\n".
						'<td>'.$row['m_firstName'].' '.$row['m_lastName'].'</td>'."\n".
					'</tr>'."\n";
		}
		$t .= '</table>'."\n";
		return $t;
	}
	
	function makeReport($data){
		//count all the host id's
		$hosts = array();
		foreach($data as $row){
			$hosts[] = $row['me_hostID'];
		}
		$v = array_count_values($hosts);
		echo '<p>'.print_r($hosts).'</p>';
		echo '<p>'.print_r($v).'</p>';
		echo '<p>'.print_r($data).'</p>';
		$count  = count($hosts);
		$table = "\n".'<table border="1">'."\n\t".
					'<tr>'."\n\t\t".
						'<th>Musician(s)</th>'."\n\t\t".
						'<th>Host</th>'."\n\t\t".
						'<th>Phone Number</th>'."\n\t\t".
						'<th>Address</th>'."\n\t".
					'</tr>'."\n";
		for($i=0;$i<$count;$i++){
			$table .= "\t".'<tr>'."\n\t\t".
					'<td>'.$data[$i]['m_firstName'].' '.$data[$i]['m_lastName'];
					if($v[$data[$i]['me_hostID']] > 1){
						$skip = ($v[$data[$i]['me_hostID']]);
						echo '<p>Dupe: '.$dupe.'</p>';
						for($k=$i+1;$k<$i+$skip;$k++){
							$table .= ', '.$data[$k]['m_firstName'].' '.$data[$k]['m_lastName'];
						}
						$i = $i + $skip;
					}
			$table .= '</td>'."\n\t\t".
				'<td>'.$data[$i]['h_firstName'].' '.$data[$i]['h_lastName'].'</td>'."\n\t\t".
				'<td>'.$data[$i]['h_homePhone'].'</td>'."\n\t\t".
				'<td>'.$data[$i]['h_streetAddr'].'</td>'."\n\t\t".
				'</tr>'."\n";
		}
		$table .= '</table>'."\n";
		return $table;
	}
	
	function parseDate($date){
		$parse = explode('-',$date);
		return $parse[1].'/'.$parse[2].'/'.$parse[0];
	}	
	



}
?>