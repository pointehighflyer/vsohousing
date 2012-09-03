<?php
//Supporting class for all operations related to the Host table
class Host{
	
	var $type = 'Host';
	
	//fields
	var $hostID;
	var $firstName;
	var $lastName;
	var $streetAddr;
	var $town;
	var $zip;
	var $homeTown; 
	var $homePhone;
	var $workPhone;
	var $cellPhone;
	var $email;
	var $altEmail;
	var $isActive; //whoops!
	var $hasChildren;
	var $hasCats;
	var $hasDogs;
	var $smokingHouse;
	var $smokingAllowed;
	var $singlesAllowed;
	var $singleBeds;
	var $rooms;
	var $doubleBeds;
	var $startDate = '2011-01-01';//IMPLEMENT!!!
	var $prefMen;      //'YYYY-MM-DD'
	var $prefWomen;
	var $partnerID = 22; //IMPLEMENT!!!
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
				$streetAddr,$town,$zip,$homeTown,$homePhone,$workPhone,
				$cellPhone,$email,$altEmail,$hasChildren,$hasCats,$hasDogs,
				$smokingHouse,$smokingAllowed,$singlesAllowed,$singleBeds,
				$doubleBeds,$startDate,$prefMen,$prefWomen,$partnerID,$notes)";*/
		$query = 'fldFirstName="'.$this->firstName.'", '.
				'fldLastName="'.$this->lastName.'", '.
				'fldStreetAddr="'.$this->streetAddr.'", '.
				'fldTown="'.$this->town.'", '.
				'fldZip="'.$this->zip.'", '.
				'fldHTown="'.$this->homeTown.'", '.
				'fldHPhone="'.$this->homePhone.'", '.
				'fldWPhone="'.$this->workPhone.'", '.
				'fldCPhone="'.$this->cellPhone.'", '.
				'fldEmail="'.$this->email.'", '.
				'fldAltEmail="'.$this->altEmail.'", '.
				'fldIsActive='.$this->isActive.', '.
				'fldHasChildren='.$this->hasChildren.', '.
				'fldHasCats='.$this->hasCats.', '.
				'fldHasDogs='.$this->hasDogs.', '.
				'fldSmokingHouse='.$this->smokingHouse.', '.
				'fldSmokingAllowed='.$this->smokingAllowed.', '.
				'fldSinglesAllowed='.$this->singlesAllowed.', '.
				'fldRooms='.$this->rooms.', '.
				'fldSingleBeds='.$this->singleBeds.', '.
				'fldDoubleBeds='.$this->doubleBeds.', '.
				'fldStartDate="'.$this->startDate.'", '.
				'fldPrefMen='.$this->prefMen.', '.
				'fldPrefWomen='.$this->prefWomen.', '.
				'fkPartnerID='.$this->partnerID.', '.
				'fldNotes="'.$this->notes.'"';				
		return $query;
	}
	
	//selects the specified record from the database
	function selectID($id){
		$query = 'SELECT * FROM tblHost WHERE pkHostID='.$id;
		return $query;
	}
	
	function selectNames(){
		$query = 'SELECT pkHostID, fldFirstName, fldLastName FROM tblHost WHERE fldIsActive=1';
		return $query;
	}
	
	function add(){
		$query = 'INSERT INTO tblHost SET '.$this->fields();
		return $query;	
	}
	
	function update(){
		$query = 'UPDATE tblHost SET '.$this->fields().' WHERE pkHostID='.$this->hostID;
		return $query;
	}
	
	function buildList($r){
		$list = '<ul id="recordlist">';
		$data = mysql_fetch_assoc($r);
		while($data){
			$list .= '<li class="record"><a href="'.$_SERVER['PHP_SELF'].'?id='.$data['pkHostID'].'">'.
			$data['fldFirstName'].' '.$data['fldLastName'].'</a></li>';
			$data = mysql_fetch_assoc($r);
		}
		$list .= '</ul>';
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
		$arr = array();
		$data = mysql_fetch_assoc($r);
		while($data){
			echo $data['fldFirstName'],$data['fldLastName'],$data['pkHostID'];
			$arr[$data['fldFirstName'].' '.$data['fldLastName']] = $data['pkHostID'];
			$data = mysql_fetch_assoc($r);
		}
		print_r($arr);
		return $arr;
	}
		
	
	function getValues(){
		$text = 'Host ID: '.$this->hostID.'<br/>'.
			 'First Name: '.$this->firstName.'<br/>'.
			 'Last Name: '.$this->lastName.'<br/>'.
			 'Street Address: '.$this->streetAddr.'<br/>'.
			 'Town: '.$this->town.'<br/>'.
			 'Zip: '.$this->zip.'<br/>'.
			 'Home Town: '.$this->homeTown.'<br/>'.
			 'Home Phone: '.$this->homePhone.'<br/>'.
			 'Work Phone'.$this->workPhone.'<br/>'.
			 'Cell Phone'.$this->cellPhone.'<br/>'.
			 'Email: '.$this->email.'<br/>'.
			 'Alternate Email: '.$this->altEmail.'<br/>'.
			 'Is Active: '.$this->isActive.'<br/>'.
			 'Has Children: '.$this->hasChildren.'<br/>'.
			 'Has Cats: '.$this->hasCats.'<br/>'.
			 'Has Dogs: '.$this->hasDogs.'<br/>'.
			 'Smoking House: '.$this->smokingHouse.'<br/>'.
			 'Smoking Allowed: '.$this->smokingAllowed.'<br/>'.
			 'Unmarried Couples Allowed: '.$this->singlesAllowed.'<br/>'.
			 'Rooms: '.$this->rooms.'<br/>'.
			 'Single Beds: '.$this->singleBeds.'<br/>'.
			 'Double Beds: '.$this->doubleBeds.'<br/>'.
			 'Start Date: '.$this->startDate.' (YYYY-MM-DD)<br/>'.
			 'Prefers Men: '.$this->prefMen.'<br/>'.
			 'Prefers Women: '.$this->prefWomen.'<br/>'.
			 'Partner ID(not implemented yet): '.$this->partnerID.'<br/>'.
			 'Notes: '.$this->notes.'<br/>';
		return $text;
	}
	
	//sets the values of the object fields
	function setValues($r){
		$arr = mysql_fetch_assoc($r);
		$this->hostID = $arr['pkHostID'];
		$this->firstName = $arr['fldFirstName'];
		$this->lastName = $arr['fldLastName'];
		$this->streetAddr = $arr['fldStreetAddr'];
		$this->town = $arr['fldTown'];
		$this->zip = $arr['fldZip'];
		$this->homeTown = $arr['fldHTown'];
		$this->homePhone = $arr['fldHPhone'];
		$this->workPhone = $arr['fldWPhone'];
		$this->cellPhone = $arr['fldCPhone'];
		$this->email = $arr['fldEmail'];
		$this->altEmail = $arr['fldAltEmail'];
		$this->isActive = $arr['fldIsActive'];
		$this->hasChildren = $arr['fldHasChildren'];
		$this->hasCats = $arr['fldHasCats'];
		$this->hasDogs = $arr['fldHasDogs'];
		$this->smokingHouse = $arr['fldSmokingHouse'];
		$this->smokingAllowed = $arr['fldSmokingAllowed'];
		$this->singlesAllowed = $arr['fldSinglesAllowed'];
		$this->rooms = $arr['fldRooms'];
		$this->singleBeds = $arr['fldSingleBeds'];
		$this->doubleBeds = $arr['fldDoubleBeds'];
		$this->startDate = $arr['fldStartDate'];
		$this->prefMen = $arr['fldPrefMen'];
		$this->prefWomen = $arr['fldPrefWomen'];
		$this->partnerID = $arr['fkPartnerID'];
		$this->notes = $arr['fldNotes'];		
	}
	function display(){
		echo 'HostID: '.$this->hostID.'<br/>';
		echo 'FirstName: '.$this->firstName.'<br/>';
		echo 'LastName: '.$this->lastName.'<br/>';
		echo 'StreetAddr: '.$this->streetAddr.'<br/>';
		echo 'Town: '.$this->town.'<br/>';
		echo 'Zip: '.$this->zip.'<br/>';
		echo 'HomeTown(Region): '.$this->homeTown.'<br/>';
		echo 'HomePhone: '.$this->homePhone.'<br/>';
		echo 'WorkPhone: '.$this->workPhone.'<br/>';
		echo 'CellPhone: '.$this->cellPhone.'<br/>';
		echo 'Email: '.$this->email.'<br/>';
		echo 'AltEmail: '.$this->altEmail.'<br/>';
		echo 'HasChildren: '.$this->hasChildren.'<br/>';
		echo 'HasCats: '.$this->hasCats.'<br/>';
		echo 'HasDogs: '.$this->hasDogs.'<br/>';
		echo 'SmokingHouse: '.$this->smokingHouse.'<br/>';
		echo 'SmokingAllowed: '.$this->smokingAllowed.'<br/>';
		echo 'SinglesAllowed: '.$this->singlesAllowed.'<br/>';
		echo 'Rooms: '.$this->rooms.'<br/>';
		echo 'SingleBeds: '.$this->singleBeds.'<br/>';
		echo 'DoubleBeds: '.$this->doubleBeds.'<br/>';
		echo 'StartDate: '.$this->startDate.'<br/>';
		echo 'PrefMen: '.$this->prefMen.'<br/>';
		echo 'PrefWomen: '.$this->prefWomen.'<br/>';
		echo 'PartnerID: '.$this->partnerID.'<br/>';
		echo 'Notes: '.$this->notes.'<br/>';
	}
}
?>