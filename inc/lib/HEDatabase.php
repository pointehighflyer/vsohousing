<?php
class HEDatabase{

	var $type = 'HEDatabase';
	var $id;
	
	
	
	function HEDatabase(){
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
	}
	
	
	
	function selectHosts(){
		$q = 'SELECT h.fldFirstName AS h_firstName, '.
			'h.fldLastName AS h_lastName, '.
			'h.pkHostID AS h_hostID, '.
			'he.fldIsActive AS he_isActive, '.
			'he.fldFreeTixReq AS he_freeTix, '.
			'he.fldHalfPrTixReq AS he_halfTix, '.
			'he.fldFullPrTixReq AS he_fullTix, '.
			'he.fldNotes AS he_notes '.
			'FROM HostEvent AS he LEFT JOIN tblHost AS h ON h.pkHostID=he.fkHostID '.
			'WHERE he.fkEventID='.$this->id.' ORDER BY h.fldLastName ASC, h.fldFirstName ASC';
		return $q;			
	}
	
	function selectRemainingHosts(){
		$q = 'SELECT pkHostID, fldFirstName, fldLastName FROM '.
				'tblHost AS h WHERE h.pkHostID NOT IN '.
					'(SELECT he.fkHostID FROM HostEvent AS he WHERE he.fkEventID='.$this->id.') '.
				'ORDER BY fldLastName ASC, fldFirstName ASC';
		return $q;
	}
	
	function addHost($hostID){
		$q = 'INSERT INTO HostEvent SET '.
			'fkHostID='.$hostID.', '.
			'fkEventID='.$this->id.', '.
			'fldIsActive=1, '.
			'fldFreeTixReq=-1, '.
			'fldHalfPrTixReq=-1, '.
			'fldFullPrTixReq=-1, '.
			'fldNotes=" "';	
		return $q;
	}
	
	function updateHost($row){
		$q = 'UPDATE HostEvent SET '.
			'fldIsActive='.$row['he_isActive'].', '.
			'fldFreeTixReq='.$row['he_freeTix'].', '.
			'fldHalfPrTixReq='.$row['he_halfTix'].', '.
			'fldFullPrTixReq='.$row['he_fullTix'].', '.
			'fldNotes="'.$row['he_notes'].'" '.
			'WHERE fkHostID='.$row['he_hostID'].' AND fkEventID='.$this->id;
		return $q;
	}
	
	function deleteHost($id){
		$q = 'DELETE FROM HostEvent WHERE fkHostID='.$id.' AND fkEventID='.$this->id;
		return $q;
	}
	
	function clearEvent($id){
		$q = 'DELETE FROM HostEvent WHERE fkEventID='.$id;
		return $q;
	}
	
	function clearHost($id){
		$q = 'DELETE FROM HostEvent WHERE fkHostID='.$id;
		return $q;
	}

	//put the results of the select query into a 2D array 
	function getData($r){
		$data = array();
		while($row = mysql_fetch_assoc($r)){
			$data[] = $row; 
		}
		return $data;
	}

	function getNameArray($r){
		$arr['Select'] = -1;
		$data = mysql_fetch_assoc($r);
		while($data){
			//echo $data['fldFirstName'],$data['fldLastName'],$data['pkHostID'];
			$arr[$data['fldFirstName'].' '.$data['fldLastName']] = $data['pkHostID'];
			$data = mysql_fetch_assoc($r);
		}
		//print_r($arr);
		return $arr;
	}






}
?>