<?php
include('inc/lib/Event.php');
include('inc/lib/Form.php');
include('inc/lib/MEForm.php');
include('inc/lib/MEDatabase.php');
include('inc/lib/HEDatabase.php');
include('inc/lib/DBManager.php');
include('inc/lib/Host.php');
include('inc/lib/Musician.php');
include('inc/lib/shared.php');
$dbEvent = new Event();
$dbHandler = new DBManager();
$meDatabase = new MEDatabase();
$heDatabase = new HEDatabase();
$meForm = new MEForm();
$dbMusician = new Musician();
$dbHost = new Host();

if(!isset($_GET['id'])){
	$text = 'Pick an event from the list to view its planning panel';
}
else{
	$q = $dbEvent->selectID($_GET['id']);
	$r = $dbHandler->query($q);
	$dbEvent->setValues($r);
	$arr = array();
	load($arr,$dbEvent);
	$title = ' for '.$arr['e_title'].' '.parseDate($arr['e_date']);
	//check if any buttons were pressed and act accordingly
	if($meForm->isAdd()){
		//echo '<p>Adding Musician</p>';
		$musician = $meForm->getMusician();
		$q = $meDatabase->addMusician($musician,$arr['e_arrivalDate'],$arr['e_date'],-1);
		$r = $dbHandler->query($q);
		header('Status: 303');
		header('Location: '.$_SERVER['PHP_SELF'].'?id='.$_GET['id']);
	}
	elseif($meForm->isUpdate()){
		$data = $meForm->getUpdateData();
		foreach($data as $row){
			$q = $meDatabase->updateMusician($row);
			$r = $dbHandler->query($q);
			if($row['me_hostID'] != -1){
				$q = $heDatabase->addHost($row['me_hostID']);
				$r = $dbHandler->query($q);
			}
		}
		header('Status: 303');
		header('Location: '.$_SERVER['PHP_SELF'].'?id='.$_GET['id']);
	}
	elseif($meForm->isDelete()){
		//echo '<p>delete</p>';
		$data = $meForm->getSelected();
		foreach($data as $id){
			$q = $meDatabase->deleteMusician($id);
			$r = $dbHandler->query($q);
		}
		//print_r($data);
		header('Status: 303');
		header('Location: '.$_SERVER['PHP_SELF'].'?id='.$_GET['id']);
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
		header('Status: 303');
		header('Location: '.$_SERVER['PHP_SELF'].'?id='.$_GET['id']);
	}//end elseif
	//load the musician form	
	$q = $meDatabase->selectMusicians();
	$r = $dbHandler->query($q);
	$arr = $meDatabase->getData($r);
	$q = $meDatabase->selectRemainingMusicians();
	$r = $dbHandler->query($q);
	$meForm->musicianList = $dbMusician->getNameArray($r);
	$q = $dbHost->selectActiveHosts();
	$r = $dbHandler->query($q);
	$meForm->hostList = $dbHost->getNameArray($r);
	$text = $meForm->makeMEForm($arr);
}
//make the list
$q = $dbEvent->selectTitles();
$r = $dbHandler->query($q);
$list = $dbEvent->buildList($r);


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
				<h2>Event Planner<?php echo $title;?></h2>
				<?php echo $text;
				?>
			</div>		
		</div>
		<div id="dynamiccontent">	
		</div>
	</div>
<?php include('inc/footer.php');?>