<?php
class MailForm extends Form{


	var $state;
	var $msg1;
	var $msg2;
	var $to;
	var $bcc;
	var $subject;
	var $skip;
	var $name;
	var $hosts = 'Calvin & Hobbes';
	var $time;
	var $eventList;
	var $event = -1;
	var $status;
	var $errorList = array();
	
	
	function MailForm(){
		parent::Form('post');
	}
	
	function hasError(){
		return $this->status;
	}
	
	function submitted(){
		return isset($this->globalArr['submit']);
	}
	
	function submitted2(){
		return isset($this->globalArr['submit2']);
	}
	
	function reset(){
		return isset($this->globalArr['reset']);
	}
	
	function getEvent(){
		return $this->event;
	}
	
	function getHeaders(){
		$arr['to'] = $this->to;
		$arr['bcc'] = $this->bcc;
		$arr['subject'] = $this->subject;
		$arr['name'] = $this->name;
		$arr['time'] = $this->time;
		$arr['skip'] = $this->skip;
		$arr['msg1'] = $this->msg1;
		$arr['msg2'] = $this->msg2;
		return $arr;
	}
	
	function checkStage1(){
		if($this->globalArr['event'] == -1){
			$this->errorList[] = 'No event selected';
			$this->status = 1;
		}
		else{
			$this->event = $this->globalArr['event'];
		}
		if(!$this->validateGeneric('bcc')){
			$this->errorList[] = 'No BCC email specified';
			$this->status = 1;
		}
		else{
			$this->bcc = $this->sanitize('bcc');
		}
		if(!$this->validateGeneric('subject')){
			$this->errorList[] = 'No subject specified';
			$this->status = 1;
		}
		else{
			$this->subject = $this->sanitize('subject');
		}
		if(!$this->validateGeneric('name')){
			$this->errorList[] = 'No name entered';
			$this->status = 1;
		}
		else{
			$this->name = $this->sanitize('name');
		}
		$this->msg1 = $this->sanitize('msg1');
		$this->msg2 = $this->sanitize('msg2');
		$this->time = $this->sanitize('time');
		$this->skip = $this->globalArr['skip'];
		
	}
	
	function checkStage2(){
		if(!$this->validateGeneric('to')){
			$this->errorList[] = 'No email specified';
			$this->status = 1;
		}
		else{
			$this->to = $this->sanitize('to');
		}
		if(!$this->validateGeneric('bcc')){
			$this->errorList[] = 'No BCC email specified';
			$this->status = 1;
		}
		else{
			$this->bcc = $this->sanitize('bcc');
		}
		if(!$this->validateGeneric('subject')){
			$this->errorList[] = 'No subject specified';
			$this->status = 1;
		}
		else{
			$this->subject = $this->sanitize('subject');
		}
		if(!$this->validateGeneric('name')){
			$this->errorList[] = 'No name entered';
			$this->status = 1;
		}
		else{
			$this->name = $this->sanitize('name');
		}
		$this->msg1 = $this->sanitize('msg1');
		echo $this->dMsg;
		$this->msg2 = $this->sanitize('msg2');
		$this->time = $this->sanitize('time');
		$this->skip = $this->globalArr['skip'];
		$this->greet = $this->globalArr['greet'];
		$count = $this->globalArr['count'];
		$this->dInfo = array();
		for($i=0;$i<$count;$i++){
			$row['m_firstName'] = $this->sanitize('first'.$i);
			$row['m_lastName'] = $this->sanitize('last'.$i);
			$row['me_startDate'] = $this->sanitize('date'.$i);
			$row['time'] = $this->sanitize('time'.$i);
			$this->dInfo[] = $row;
		}
	}
	
	
	function makeStage1(){
		$form = '<form action="'.$_SERVER['PHP_SELF'].'" method="post" class="form" id="mailform">' ."\n".
					'<fieldset>'."\n".
						'Event: '.$this->makeListS('event',$this->eventList,$this->event).'<span class="red">*</span> <br/>'."\n".
						'BCC: '.$this->makeText('bcc',$this->bcc,$this->status).'<span class="red">*</span>  Separate multiple emails with commas<br/>'."\n".
						'Subject: '.$this->makeText('subject',$this->subject,$this->status).'<span class="red">*</span> <br/>'."\n".
						'Arrival Time: '.$this->makeText('time',$this->time,$this->status).' <br/>'."\n".
						'Skip this host: '.$this->makeCheck('skip',1,$this->skip).'<br/>'."\n".
						'Opening Text<br/>'.$this->makeTextArea('msg1',$this->stripChars($this->msg1),8,60).'<br/>'."\n".
						'<p>Dynamic Content Here</p>'."\n".
						'Ending Text<br/>'.$this->makeTextArea('msg2',$this->stripChars($this->msg2),8,60).'<br/>'."\n".
						'Sincerely,<br/>'.$this->makeText('name',$this->name,$this->status).'<span class="red">*</span> <br/>'."\n".
						$this->makeSubmit('submit','Submit')."\n".
					'</fieldset>'."\n".
				'</form>';
		return $form;
				
	}
	
