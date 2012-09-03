<?php
//Supporting class for all operations related to the Host table
class Host{
	
	var $type = 'Host';
	
	//fields
	var $hostID;
	var $firstName;
	var $lastName;
	var $firstName2;
	var $lastName2;
	var $streetAddr;
	var $town;
	var $zip;
	var $region; 
	var $homePhone;
	var $workPhone;
	var $cellPhone;
	var $primaryPhone = 0;
	var $email;
	var $altEmail;
	var $isActive; //whoops!
	var $hasChildren = 0;
	var $hasCats;
	var $hasDogs;
	var $smokingHouse;
	var $smokingAllowed;
	var $singlesAllowed;
	var $max;
	var $singleBeds;
	var $rooms;
	var $doubleBeds;
	var $startDate;// = '2011-01-01';//IMPLEMENT!!!
	var $prefMen;      //'YYYY-MM-DD'
	var $prefWomen;
	var $partnerID = 22; //IMPLEMENT!!!
	//var $partner;
	var $directions;
	var $notes;
	
	
	function fields(){
		/*$query = "INSERT INTO tblHost
				(fldFirstName,fldLastName,fldStreetAddr,
				fldTown,fldZip,fldHTown,fldHPhone,fldWPhone,
				fldCPhone,fldEmail,fldAltEmail,fldIsActive,
				fldHasChildren,fldHasCats,fldHasDogs,fldSmokingHouse,
				fldSmokingAllowed,fldSinglesAllowed,fldSingleBeds,
				fldDoubleBeds,fldStartDate,fldPrefMen,fldPrefWomen,
				fkPartnerID,fldNotes) VALUES ($firstName,$lastName,
				$streetAddr,$town,$zip,$region,$homePhone,$workPhone,
				$cellPhone,$email,$altEmail,$hasChildren,$hasCats,$hasDogs,
				$smokingHouse,$smokingAllowed,$singlesAllowed,$singleBeds,
				$doubleBeds,$startDate,$prefMen,$prefWomen,$partnerID,$notes)";*/
		$query = 'fldFirstName="'.$this->firstName.'", '.
				'fldLastName="'.$this->lastName.'", '.
				'fldFirstName2="'.$this->firstName2.'", '.
				'fldLastName2="'.$this->lastName2.'", '.
				'fldStreetAddr="'.$this->streetAddr.'", '.
				'fldTown="'.$this->town.'", '.
				'fldZip="'.$this->zip.'", '.
				'fldRegion="'.$this->region.'", '.
				'fldHPhone="'.$this->homePhone.'", '.
				'fldWPhone="'.$this->workPhone.'", '.
				'fldCPhone="'.$this->cellPhone.'", '.
				'fldPhone="'.$this->phone.'", '.
				'fldPrimaryPhone="'.$this->primaryPhone.'", '.
				'fldEmail="'.$this->email.'", '.
				'fldAltEmail="'.$this->altEmail.'", '.
				'fldIsActive='.$this->isActive.', '.
				'fldHasChildren='.$this->hasChildren.', '.
				'fldHasCats='.$this->hasCats.', '.
				'fldHasDogs='.$this->hasDogs.', '.
				'fldSmokingHouse='.$this->smokingHouse.', '.
				'fldSmokingAllowed='.$this->smokingAllowed.', '.
				'fldSinglesAllowed='.$this->singlesAllowed.', '.
				'fldMax='.$this->max.', '.
				'fldRooms='.$this->rooms.', '.
				'fldSingleBeds='.$this->singleBeds.', '.
				'fldDoubleBeds='.$this->doubleBeds.', '.
				'fldStartDate="'.$this->startDate.'", '.
				'fldPrefMen='.$this->prefMen.', '.
				'fldPrefWomen='.$this->prefWomen.', '.
				//'fkPartnerID='.$this->partnerID.', '.
				//'fldPartner="'.$this->partner.'", '.
				'fldDirections="'.$this->directions.'", '.
				'fldNotes="'.$this->notes.'"';				
		return $query;
	}
	
	//selects the specified record from the database
	function selectID($id){
		$query = 'SELECT * FROM tblHost WHERE pkHostID='.$id;
		return $query;
	}
	
