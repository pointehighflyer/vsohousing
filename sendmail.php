<?php //send mail
session_start();
include('inc/lib/Form.php');
include('inc/lib/MailForm.php');
include('inc/lib/MEDatabase.php');
include('inc/lib/Event.php');
include('inc/lib/DBManager.php');
include('inc/lib/misc.php');


//session vars:
//stage;
//hdr[to,bcc,msg1,msg2]
//index;
//init;
//info;
//count;
//event;
$form = new MailForm();
$dbHandler = new DBManager();
$dbEvent = new Event();
$dbME = new MEDatabase();

if(!isset($_SESSION['stage'])){
	$_SESSION['stage'] = 1;
}

//first check whether form is in stage1 or stage2
//if stage1
if($_SESSION['stage'] == 1){
	//load events list from db
	$q = $dbEvent->selectTitles();
	$r = $dbHandler->query($q);
	$form->eventList = $dbEvent->getTitles($r);
	//if submitted
	if($form->submitted()){
		$form->checkStage1();
		if($form->hasError()){
			$errList = $form->makeErrList();
			$text = $form->makeStage1();
		}//end if
		else{
			//save text in message part 1 and message part 2
			//set to stage 2
			$_SESSION['hdr'] = $form->getHeaders();
			$_SESSION['stage'] = 2;
			$_SESSION['event'] = $form->getEvent();
		}//end else
	}//end if
	else{
		//form wasn't submitted (but still in stage1)
		//display
		$text = $form->makeStage1();
	}//end else
}//end if

//if stage2
if($_SESSION['stage'] == 2){
	if($form->reset()){
		$_SESSION = array();
		$text = 'form reset';
		//break;
	}
	else{
		//if submitted
		if($form->submitted2()){
			$form->checkStage2();
			if($form->hasError()){
				$errList = $form->makeErrList();
				$text = $form->makeStage2();
			}//end if
			else{
				//build message and send
				if($form->sendMail()){
					//echo 'Mail sent...';
				}//end if
				else{
					//echo 'Error sending...';
				}//end else
				//update index
				$_SESSION['index']++;
			}//end else
		}//end if
		//if all mail was sent (index == count)
		if($_SESSION['index'] == $_SESSION['count'] && $_SESSION['init'] == 1){
			//finished!
			$text = 'All mail sent';
			//unset ALL session vars
			$_SESSION = array();
		}//end if
		else{//not finished
			//if just starting
			if($_SESSION['init'] == 0){
				//load info from db and store
				$q = $dbME->getMailInfo($_SESSION['event']);
				$r = $dbHandler->query($q);
				$_SESSION['info'] = $dbME->getData($r);
				$_SESSION['hosts'] = array();
				$tmp = array();
				foreach($_SESSION['info'] as $row){
					$tmp[] = $row['me_hostID'];
					$_SESSION['hosts'][] = $row['h_firstName'].' '.$row['h_lastName'];
				}
				$_SESSION['hosts'] = array_unique($_SESSION['hosts']);
				$_SESSION['dupe'] = array_count_values($tmp);
				//count numer of rows and save
				$_SESSION['count'] = count($_SESSION['info']);
				//set index to 0
				$_SESSION['index'] = 0;
				//set init
				$_SESSION['init'] = 1;
			}//end if
			
			//build list
			$uList = '<ul class="maillist">'."\n";
			for($i=0;$i<$_SESSION['count'];$i++){
				$uList .= '<li>'.$_SESSION['hosts'][$i].'</li>'."\n";
			}//end for
			$uList .= '</ul>'."\n";
			
			//autofill fields with values of current index
			$_SESSION['hdr']['to'] = $_SESSION['info'][$_SESSION['index']]['h_email'];
			
			//make dynamic info
			$dyn = array();
			//$dyn = 'First Name      Last Name      Arrival Date      Time'."\n";
			$nRows = $_SESSION['dupe'][$_SESSION['info'][$_SESSION['index']]['me_hostID']];
			$cIndex = $_SESSION['index'];
			$j = 0;
			for($i=$cIndex;$i<($cIndex+$nRows);$i++){
				$dyn[$j] = array();
				$dyn[$j]['m_firstName'] = $_SESSION['info'][$i]['m_firstName'];
				$dyn[$j]['m_lastName'] = $_SESSION['info'][$i]['m_lastName'];
				$dyn[$j]['me_startDate'] = parseDate($_SESSION['info'][$i]['me_startDate']);
				$dyn[$j]['time'] = $_SESSION['hdr']['time'];
				//$dyn .= "\n".$_SESSION['info'][$i]['m_firstName'].
				//	'      '.$_SESSION['info'][$i]['m_lastName'].
				//	'      '.parseDate($_SESSION['info'][$i]['me_startDate']).
				//	'      '.$_SESSION['hdr']['time'];
				$j = ($i - $cIndex) + 1;
			}
			//echo $dyn;
			$_SESSION['index'] = $_SESSION['index'] + ($nRows - 1);
			$_SESSION['hdr']['dyn'] = $dyn;
			
			//set greeting based on host(s) names
			if($_SESSION['info'][$_SESSION['index']]['h_firstName2'] != ''){
				$greet = $_SESSION['info'][$_SESSION['index']]['h_firstName'].
						' & '.$_SESSION['info'][$_SESSION['index']]['h_firstName2'];
			}
			else{
				$greet = $_SESSION['info'][$_SESSION['index']]['h_firstName'];
			}
			$_SESSION['hdr']['greet'] = $greet;
			$_SESSION['hdr']['lbl'] = $greet.' '.$_SESSION['info'][$_SESSION['index']]['h_lastName'];
			$form->setHeaders($_SESSION['hdr']);
			//display
			$text = $form->makeStage2($dyn);	
		}//end else
	}
}//end if
//print_r($_SESSION);
//echo $uList;
//echo $errList;
//echo $text;
include('inc/head.php');
?>
<body>
<div id="wrapper">
	<div id="header">
		<img src="images/vermont.gif" alt="Vermont Symphony Orcherstra" />
		<h1>Musician Housing Program</h1>
		<div id="navbar">
			<?php include('inc/nav.php');?>
		</div>
	</div>
	<div id="main">
		<div id="content">
			<div id="leftcol">
				<?php echo $uList;?>
			</div>
			<div id="rightcol">
				<h2>Send Mail</h2>
				<?php echo $errList;
					  echo $text;
				?>
			</div>		
		</div>
	</div>
<?php include('inc/footer.php');?>
