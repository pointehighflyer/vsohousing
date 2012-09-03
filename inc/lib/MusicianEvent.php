<?php
//Supporting class for all operations related to the MusicianEvent table
class MusicianEvent{
	var $type = 'MusicianEvent';
	


	//query the database for all records matching the id
	function selectMusicians($id){
		$q = 'SELECT m.pkMusicianID AS m_musicianID, '.
				'm.fldFirstName AS m_firstName, '.
				'm.fldLastName AS m_lastName, '.
				'h.pkHostID AS h_hostID, '.
				'h.fldFirstName AS h_firstName, '.
				'h.fldLastName AS h_lastName, '.
				'me.fldStartDate AS me_startDate, '.
				'me.fldEndDate AS me_endDate '.
				'FROM MusicianEvent as me '.
				'LEFT JOIN tblMusician AS m ON m.pkMusicianID=me.fkMusicianID '.
				'LEFT JOIN tblHost AS h ON me.fkHostID=h.pkHostID WHERE me.fkEventID='.$id.
				' ORDER BY m.fldLastName ASC';
		//echo '<p>'.$q.'</p>';
		return $q;
	}
	
	function addMusician($musician,$event,$host){
		$q = 'INSERT INTO MusicianEvent SET '.
			'fkMusicianID='.$musician.', '.
			'fkEventiD='.$event.', '.
			'fkHostID='.$host;
		return $q;
	}
	
	//put the results of the selectMusician query into a 2D array 
	function getData($r){
		$data = array();
		while($row = mysql_fetch_assoc($r)){
			$data[] = $row; 
		}
		return $data;
	}
	
	function makeList($r){	
	}
	




	
	
	function display(){
		echo 'MusicianID: '.$this->musicianID.'<br/>';
		echo 'EventID: '.$this->eventID.'<br/>';
		echo 'HostID: '.$this->hostID.'<br/>';
	}
}

?>