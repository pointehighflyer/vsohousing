<?php
session_start();
include('inc/lib/shared.php');
include('inc/lib/Form.php');
include('inc/lib/Musician.php');
include('inc/lib/Event.php');
include('inc/lib/Host.php');
include('inc/lib/EventForm.php');
include('inc/lib/MEForm.php');
include('inc/lib/MEDatabase.php');
include('inc/lib/HEDatabase.php');
include('inc/lib/DBManager.php');
$form = new EventForm();
$dbHandler = new DBManager();
$dbObject = new Event();
$meDatabase = new MEDatabase();
$heDatabase = new HEDatabase();

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
		$text = '<p>Form was submitted successfully.</p>'.getEvent($arr);
		unload($arr,$dbObject);
		//$dbObject->display();
		if(isset($_SESSION['update'])){
			$q = $dbObject->update();
			$r = $dbHandler->query($q);
			$getID = $arr['e_eventID'];
			$_SESSION['result'] = '<p>Record has been updated.</p>';
			//echo $q;
			unset($_SESSION['update']);
			$dupeCheck = 0;
		}
		else{
			$q = $dbObject->add();
			$r = $dbHandler->query($q);
			$_SESSION['result'] = '<p>Record has been added.</p>';
			$getID = mysql_insert_id();
			$dupeCheck = 1;
		}		
		if($r == 1062 && $dupeCheck == 1){
			$_SESSION['result'] = '<p>Duplicate record.</p>'.$form->makeForm();
			$text = $_SESSION['result'];
			unset($_SESSION['result']);
		}
		else{
			header('Status: 303');
			header('Location: '.$_SERVER['PHP_SELF'].'?id='.$getID);
		}
	}
}
elseif($form->delete()){
	if($form->deleteCheck()){
		$q = $dbObject->delete($form->getID());
		$r = $dbHandler->query($q);
		$q = $meDatabase->clearEvent($form->getID());
		$r = $dbHandler->query($q);
		$q = $heDatabase->clearEvent($form->getID());
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
		//inititalize objects for event specific functionality
		$meForm = new MEForm();
		
		//echo '<p>ID is set</p>';
		$q = $dbObject->selectID($_GET['id']);
		$r = $dbHandler->query($q);
		$dbObject->setValues($r);
		$arr = array();
		load($arr,$dbObject);
		if($_GET['action'] == 'update'){
			$form->mode = 'update';
			//echo '<p>making the update form</p>';
			//echo 'update<br/>';
			unload($arr,$form);
			//$form->make();
			$text = $form->makeForm();
			$_SESSION['update'] = 1;
		}
		else{//not updating, just displaying info with links
			//echo 'building list<br/>';
			//echo '<p>ID is set but just display</p>';
			$text = $_SESSION['result'].getEvent($arr);
			unset($_SESSION['result']);
			$editLink = $dbObject->buildEdit();
			
			//setup the the form to add musicians to events
			
			//check if any buttons were pressed and act accordingly
			/*if($meForm->isAdd()){
				//echo '<p>Adding Musician</p>';
				$musician = $meForm->getMusician();
				$q = $meDatabase->addMusician($musician,$arr['e_arrivalDate'],$arr['e_date'],-1);
				$r = $dbHandler->query($q);
			}
			elseif($meForm->isUpdate()){
				$data = $meForm->getUpdateData();
				foreach($data as $row){
					$q = $meDatabase->updateMusician($row);
					$r = $dbHandler->query($q);
				}
			}
			elseif($meForm->isDelete()){
				//echo '<p>delete</p>';
				$data = $meForm->getSelected();
				foreach($data as $id){
					$q = $meDatabase->deleteMusician($id);
					$r = $dbHandler->query($q);
				}
				//print_r($data);
			}
			elseif($meForm->isMatch()){
				//select musicians, join primary host + criteria <--an array
				$q = $meDatabase->getMusicianInfo();
				$r = $dbHandler->query($q);
				$musicianData = $meDatabase->getData($r);
				
				//select host ID's + criteria for matching <--another array
				$q = $meDatabase->getHostInfo();
				$r = $dbHandler->query($q);
				$hostData = $meDatabase->getData($r);
				
				//get all the selected musicians
				$count = array_count_values($meForm->getSelected());
				
				//for each musician
				foreach($musicianData as $m){
					if($count[$m['me_musicianID']] > 0){
						//if primaryHost != -1 (unspecified) && host is active
						//host set to primary, finished
						//(just set it in the same array and pass it to the update routine, easier that way)
						if($m['m_primaryHost'] != -1 && $m['h_isActive'] == 1){
							$m['me_hostID'] = $m['m_primaryHost'];
							$m['me_match'] = 'Primary Host';
						}
						//else select active host for most recent event in 3 yrs
						//if success match them to that host, finished
						else{
							$endDate = date('Y-m-d',strtotime($arr['e_date']));
							$startDate = date('Y-m-d',strtotime('-3 year',strtotime($endDate)));
							$q = $meDatabase->getMatchHistory($m['me_musicianID'],$startDate,$endDate);
							$r = $dbHandler->query($q);
							$hostID = $meDatabase->getHistoryMatch($r);
							if($hostID != 0){
								$m['me_hostID'] = $hostID;
								$m['me_match'] = 'History';
							}						
							//else match by criteria
							//select an active host from table (filtering through SQL statement) 
							//or just look in the 2nd array above?
							//(no filtering but only run it once)
							//either case match on first possible, finished
							else{
								foreach($hostData as $h){
									//longest if statement I've ever written
									if((($m['m_allrgSmoke'] == 1 && $h['h_smokingHouse'] == 0) || $m['m_allrgSmoke'] == 0) 
										&& (($m['m_allrgCats'] == 1 && $h['h_hasCats'] == 0) || $m['m_allrgCats'] == 0) 
										&& (($m['m_allrgDogs'] == 1 && $h['h_hasDogs'] == 0) || $m['m_allrgDogs'] == 0)){
											$m['me_hostID'] = $h['h_hostID'];
											$m['me_match'] = 'Criteria';
											break;
									}//end if
								}//end foreach
							}//end else
						}//end else
						//update the record
						$q = $meDatabase->updateMatch($m);
						$r = $dbHandler->query($q);
					}//end if
				}//end foreach
			}//end elseif
			//load the musician form	
			$m = new Musician();
			$h = new Host();
			$q = $meDatabase->selectMusicians();
			$r = $dbHandler->query($q);
			$arr = $meDatabase->getData($r);
			$q = $m->selectNames();
			$r = $dbHandler->query($q);
			$meForm->musicianList = $m->getNameArray($r);
			$q = $h->selectNames();
			$r = $dbHandler->query($q);
			$meForm->hostList = $h->getNameArray($r);
			$formText = $meForm->makeMEForm($arr);*/
			
		}	
	//test the report table
	/*$q = $meDatabase->getReportInfo();
	$r = $dbHandler->query($q);
	$data = $meDatabase->getData($r);
	$table  = $meForm->makeReport($data);*/
	}
	else{
		//displaying a blank form
		
		//unset session var in case user clicked link for blank form before
		//completing an update, otherwise it will try to run an update
		//query on next error free submission and blow up
		unset($_SESSION['update']);
		
		load($arr,$dbObject);
		unload($arr,$form);
		$text = $form->makeForm();
	}
}

//make the list
$q = $dbObject->selectTitles();
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
			<h2>Event Management</h2>
				<?php echo $editLink;
					  echo $errorList;
					  echo $text;
				?>
			<div id="dynamiccontent">
				<?php echo $formText;
					echo $table;
				?>	
		</div>
			</div>
			</div>
	</div>
<?php include('inc/footer.php');?>