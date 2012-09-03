<?php
//Supporting class for all operations related to the HostEvent table
class HostEvent{
	
	var $type = 'HostEvent';
	
	//fields	
	var $hostID;
	var $eventID;
	var $isActive;
	var $freeTixReq;
	var $halfPrTixReq;
	var $fullPrTixReq;
	var $reason;
	var $notes;
	
	
	function add(){
		$query = "INSERT INTO HostEvent 
				(fkHostID,fkEventID,fldIsActive,
				fldFreeTixReq,fldHalfPrTixReq,
				fldFullPrTixReq,fldReason,fldNotes) VALUES 
				($hostID,$eventID,$isActive,$freeTixReq,
				$halfPrTixReq,$fullPrTixReq,$reason,$notes)";
		return $query;
	}


	function display(){
		echo 'HostID: '.$hostID.'<br/>';
		echo 'EventID: '.$eventID.'<br/>';
		echo 'IsActive: '.$isActive.'<br/>';
		echo 'FreeTixReq: '.$freeTixReq.'<br/>';
		echo 'HalfPriceTixReq: '.$halfPrTixReq.'<br/>';
		echo 'FullPriceTixReq: '.$fullPrTixReq.'<br/>';
		echo 'Reason: '.$reason.'<br/>';
		echo 'Notes: '.$notes.'<br/>';
	}
}

?>