	function selectNames(){
		$query = 'SELECT pkHostID, fldFirstName, fldLastName FROM tblHost ORDER BY fldLastName ASC, fldFirstName ASC';
		return $query;
	}
	
	function selectActiveHosts(){
		$q = 'SELECT pkHostID, fldFirstName, fldLastName FROM tblHost WHERE fldIsActive=1 ORDER BY fldLastName ASC, fldFirstName ASC';
		return $q;
	}
	
	function add(){
		$query = 'INSERT INTO tblHost SET '.$this->fields();
		return $query;	
	}
	
	function update(){
		$query = 'UPDATE tblHost SET '.$this->fields().' WHERE pkHostID='.$this->hostID;
		return $query;
	}
	
	function delete($id){
		$query = 'DELETE FROM tblHost WHERE pkHostID='.$id;
		return $query;
	}
	
	function buildList($r){
		$list = '<ul id="recordlist">'."\n";
		$data = mysql_fetch_assoc($r);
		while($data){
			$list .= "\t".'<li class="record"><a href="'.$_SERVER['PHP_SELF'].'?id='.$data['pkHostID'].'">'.
			$data['fldLastName'].', '.$data['fldFirstName'].'</a></li>'."\n";
			$data = mysql_fetch_assoc($r);
		}
		$list .= '</ul>'."\n";
		return $list;
	}
	
	function buildView(){
		$add = '<li><a href="'.$_SERVER['PHP_SELF'].'">Add New Host</a></li>';
		$update = '<li><a href="'.$_SERVER['PHP_SELF'].'?action=update&id='.$this->hostID.'">Edit Host</a></li>';
		$text = '<ul>'.$add.$update.'</ul>';
		$text .= $this->getValues();
		return $text;
	}
	
