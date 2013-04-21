<?php
require_once "ExcelExport.php";

class MEForm extends Form{

	var $type = 'MEForm';

	var $id; //the event we're working with

	var $data;

	var $musicianList;

	var $hostList;

	var $statusList = array(

						'Suggested Host' => 'Suggested Host', 

						'Reviewed by Planner' => 'Reviewed by Planner',

						'Host Contacted' => 'Host Contacted',

						'Host Accepted' => 'Host Accepted',

						'Host Declined' => 'Host Declined');

	

	

	function MEForm(){

		parent::Form('post');

		if(isset($_GET['id'])){

			$this->id = $_GET['id'];

			//$_SESSION['id'] = $this->id;

		}

		/*elseif(isset($_SESSION['id'])){

			$this->id = $_SESSION['id'];

		}*/

		//else{die('<p>Error: could not get an event ID</p>');}

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

	

	function submitted(){

		if(isset($this->globalArr['submit'])){

			//echo '<p>Adding</p>';

			return 1;

		}

		else{

			//echo '<p>Not Adding</p>';

			return 0;

		}

	}

	

	function getReportClean(){

		return $this->sanitize('rtext');

		//return $this->sanitize('rtext');

	}

	

	function getReportText(){

		return $this->globalArr['rtext'];

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

				if($row['me_hostID'] != $this->globalArr['currhost']){

					$row['me_match'] = 'Manual';

				}

				else{

					$row['me_match'] = $this->globalArr['currmatch'];

				}

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

	

	function makeMEForm($data){

		$counter =  count($data);

		$form = "\n".'<form action="'.$_SERVER['PHP_SELF'].'?id='.$this->id.'" method="post">'."\n";

		$form .= '<fieldset id="addmusician">'."\n".

				'<label for="mlist">Musician: </label>'."\n".

				$this->makeListS('musician',$this->musicianList,-1).

				$this->makeSubmit('add','Add').

				'</fieldset>';

		$form .= '<fieldset>'."\n".

				$this->makeHidden('count',$counter)."\n".

				$this->makeSubmit('match','First Pass Match Selected')."\n".  //client's choice not mine

				$this->makeSubmit('update','Update Checked')."\n".

				$this->makeSubmit('deletechecked','Delete Checked')."\n".

				'</fieldset>'."\n";

		$form .= '<fieldset>'."\n".

				'<table id="metadata">'."\n".

					'<tr>'."\n".

						'<th>Select: <input type="checkbox" name="sAll" onclick="selectAll(this)"/></th>'."\n".

						'<th>Musician</th>'."\n".

						'<th>Start Date</th>'."\n".

						'<th>End Date</th>'."\n".

						'<th>Select Host</th>'."\n".

						'<th>Matched By</th>'."\n".

						'<th>Match Status</th>'."\n".

					'</tr>'."\n";

		//generate dynamic fields

		$i = $counter;

		foreach($data as $row){

			$num = $counter - $i;

			if($row['me_hostID'] == -1){

				//echo '<p>fkHostID: '.$row['me_hostID'].'</p>';

				$host = 'Unspecified';

				//echo '<p>Text: '.$host.'</p>';

			}

			else{ 

				$host = $row['h_firstName'].' '.$row['h_lastName'];

			}

			$form .= '<tr>'."\n".

					'<td>'."\n".

					$this->makeCheck('select'.$num,'1',0)."\n".

					$this->makeHidden('musician'.$num,$row['me_musicianID'])."\n".

					$this->makeHidden('currhost'.$num,$row['me_hostID'])."\n".

					'</td>'."\n".

					'<td>'.$row['m_firstName'].' '.$row['m_lastName'].'</td>'."\n".

					'<td>'.$this->makeDateSelect('sday'.$num,'smonth'.$num,'syear'.$num,$row['me_startDate']).'</td>'."\n".

					'<td>'.$this->makeDateSelect('eday'.$num,'emonth'.$num,'eyear'.$num,$row['me_endDate']).'</td>'."\n".

					//'<td>'.$host.'</td>'."\n".

					'<td>'.$this->makeListS('host'.$num,$this->hostList,$row['me_hostID']).'</td>'."\n".

					'<td>'.$row['me_match']."\n".$this->makeHidden('currmatch'.$num,$row['me_match']).'</td>'."\n".

					'<td>'.$this->makeListS('status'.$num,$this->statusList,$row['me_status']).'</td>'."\n".

					'</tr>'."\n";

					$i--;

		}

		$form .= '</table>'."\n".'</fieldset>'."\n";

		

		/*$form .= '<fieldset>'."\n".

				$this->makeHidden('count',$counter)."\n".

				$this->makeSubmit('match','First Pass Match Selected')."\n".  //client's choice not mine

				$this->makeSubmit('update','Update Checked')."\n".

				$this->makeSubmit('deletechecked','Delete Checked')."\n".

				//$this->makeSubmit('request','Housing Request')."\n".

				//$this->makeSubmit('report','Housing Report')."\n".

				'</fieldset>'."\n";

		$form .= '<fieldset id="addmusician">'."\n".

				'<label for="mlist">Musician: </label>'."\n".

				$this->makeListS('musician',$this->musicianList,-1).

				$this->makeSubmit('add','Add').

				'</fieldset>';*/

		$form .= '</form>'."\n";

		return $form;

	}

	

	function makeMusicianHst($data){

		$t = '<table id="metaData">'."\n".

				'<tr>'."\n".

					'<th>Event</th>'."\n".

					'<th>Date</th>'."\n".

					'<th>Host</th>'."\n".

					'<th>Musician(s)'."\n".

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

						'<td>'.$row['musicians'].'</td>'."\n".

					'</tr>'."\n";

		}

		$t .= '</table>'."\n";

		return $t;			

	}

	

	function makeHostHst($data){

		$events = array();

		foreach($data as $row){

			$events[] = $row['me_eventID'];

		}

		$v = array_count_values($events);

		$count = count($events);

		$t = '<table id="metaData">'."\n".

				'<tr>'."\n".

					'<th>Event</th>'."\n".

					'<th>Date</th>'."\n".

					'<th>Musician</th>'."\n".

					'<th>Notes</th>'."\n".

				'</tr>'."\n";

		for($i=0;$i<$count;$i++){

			$t .= 	'<tr>'."\n".

						'<td>'.$data[$i]['e_title'].'</td>'."\n".

						'<td>'.$this->parseDate($data[$i]['e_date']).'</td>'."\n".

						'<td>'.$data[$i]['m_firstName'].' '.$data[$i]['m_lastName'];

						if($v[$data[$i]['me_eventID']] > 1){

							$skip = ($v[$data[$i]['me_eventID']]);

							for($k=$i+1;$k<$i+$skip;$k++){

								$t .= ', '.$data[$k]['m_firstName'].' '.$data[$k]['m_lastName'];

							}

							$i = $i + ($skip-1);

						}

						$t .= '</td>'."\n".

						'<td>'.$this->stripChars($data[$i]['he_notes']).'</td>'."\n".

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

			if($data[$i]['h_firstName2'] != ''){

				if($data[$i]['h_lastName2'] != ''){

					echo 'check';

					$host = $data[$i]['h_firstName'].' '.$data[$i]['h_lastName'].' and '.$data[$i]['h_firstName2'].' '.$data[$i]['h_lastName2'];

					echo $host;

				}

				else{

					$host = $data[$i]['h_firstName'].' and '.$data[$i]['h_firstName2'].' '.$data[$i]['h_lastName'];

				}
			}

			else{
				$host = $data[$i]['h_firstName'].' '.$data[$i]['h_lastName'];
			}			

			$table .= "\t".'<tr>'."\n\t\t".
					'<td>'.$data[$i]['m_firstName'].' '.$data[$i]['m_lastName'];

			//what a PITA

			if($v[$data[$i]['me_hostID']] > 1){

				$skip = ($v[$data[$i]['me_hostID']]);

				for($k=$i+1;$k<$i+$skip;$k++){

					$table .= ' , '.$data[$k]['m_firstName'].' '.$data[$k]['m_lastName'];

				}

				$i = $i + ($skip-1);

			}

			$table .= '</td>'."\n\t\t".
				'<td>'.$host.'</td>'."\n\t\t".
				'<td>'.$data[$i]['h_homePhone'].'</td>'."\n\t\t".
				'<td>'.$data[$i]['h_streetAddr'].', '.$data[$i]['h_town'].'</td>'."\n\t\t".

				'</tr>'."\n";
		}

		$table .= '</table>'."\n";

		return $table;
	}

	function makeReportTable($data){

		$table = "\n".'<table class="report">'."\n\t".

					'<tr style="text-align:left;font-weight:bold;">'."\n\t\t".
						'<th>Musician</th>'."\n\t\t".
						'<th>Host</th>'."\n\t\t".
						'<th>Phone Number</th>'."\n\t\t".
						'<th>Address</th>'."\n\t".
					'</tr>'."\n";

		foreach($data as $row){

			if($row['h_firstName2'] != ''){

				if($row['h_lastName2'] != ''){

					//echo 'check';
					$host = $row['h_firstName'].' '.$row['h_lastName'].' and '.$row['h_firstName2'].' '.$row['h_lastName2'];

				}

				else{
					$host = $row['h_firstName'].' and '.$row['h_firstName2'].' '.$row['h_lastName'];
				}
			}

			else{
				$host = $row['h_firstName'].' '.$row['h_lastName'];
			}

			$table .= "\t".'<tr>'."\n\t\t".
			'<td>'.$row['m_firstName'].' '.$row['m_lastName'].'</td>'."\n\t\t".
				'<td>'.$host.'</td>'."\n\t\t".
				'<td>'.$row['h_phone'].'</td>'."\n\t\t".
				'<td>'.$row['h_streetAddr'].', '.$row['h_town'].'</td>'."\n\t\t".
				'</tr>'."\n";
		}

		$table .= '</table>'."\n";

		return $table;
	}

	function makeReportForm(){

		$form = "\n".'<form action="'.$_SERVER['PHP_SELF'].'?id='.$this->id.'&amp;export=1" method="post">'."\n".

			'<fieldset>'."\n".

			'<p>Enter the text which will appear at the top of the report.</p>'."\n".

			$this->makeTextArea('rtext',$this->stripChars($this->rText),8,60).'<br/>'."\n".

			$this->makeSubmit('submit','Generate Report')."\n".

			'</fieldset>'."\n".'</form>'."\n";

		return $form;

	}

	function exportReport($title,$text,$data){
		$html = '<h1 style="text-align:center;font-size:12pt;font-weight:bold;text-decoration:underline;">VSO Musician Housing</h1>'.

		'<h2 style="text-align:center;font-size:12pt;font-weight:bold;text-decoration:underline;">'.$title.'</h2>'.

		'<p style="font-size:12pt;margin-left:auto;margin-right:auto;width:700px;">'.nl2br($this->stripChars($text)).'</p>'.

		$this->makeReportTable($data);
	        $html .= '<br>';
                $html .= date('m/d/Y h:i:s a', time());
                $html .= '</div>';

		return $html;
	}

	function exportExcel($title,$text,$data){
$xls = new ExcelExport();

$xls->addRow(Array("Musician","Host","Phone Number", "Address"));
		foreach($data as $row){
			if($row['h_firstName2'] != ''){
			   if($row['h_lastName2'] != ''){
				$host = $row['h_firstName'].' '.$row['h_lastName'].' and '.$row['h_firstName2'].' '.$row['h_lastName2'];
				}
				else{
					$host = $row['h_firstName'].' and '.$row['h_firstName2'].' '.$row['h_lastName'];
				}
			}

			else{
				$host = $row['h_firstName'].' '.$row['h_lastName'];
			}
$xls->addRow(Array($row['m_firstName']. ' '.$row['m_lastName'],$host,$row['h_phone'],$row['h_streetAddr'].', '.$row['h_town']));

                }

$xls->download("vso-housing.xls");
}

function parseDate($date){
		$parse = explode('-',$date);
		return $parse[1].'/'.$parse[2].'/'.$parse[0];
	}	
}
?>
