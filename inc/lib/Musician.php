<?php
//Supporting class for all operations related to the Musician table
class Musician{ //implements DBInterface{
	
	var $type = 'Musician';
	
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
	
	function fields(){
		/*$query = "INSERT INTO tblMusician
				(fldFirstName,fldLastName,fkPrimaryHost,
				fldInstrument,fldTown,fldState,fldSmokes,
				fldSmokingAllowed,fldAllergy,fldLikeBikePath,
				fldLikeDowntown,fldCarpools,fldNotes) VALUES 
				($firstName,$lastName,$primaryHost,$instrument,
				$town,$state,$smokes,$smokingAllowed,$allergy,
				$likeBikePath,$likeDowntown,$carpools,$notes)";*/
				
		$query = 'fldFirstName="'.$this->firstName.'", '.
				'fldLastName="'.$this->lastName.'", '.
				'fldInstrument="'.$this->instrument.'", '.
				'fldTown="'.$this->town.'", '.
				'fldState="'.$this->state.'", '.
				'fldSmokes="'.$this->smokes.'", '.
				'fldSmokingAllowed="'.$this->smokingAllowed.'", '.
				'fldAllergy="'.$this->allergy.'", '.
				'fldAllrgCats="'.$this->allrgCats.'", '.
				'fldAllrgDogs="'.$this->allrgDogs.'", '.
				'fldAllrgSmoke="'.$this->allrgSmoke.'", '.
				'fldLikeBikePath="'.$this->likeBikePath.'", '.
				'fldLikeDownTown="'.$this->likeDowntown.'", '.
				'fldCarpools="'.$this->carpools.'", '.
				'fkPrimaryHost="'.$this->primaryHost.'", '.
				'fldNotes="'.$this->notes.'"';
		return $query;
	}
	
	function selectID($id){
		$query = 'SELECT m.pkMusicianID AS pkMusicianID, '.
						'm.fldFirstName AS fldFirstName, '.
						'm.fldLastName AS fldLastName, '.
						'm.fldInstrument AS fldInstrument, '.
						'm.fldTown AS fldTown, '.
						'm.fldState AS fldState, '.
						'm.fldSmokes AS fldSmokes, '.
						'm.fldSmokingAllowed AS fldSmokingAllowed, '.
						'm.fldAllergy AS fldAllergy, '.
						'm.fldAllrgCats AS fldAllrgCats, '.
						'm.fldAllrgDogs AS fldAllrgDogs, '.
						'm.fldAllrgSmoke AS fldAllrgSmoke, '.
						'm.fldLikeBikePath AS fldLikeBikePath, '.
						'm.fldLikeDowntown AS fldLikeDowntown,'.
						'm.fldCarpools AS fldCarpools, '.
						'm.fkPrimaryHost AS fkPrimaryHost, '.
						'm.fldNotes AS fldNotes, '.
						'h.fldFirstName AS hostFirst, '.
						'h.fldLastName AS hostLast, '.
						'h.fldFirstName2 AS hostFirst2, '.
						'h.fldLastName2 AS hostLast2 '.
						'FROM tblMusician AS m '.
						'LEFT JOIN tblHost AS h ON m.fkPrimaryHost=h.pkHostID '.
						'WHERE m.pkMusicianID='.$id;
		return $query;
	}
	
	function selectNames(){
		$query = 'SELECT pkMusicianID, fldFirstName, fldLastName FROM tblMusician ORDER BY fldLastName ASC, fldFirstName ASC';
		return $query;
	}
	
	function add(){
		$query = 'INSERT INTO tblMusician SET '.$this->fields();
		return $query;	
	}
	
	function update(){
		$query = 'UPDATE tblMusician SET '.$this->fields().' WHERE pkMusicianID='.$this->musicianID;
		return $query;
	}
	
	function delete($id){
		$query = 'DELETE FROM tblMusician WHERE pkMusicianID='.$id;
		return $query;
	}
	
	function buildList($r){
		$list = '<ul id="recordlist">';
		$data = mysql_fetch_assoc($r);
		while($data){
			$list .= '<li class="record"><a href="'.$_SERVER['PHP_SELF'].'?id='.$data['pkMusicianID'].'#'.$data['pkMusicianID'].'" name = "'.$data['pkMusicianID'].'" id="'.$data['pkMusicianID'].'">'.
			$data['fldLastName'].', '.$data['fldFirstName'].'</a></li>';
			$data = mysql_fetch_assoc($r);
		}
		$list .= '</ul>';
		return $list;
	}
	
	function buildEdit(){
		$text = '<p><a href="'.$_SERVER['PHP_SELF'].'?action=update&id='.$this->musicianID.'">Edit Musician</a></p>';
		return $text;
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

	function setValues($r){
		$arr = mysql_fetch_assoc($r);
		$this->musicianID = $arr['pkMusicianID'];
		$this->firstName = $arr['fldFirstName'];
		$this->lastName = $arr['fldLastName'];
		$this->town = $arr['fldTown'];
		$this->state = $arr['fldState'];
		$this->instrument = $arr['fldInstrument'];
		$this->smokes = $arr['fldSmokes'];
		$this->smokingAllowed = $arr['fldSmokingAllowed'];
		//$this->allergy = $arr['fldAllergy'];
		$this->allrgCats = $arr['fldAllrgCats'];
		$this->allrgDogs = $arr['fldAllrgDogs'];
		$this->allrgSmoke = $arr['fldAllrgSmoke'];
		//$this->likeBikePath = $arr['fldLikeBikePath'];
		//$this->likeDowntown = $arr['fldLikeDowntown'];
		//$this->carpools = $arr['fldCarpools'];
		$this->primaryHost = $arr['fkPrimaryHost'];
		$this->notes = $arr['fldNotes'];
		$this->hostFirst = $arr['hostFirst'];
		$this->hostLast = $arr['hostLast'];
		$this->hostFirst2 = $arr['hostFirst2'];
		$this->hostLast2 = $arr['hostLast2'];
		
	}
		
	function display(){
		echo 'MusicianID: '.$this->musicianID.'<br/>';
		echo 'FirstName: '.$this->firstName.'<br/>';
		echo 'LastName: '.$this->lastName.'<br/>';
		echo 'Instrument: '.$this->instrument.'<br/>';
		echo 'Town: '.$this->town.'<br/>';
		echo 'State/Province: '.$this->state.'<br/>';
		echo 'Smokes: '.$this->smokes.'<br/>';
		echo 'SmokingAllowed: '.$this->smokingAllowed.'<br/>';
		//echo 'Allergy: '.$this->allergy.'<br/>';
		echo 'Allergic to Cats: '.$this->allrgCatsc.'<br/>';
		echo 'Allergic to Dogs: '.$this->allrgDogs.'<br/>';
		echo 'Allergic to Smoke: '.$this->allrgSmoke.'<br/>';
		//echo 'LikeBikePath: '.$this->likeBikePath.'<br/>';
		//echo 'LikeDowntown: '.$this->likeDowntown.'<br/>';
		//echo 'Carpools: '.$this->carpools.'<br/>';
		echo 'PrimaryHost: '.$this->primaryHost.'<br/>';
		echo 'Notes: '.$this->notes.'<br/>';
	}
	
	function getNameArray($r){
		$arr['Select'] = -1;
		$data = mysql_fetch_assoc($r);
		while($data){
			//echo $data['fldFirstName'],$data['fldLastName'],$data['pkHostID'];
			$arr[$data['fldLastName'].', '.$data['fldFirstName']] = $data['pkMusicianID'];
			$data = mysql_fetch_assoc($r);
		}
		//print_r($arr);
		return $arr;
	}


}
?>