	function makeStage2(){
		$dContent = '<table border="1">'."\n".
			'<tr>'."\n".
				'<th>First Name</th>'."\n".
				'<th>Last Name</th>'."\n".
				'<th>Arrival Date</th>'."\n".
				'<th>Arrival Time</th>'."\n".
			'</tr>'."\n";
		$counter = 0;
		foreach($this->dyn as $row){
			$dContent .= '<tr>'."\n".
				'<td>'.$this->makeText('first'.$counter,$row['m_firstName'],$this->status).'</td>'."\n".
				'<td>'.$this->makeText('last'.$counter,$row['m_lastName'],$this->status).'</td>'."\n".
				'<td>'.$this->makeText('date'.$counter,$row['me_startDate'],$this->status).'</td>'."\n".
				'<td>'.$this->makeText('time'.$counter,$row['time'],$this->status).'</td>'."\n".
				'</tr>'."\n";
				$counter++;
		}
		$dContent .= '</table>'."\n";
		$form = '<form action="'.$_SERVER['PHP_SELF'].'" method="post" class="form" id="mailform">' ."\n".
					'<fieldset>'."\n".
						'<p>Sending Mail to '.$this->lbl.'</p>'."\n".
						'To: '.$this->makeText('to',$this->to,$this->status).'<br/>'."\n".
						'BCC: '.$this->makeText('bcc',$this->bcc,$this->status).' Separate multiple emails with commas<br/>'."\n".
						'Subject: '.$this->makeText('subject',$this->subject,$this->status).'<br/>'."\n".
						'Arrival Time: '.$this->makeText('time',$this->time,$this->status).'<br/>'."\n".
						'Skip this host: '.$this->makeCheck('skip',1,$this->skip).'<br/><br/>'."\n".
						'Dear '.$this->greet.',<br/>'."\n".
						'Opening Text<br/>'.$this->makeTextArea('msg1',$this->stripChars($this->msg1),8,60).'<br/>'."\n".
						'Dynamic Content<br/>'.$dContent.'<br/>'."\n".
						//'Dynamic Content<br/>'.$this->makeTextArea('dmsg',$this->dMsg,8,60).'<br/>'."\n".
						'Ending Text<br/>'.$this->makeTextArea('msg2',$this->stripChars($this->msg2),8,60).'<br/>'."\n".
						'Sincerely,<br/>'.$this->makeText('name',$this->name,$this->status).'<br/>'."\n".
						$this->makeHidden('greet',$this->greet)."\n".
						$this->makeHidden('count',$counter)."\n".
						$this->makeSubmit('submit2','Send')."\n".
						$this->makeSubmit('reset','Reset')."\n".
					'</fieldset>'."\n".
				'</form>';
		return $form;	
	}
	
	function setHeaders($arr){
		$this->to = $arr['to'];
		$this->bcc = $arr['bcc'];
		$this->subject = $arr['subject'];
		$this->time = $arr['time'];
		$this->name = $arr['name'];
		$this->skip = $arr['skip'];
		$this->msg1 = $arr['msg1'];
		$this->msg2 = $arr['msg2'];
		$this->dyn = $arr['dyn'];
		$this->greet = $arr['greet'];
		$this->lbl = $arr['lbl'];
	}
	
	function sendMail(){
		$to = '<'.$this->to.'>';
		$subject = $this->subject;
		$msg = '<html>'."\n".
				'<body>'."\n".
				'<p>Dear '.$this->greet.',</p>'."\n".
				'<p>'.nl2br($this->stripChars($this->msg1)).'</p>'."\n".
				'<table border="0" style="text-align: left;">'."\n".
					'<tr>'."\n".
						'<th style="text-align:left;">First Name</th>'."\n".
						'<th style="text-align:left;">Last Name</th>'."\n".
						'<th style="text-align:left;">Arrival Date</th>'."\n".
						'<th style="text-align:left;">Arrival Time</th>'."\n".
					'</tr>'."\n";
		foreach($this->dInfo as $row){
			$msg .= '<tr>'."\n".
				'<td style="min-width:50px;">'.$row['m_firstName'].'</td>'."\n".
				'<td style="min-width:50px;">'.$row['m_lastName'].'</td>'."\n".
				'<td style="min-width:50px;">'.$row['me_startDate'].'</td>'."\n".
				'<td style="min-width:50px;">'.$row['time'].'</td>'."\n".
				'</tr>'."\n";
		}
		$msg .= '</table>'."\n".
				'<p>'.nl2br($this->stripChars($this->msg2)).'</p>'."\n".
				'Sincerely,<br/>'.$this->name.'</html>';
		$msg = wordwrap($this->stripChars($msg),70);
		$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html; charset=iso-8859-1'."\r\n".'From: '.$this->bcc."\r\n".'Reply-To: '.$this->bcc."\r\n"./*'CC: <'.$this->bcc.'>'."\r\n".*/'Bcc:'.$this->bcc."\r\n";
		if($this->skip != 1){
			if(mail($to,$subject,$msg,$headers)){
				return true;
			}
			else{
				return false;
			}
		}
	}
	
	function makeErrList(){
		$list = '<ul id="errorlist">';
		foreach ($this->errorList as $element){
			$list .= '<li>'.$element.'</li>';
		}
		$list .= '</ul>';
		return $list;
	}



}
?>