<?php
class HEForm extends Form{

	var $type = 'HEForm';
	var $id;
	var $hostList;
	var $activeList = array('Yes' => 1, 'No' => 0);
	
	
	function HEForm(){
		parent::Form('post');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
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
	
	function getHost(){
		if(isset($this->globalArr['host'])){
			return $this->globalArr['host'];
		}
		else{die('<p>Error: Could not get the id of the host</p>');}
	}
	
	function getUpdateData(){
		$data = array();
		$count = $this->globalArr['count'];
		for($i=0;$i<$count;$i++){
			if((int)$this->globalArr['select'.$i] == 1){
				$row = array();
				if($this->getNumeric('freetix'.$i) == -1){
					$row['he_freeTix'] = -1;
				}else{
					$row['he_freeTix'] = $this->sanitize('freetix'.$i);
				}
				if($this->getNumeric('halftix'.$i) == -1){
					$row['he_halfTix'] = -1;
				}else{
					$row['he_halfTix'] = $this->sanitize('halftix'.$i);
				}
				if($this->getNumeric('fulltix'.$i) == -1){
					$row['he_fullTix'] = -1;
				}else{
					$row['he_fullTix'] = $this->sanitize('fulltix'.$i);
				}				
				$row['he_hostID'] = $this->globalArr['host'.$i];
				$row['he_isActive'] = $this->globalArr['isactive'.$i];
				if(!$this->validateGeneric('notes'.$i)){
					$row['he_notes'] =  ' ';
				}else{
					$row['he_notes'] = $this->sanitize('notes'.$i);
				}
				$data[] = $row;
			}
		}
		return $data;
	}
	
	function getSelected(){
		//echo '<p>Getting ids to delete</p>'; 
		$data = array();
		$count = $this->globalArr['count'];
		for($i=0;$i<$count;$i++){
			//echo '<p>count: '.$i.', '.$this->globalArr['delete'.$i].'</p>';
			if((int)$this->globalArr['select'.$i] == 1){
				$data[] = $this->globalArr['host'.$i];
			}
		}
		return $data;
	}
	
	
		
	function makeHEForm($data){
		$counter =  count($data);
		$form = "\n".'<form action="'.$_SERVER['PHP_SELF'].'?id='.$this->id.'" method="post">'."\n".
			 '<fieldset id="addhost">'."\n".
				'<span id="hlist">Host: </span>'."\n".
				$this->makeListS('host',$this->hostList,-1)."\n".
				$this->makeSubmit('add','Add').
				'</fieldset>';
		$form .= '<fieldset>'."\n".
				$this->makeHidden('count',$counter)."\n".
				$this->makeSubmit('update','Update Checked')."\n".
				$this->makeSubmit('deletechecked','Delete Checked')."\n".
				'</fieldset>'."\n";
		$form .= '<fieldset>'."\n".
				'<table border="1">'."\n".
					'<tr>'."\n".
						'<th>Select: <input type="checkbox" name="sAll" onclick="selectAll(this)"/></th>'."\n".
						'<th>Host</th>'."\n".
						'<th>Active</th>'."\n".
						'<th>Free Tix</th>'."\n".
						'<th>Half Price Tix</th>'."\n".
						'<th>Full Price Tix</th>'."\n".
						'<th>Notes</th>'."\n".
					'</tr>'."\n";
		//generate dynamic fields
		$i = $counter;
		foreach($data as $row){
			$row['he_freeTix'] = str_replace('-1','',$row['he_freeTix']);
			$row['he_halfTix'] = str_replace('-1','',$row['he_halfTix']);
			$row['he_fullTix'] = str_replace('-1','',$row['he_fullTix']);
			$num = $counter - $i;
			$form .= '<tr>'."\n".
					'<td>'."\n".
					$this->makeCheck('select'.$num,'1',0)."\n".
					$this->makeHidden('host'.$num,$row['h_hostID'])."\n".
					'</td>'."\n".
					'<td>'."\n".$row['h_firstName'].' '.$row['h_lastName'].'</td>'."\n".
					'<td>'."\n".$this->makeListS('isactive'.$num,$this->activeList,$row['he_isActive'])."\n".'</td>'."\n".
					//'<td>'."\n".$this->makeCheck('isactive'.$num,'1',$row['he_isActive'])."\n".'</td>'."\n".
					'<td>'."\n".$this->makeText('freetix'.$num,$row['he_freeTix'],0)."\n".'</td>'."\n".
					'<td>'."\n".$this->makeText('halftix'.$num,$row['he_halfTix'],0)."\n".'</td>'."\n".
					'<td>'."\n".$this->makeText('fulltix'.$num,$row['he_fullTix'],0)."\n".'</td>'."\n".
					'<td>'."\n".$this->makeTextArea('notes'.$num,$this->stripChars($row['he_notes']),3,12)."\n".'</td>'."\n".
					'</tr>'."\n";
					$i--;
		}
		$form .= '</table>'."\n".'</fieldset>'."\n".
			'</form>'."\n";
		return $form;
	}
	

}
?>