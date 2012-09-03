<?php
session_start();
include('inc/lib/shared.php');
include('inc/lib/Form.php');
include('inc/lib/Musician.php');
include('inc/lib/Host.php');
include('inc/lib/MusicianForm.php');
include('inc/lib/DBManager.php');
include('inc/lib/MEForm.php');
include('inc/lib/MEDatabase.php');
$form = new MusicianForm();
$dbHandler = new DBManager();
$dbObject = new Musician();
$dbHost = new Host();
$meForm = new MEForm();
$meDatabase = new MEDatabase();

$qHost = $dbHost->selectNames();
$r1 = $dbHandler->query($qHost);
$form->hostList = $dbHost->getNameArray($r1);
//process the form
if($form->submitted()){
	//echo 'validating';
	$form->validate();
	if($form->errorStatus){
		//redisplay the form with errors
		$errorList = $form->makeErrList();
		$text = $form->makeForm();
		//echo $list;
	}
	else{//no errors!
		$arr = array();
		load($arr,$form);
		unload($arr,$dbObject);
		$text = '<p>Form was submitted successfully.</p>'.getMusician($arr);
		//$dbObject->display();
		if(isset($_SESSION['update'])){
			$q = $dbObject->update();
			$r = $dbHandler->query($q);
			$getID = $arr['m_musicianID'];
			$_SESSION['result'] = '<p>Record has been updated.</p>';
			//echo $q;
			unset($_SESSION['update']);
			$dupeCheck = 0;
		}
		else{
			$q = $dbObject->add();
			$r = $dbHandler->query($q);	
			$getID = mysql_insert_id();
			$_SESSION['result'] = '<p>Record has been added.</p>';
			$dupeCheck = 1;
		}
		if($r == 1062 && $dupeCheck == 1){
			$_SESSION['result'] = '<p>Duplicate record.</p>'.$form->makeForm();
			$text = $_SESSION['result'];
			unset($_SESSION['result']);
		}
		else{
			header('Status: 303');
			header('Location: '.$_SERVER['PHP_SELF'].'?id='.$getID."#".$getID);
		}
	}
}
elseif($form->delete()){
	if($form->deleteCheck()){
		$q = $dbObject->delete($form->getID());
		$r = $dbHandler->query($q);
		$q = $meDatabase->clearMusician($form->getID());
		$r = $dbHandler->query($q);
		$text = 'Record deleted';
	}
	else{
		$errorList = 'You must check the box in order to delete this record';
		$form->validate(); //so the values are passed back correctly
		$text = $form->makeForm();
	}
}
else{//form not submitted
	//echo 'Form not submitted';
	//perform update check and set values if ncessary, otherwise just do a blank form
	if(isset($_GET['id'])){
		$q = $dbObject->selectID($_GET['id']);
		//echo $q;
		$r = $dbHandler->query($q);
		$dbObject->setValues($r);
		//$dbObject->display();
		$arr = array();
		load($arr,$dbObject);
		if($_GET['action'] == 'update'){
			$form->mode = 'update';
			//echo 'update<br/>';
			unload($arr,$form);
			//$form->make();
			$text = $form->makeForm();
			$_SESSION['update'] = 1;
		}
		else{//not updating, just displaying info with links
			//get musician's history
			//$q = $meDatabase->getMusicianHst($arr['m_musicianID']);
			//$r =  $dbHandler->query($q);
			//get ALL records -> data
			$q = $meDatabase->selectAllHst();
			$r = $dbHandler->query($q);
			$data = $meDatabase->getData($r);
			$list = array();
			//pull out all matching m id ->
			foreach($data as $row){
				if($row['me_musicianID'] == $arr['m_musicianID']){
					//$list[] = $row;
					foreach($data as $subRow){
						if($subRow['me_hostID'] == $row['me_hostID'] && $subRow['me_eventID'] == $row['me_eventID']){
							$temp .= ', '.$subRow['m_firstName'].' '.$subRow['m_lastName'];
							//$list[] = $subRow;
						}
					}
					$temp = preg_replace('/^,/','',$temp);
					$row['musicians'] = $temp;
					$list[] = $row;
					$temp = '';
				}
			}
			//via: http://stackoverflow.com/questions/307674/how-to-remove-duplicate-values-from-a-multi-dimensional-array-in-php
			//$list = array_map("unserialize", array_unique(array_map("serialize", $list)));
           
			$history = $meForm->makeMusicianHst($list);
			
			
			//echo 'building list<br/>';
			$text = $_SESSION['result'].getMusician($arr);
			unset($_SESSION['result']);
			$editLink = $dbObject->buildEdit();
		}	
	}
	else{
		load($arr,$dbObject);
		unload($arr,$form);
		$text = $form->makeForm();
	}
}

//make the list
$q = $dbObject->selectNames();
$r = $dbHandler->query($q);
$list = $dbObject->buildList($r);


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
				<?php echo $list;?>
			</div>
			<div id="rightcol">
			<h2>Musician Management</h2>
				<?php echo $editLink;
					  echo $errorList;
					  echo $text;
				?>
			<div id="dynamiccontent">
				<?php echo $history;?>	
		</div>
			</div>		
		</div>
	</div>
<?php include('inc/footer.php');?>