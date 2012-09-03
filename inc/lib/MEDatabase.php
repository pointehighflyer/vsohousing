<?php
//Supporting class for all operations related to the MusicianEvent table
class MEDatabase{
	var $type = 'MEDatabase';
	var $id;
	
	
	
	function MEDatabase(){
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
			//$_SESSION['id'] = $this->id;
		}
		/*elseif(isset($_SESSION['id'])){
			$this->id = $_SESSION['id'];
		}*/
		//else{die('<p>Error: could not get an event ID</p>');}
	}

	//query the database for all records matching the id
	function selectMusicians(){
		$q = 'SELECT m.fldFirstName AS m_firstName, '.
				'm.fldLastName AS m_lastName, '.
				'h.pkHostID AS h_hostID, '.
				'h.fldFirstName AS h_firstName, '.
				'h.fldLastName AS h_lastName, '.
				'me.fkMusicianID AS me_musicianID, '.
				'me.fkHostID AS me_hostID, '.
				'me.fldStartDate AS me_startDate, '.
				'me.fldEndDate AS me_endDate, '.
				'me.fldMatch AS me_match, '.
				'me.fldStatus AS me_status '.
				'FROM MusicianEvent as me '.
				'LEFT JOIN tblMusician AS m ON m.pkMusicianID=me.fkMusicianID '.
				'LEFT JOIN tblHost AS h ON me.fkHostID=h.pkHostID WHERE me.fkEventID='.$this->id.
				' ORDER BY m.fldLastName ASC, m.fldFirstName ASC';
		//echo '<p>'.$q.'</p>';
		return $q;
	}
	
	function selectRemainingMusicians(){
	$q = 'SELECT pkMusicianID, fldFirstName, fldLastName FROM '.
				'tblMusician AS m WHERE m.pkMusicianID NOT IN '.
					'(SELECT me.fkMusicianID FROM MusicianEvent AS me WHERE me.fkEventID='.$this->id.') '.
				'ORDER BY fldLastName ASC, fldFirstName ASC';
	return $q;
	}
	
	function getMusicianInfo(){
		$q = 'SELECT me.fkMusicianID AS me_musicianID, '.
			'm.fkPrimaryHost AS m_primaryHost, '.
			'm.fldAllrgSmoke AS m_allrgSmoke, '.
			'm.fldAllrgCats AS m_allrgCats, '.
			'm.fldAllrgDogs AS m_allrgDogs, '.
			'h.fldIsActive AS h_isActive '.
			'FROM MusicianEvent AS me '.
			'LEFT JOIN tblMusician AS m ON m.pkMusicianID=me.fkMusicianID '.
			'LEFT JOIN tblHost AS h ON m.fkPrimaryHost=h.pkHostID '.
			'WHERE me.fkEventID='.$this->id;
		return $q;
	}
	
	
	function getHostInfo(){
		$q = 'SELECT h.pkhostID AS h_hostID, '.
			'h.fldHasCats AS h_hasCats, '.
			'h.fldHasDogs AS h_hasDogs, '.
			'h.fldSmokingHouse AS h_smokingHouse FROM '.
			'tblHost AS h WHERE h.fldIsActive=1';
		return $q;
	}
	
	function getMatchHistory($mID, $start, $end){
		$q = 'SELECT me.fkHostID '.
			'FROM MusicianEvent AS me '.
			'LEFT JOIN tblHost AS h ON h.pkHostID=me.fkHostID '.
			'LEFT JOIN tblEvent AS e ON e.pkEventID=me.fkEventID '.
			'WHERE me.fkMusicianID='.$mID.' '.
			'AND e.fldDate >= "'.$start.'" '.
			'AND e.fldDate <= "'.$end.'" '.
			'AND h.fldIsActive=1 ORDER BY e.fldDate DESC LIMIT 1';
			/*SELECT me.fkHostID AS me_hostID, m.fldFirstName AS m_firstName, h.fldFirstName AS h_firstName 
			FROM MusicianEvent AS me 
			LEFT JOIN tblHost AS h ON h.pkHostID=me.fkHostID 
			LEFT JOIN tblEvent AS e ON e.pkEventID=me.fkEventID 
			LEFT JOIN tblMusician AS m ON pkMusicianID=me.fkMusicianID 
			WHERE me.fkMusicianID=27 
			AND h.fldIsActive=1 
			AND e.fldDate >= "2007-02-05" 
			AND e.fldDate <= "2011-02-05" 
			ORDER BY e.fldDate DESC LIMIT 1*/
		return $q;
	}
	
	function getReportInfo(){
		$q = 'SELECT me.fkHostID AS me_hostID, '.
			'm.fldFirstName AS m_firstName, '.
			'm.fldLastName AS m_lastName, '.
			'h.fldFirstName AS h_firstName, '.
			'h.fldLastName AS h_lastName, '.
			'h.fldFirstName2 AS h_firstName2, '.
			'h.fldLastName2 AS h_lastName2, '.
			'h.fldStreetAddr AS h_streetAddr, '.
			'h.fldTown AS h_town, '.
			'h.fldPhone AS h_phone '.
			'FROM MusicianEvent as me '.
			'LEFT JOIN tblMusician AS m ON m.pkMusicianID=me.fkMusicianID '.
			'LEFT JOIN tblHost AS h ON me.fkHostID=h.pkHostID WHERE me.fkEventID='.$this->id.
			' ORDER BY m.fldLastName ASC';
		return $q;
	}	
	
	
	function getMailInfo($id){
		$q = 'SELECT me.fkhostID AS me_hostID, '. 
			 'me.fldStartDate AS me_startDate, '.
			'me.fldEndDate AS me_endDate, '.
			'm.fldFirstName AS m_firstName, '.
			'm.fldLastName AS m_lastName, '.
			'h.fldFirstName AS h_firstName, '.
			'h.fldLastName AS h_lastName, '.
			'h.fldFirstName2 AS h_firstName2, '.
			'h.fldLastName2 AS h_lastName2, '.
			'h.fldEmail AS h_email '.
			'FROM MusicianEvent as me '.
			'LEFT JOIN tblMusician AS m ON m.pkMusicianID=me.fkMusicianID '.
			'LEFT JOIN tblHost AS h ON me.fkHostID=h.pkHostID WHERE '.
			'me.fkEventID='.$id.' AND me.fkHostID!=-1 ORDER BY h.fldLastName ASC, m.fldLastName ASC';
		return $q;
	}
	
	function addMusician($musician,$start,$end,$host){
		$q = 'INSERT INTO MusicianEvent SET '.
			'fkMusicianID='.$musician.', '.
			'fldStartDate="'.$start.'", '.
			'fldEndDate="'.$end.'", '.
			'fkEventiD='.$this->id.', '.
			'fkHostID='.$host;
		return $q;
	}
	
	function updateMusician($row){
		$q = 'UPDATE MusicianEvent SET '.
			'fldStartDate="'.$row['me_startDate'].'", '.
			'fldEndDate="'.$row['me_endDate'].'", '.
			'fkHostID='.$row['me_hostID'].', '.
			'fldMatch="'.$row['me_match'].'", '.
			'fldStatus="'.$row['me_status'].'" '.
			'WHERE fkMusicianID='.$row['me_musicianID'].' AND fkEventID='.$this->id;
		return $q;
	}
	
	function updateMatch($row){
		$q = 'UPDATE MusicianEvent SET '.
			'fkHostID='.$row['me_hostID'].', '.
			'fldMatch="'.$row['me_match'].'" '.
			'WHERE fkMusicianID='.$row['me_musicianID'].' AND fkEventID='.$this->id;
		return $q;
	}
	
	function deleteMusician($id){
		$q = 'DELETE FROM MusicianEvent WHERE '.
			'fkMusicianID='.$id.' AND fkEventID='.$this->id;
		return $q;
	}
	
	function clearEvent($id){
		$query = 'DELETE FROM MusicianEvent WHERE fkEventID='.$id;
		return $query;
	}
	
	function clearHost($id){
		$query = 'DELETE FROM MusicianEvent WHERE fkHostID='.$id;
		return $query;
	}
	
	function clearMusician($id){
		$query = 'DELETE FROM MusicianEvent WHERE fkMusicianID='.$id;
		return $query;
	}
	
	//return the result of the getMatchHistory query
	//return 0 if there was no record
	function getHistoryMatch($r){
		if($row = mysql_fetch_row($r)){
			return $row[0];
		}
		else{
			return 0;
		}
	}
	
	//put the results of the select query into a 2D array 
	function getData($r){
		$data = array();
		while($row = mysql_fetch_assoc($r)){
			$data[] = $row; 
		}
		return $data;
	}
	
	function makeList($r){	
	}
	
	function getHostHst($id){
		$q = 'SELECT me.fkEventID AS me_eventID, '.
			'me.fldStartDate AS me_startDate, '.
			'me.fldEndDate AS me_endDate, '.
			'he.fldNotes AS he_notes, '.
			'm.fldFirstName AS m_firstName, '.
			'm.fldLastName AS m_lastName, '.
			'e.fldTitle AS e_title, '.
			'e.fldDate AS e_date '.
			'FROM MusicianEvent AS me '.
			'LEFT JOIN tblMusician AS m ON '.
			'm.pkMusicianID=me.fkMusicianID '.
			'LEFT JOIN tblEvent AS e ON '.
			'e.pkEventID=me.fkEventID '.
			'LEFT JOIN HostEvent AS he ON '.
			'he.fkHostID=me.fkHostID AND he.fkEventID=me.fkEventID '.
			'WHERE me.fkHostID='.$id.' ORDER BY e.fldDate DESC, m_lastName ASC';
		return $q;
	}
	
	function getMusicianHst($id){
		$q = 'SELECT me.fldStartDate AS me_startDate, '.
			'me.fldEndDate AS me_endDate, '.
			'me.fldNotes AS me_notes, '.
			'h.fldFirstName AS h_firstName, '.
			'h.fldLastName AS h_lastName, '.
			'h.fldFirstName2 AS h_firstName2, '.
			'h.fldLastName2 AS h_lastName2, '.
			'e.fldTitle AS e_title, '.
			'e.fldDate AS e_date '.
			'FROM MusicianEvent AS me '.
			'LEFT JOIN tblHost AS h ON '.
			'h.pkHostID=me.fkHostID '.
			'LEFT JOIN tblEvent AS e ON '.
			'e.pkEventID=me.fkEventID '.
			'WHERE me.fkMusicianID='.$id.' ORDER BY e.fldDate DESC';
		return $q;
	}
	
	
	function selectAllHst(){
		$q = 'SELECT me.fldStartDate AS me_startDate, '.
			'me.fldEndDate AS me_endDate, '.
			'me.fldNotes AS me_notes, '.
			'me.fkMusicianID AS me_musicianID, '.
			'me.fkHostID AS me_hostID, '.
			'me.fkEventID AS me_eventID, '.
			'h.fldFirstName AS h_firstName, '.
			'h.fldLastName AS h_lastName, '.
			'h.fldFirstName2 AS h_firstName2, '.
			'h.fldLastName2 AS h_lastName2, '.
			'm.fldFirstName AS m_firstName, '.
			'm.fldLastName AS m_lastName, '.
			'e.fldTitle AS e_title, '.
			'e.fldDate AS e_date '.
			'FROM MusicianEvent AS me '.
			'LEFT JOIN tblHost AS h ON '.
			'h.pkHostID=me.fkHostID '.
			'LEFT JOIN tblEvent AS e ON '.
			'e.pkEventID=me.fkEventID '.
			'LEFT JOIN tblMusician AS m ON '.
			'm.pkMusicianID=me.fkMusicianID '.
			'ORDER BY e.fldDate DESC, m_lastName ASC';
		return $q;
	}


	
	
	function display(){
		echo 'MusicianID: '.$this->musicianID.'<br/>';
		echo 'EventID: '.$this->eventID.'<br/>';
		echo 'HostID: '.$this->hostID.'<br/>';
	}
}

?>