	function buildEdit(){
		$text = '<p><a href="'.$_SERVER['PHP_SELF'].'?action=update&id='.$this->hostID.'">Edit Host</a></p>';
		return $text;
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
		
	
	function getValues(){
		$text = 'Host ID: '.$this->hostID.'<br/>'.
			 'First Name: '.$this->firstName.'<br/>'.
			 'Last Name: '.$this->lastName.'<br/>'.
			 'First Name 2: '.$this->firstName2.'<br/>'.
			 'Last Name 2: '.$this->lastName2.'<br/>'.
			 'Street Address: '.$this->streetAddr.'<br/>'.
			 'Town: '.$this->town.'<br/>'.
			 'Zip: '.$this->zip.'<br/>'.
			 'Region: '.$this->region.'<br/>'.
			 'Home Phone: '.$this->homePhone.'<br/>'.
			 'Work Phone'.$this->workPhone.'<br/>'.
			 'Cell Phone'.$this->cellPhone.'<br/>'.
			 'Primary Phone'.$this->primaryPhone.'<br/>'.
			 'Primary Phone'.$this->phone.'<br/>'.
			 'Email: '.$this->email.'<br/>'.
			 'Alternate Email: '.$this->altEmail.'<br/>'.
			 'Is Active: '.$this->isActive.'<br/>'.
			 //'Has Children: '.$this->hasChildren.'<br/>'.
			 'Has Cats: '.$this->hasCats.'<br/>'.
			 'Has Dogs: '.$this->hasDogs.'<br/>'.
			 'Smoking House: '.$this->smokingHouse.'<br/>'.
			 'Smoking Allowed: '.$this->smokingAllowed.'<br/>'.
			 'Unmarried Couples Allowed: '.$this->singlesAllowed.'<br/>'.
			 'Number of Guests Allowed: '.$this->max.'<br/>'.
			 'Number of Rooms: '.$this->rooms.'<br/>'.
			 'Number of Single Beds: '.$this->singleBeds.'<br/>'.
			 'Number of Double Beds: '.$this->doubleBeds.'<br/>'.
			 'Start Date: '.$this->startDate.' (YYYY-MM-DD)<br/>'.
			 'Prefers Men: '.$this->prefMen.'<br/>'.
			 'Prefers Women: '.$this->prefWomen.'<br/>'.
			 //'Partner ID(not implemented yet): '.$this->partnerID.'<br/>'.
			 //'Perner: '.$this->partner.'<br/>'.
			 'Directions: '.$this->directions.'<br/>'.
			 'Notes: '.$this->notes.'<br/>';
		return $text;
	}
	
	//sets the values of the object fields
	function setValues($r){
		$arr = mysql_fetch_assoc($r);
		$this->hostID = $arr['pkHostID'];
		$this->firstName = $arr['fldFirstName'];
		$this->lastName = $arr['fldLastName'];
		$this->firstName2 = $arr['fldFirstName2'];
		$this->lastName2 = $arr['fldLastName2'];
		$this->streetAddr = $arr['fldStreetAddr'];
		$this->town = $arr['fldTown'];
		$this->zip = $arr['fldZip'];
		$this->region = $arr['fldRegion'];
		$this->homePhone = $arr['fldHPhone'];
		$this->workPhone = $arr['fldWPhone'];
		$this->cellPhone = $arr['fldCPhone'];
		$this->phone = $arr['fldPhone'];
		$this->primaryPhone = $arr['fldPrimaryPhone'];
		$this->email = $arr['fldEmail'];
		$this->altEmail = $arr['fldAltEmail'];
		$this->isActive = $arr['fldIsActive'];
		//$this->hasChildren = $arr['fldHasChildren'];
		$this->hasCats = $arr['fldHasCats'];
		$this->hasDogs = $arr['fldHasDogs'];
		$this->smokingHouse = $arr['fldSmokingHouse'];
		$this->smokingAllowed = $arr['fldSmokingAllowed'];
		$this->singlesAllowed = $arr['fldSinglesAllowed'];
		$this->max = $arr['fldMax'];
		$this->rooms = $arr['fldRooms'];
		$this->singleBeds = $arr['fldSingleBeds'];
		$this->doubleBeds = $arr['fldDoubleBeds'];
		$this->startDate = $arr['fldStartDate'];
		$this->prefMen = $arr['fldPrefMen'];
		$this->prefWomen = $arr['fldPrefWomen'];
		//$this->partnerID = $arr['fkPartnerID'];
		//$this->partner = $arr['fldPartner'];
		$this->directions = $arr['fldDirections'];
		$this->notes = $arr['fldNotes'];		
	}
	function display(){
		echo 'HostID: '.$this->hostID.'<br/>';
		echo 'FirstName: '.$this->firstName.'<br/>';
		echo 'LastName: '.$this->lastName.'<br/>';
		echo 'FirstName2: '.$this->firstName2.'<br/>';
		echo 'LastName2: '.$this->lastName2.'<br/>';
		echo 'StreetAddr: '.$this->streetAddr.'<br/>';
		echo 'Town: '.$this->town.'<br/>';
		echo 'Zip: '.$this->zip.'<br/>';
		echo 'Region: '.$this->region.'<br/>';
		echo 'HomePhone: '.$this->homePhone.'<br/>';
		echo 'WorkPhone: '.$this->workPhone.'<br/>';
		echo 'CellPhone: '.$this->cellPhone.'<br/>';
		echo 'Primary Phone: '.$this->primaryPhone.'<br/>';
		echo 'Email: '.$this->email.'<br/>';
		echo 'AltEmail: '.$this->altEmail.'<br/>';
		//echo 'HasChildren: '.$this->hasChildren.'<br/>';
		echo 'HasCats: '.$this->hasCats.'<br/>';
		echo 'HasDogs: '.$this->hasDogs.'<br/>';
		echo 'SmokingHouse: '.$this->smokingHouse.'<br/>';
		echo 'SmokingAllowed: '.$this->smokingAllowed.'<br/>';
		echo 'SinglesAllowed: '.$this->singlesAllowed.'<br/>';
		echo 'Max Allowed:'.$this->max.'<br/>';
		echo 'Rooms: '.$this->rooms.'<br/>';
		echo 'SingleBeds: '.$this->singleBeds.'<br/>';
		echo 'DoubleBeds: '.$this->doubleBeds.'<br/>';
		echo 'StartDate: '.$this->startDate.'<br/>';
		echo 'PrefMen: '.$this->prefMen.'<br/>';
		echo 'PrefWomen: '.$this->prefWomen.'<br/>';
		//echo 'PartnerID: '.$this->partnerID.'<br/>';
		//echo 'Partner: '.$this->partner.'<br/>';
		echo 'Directions: '.$this->directions.'<br/>';
		echo 'Notes: '.$this->notes.'<br/>';
	}
}
?>