<?php
include('inc/lib/Event.php');
include('inc/lib/Form.php');
include('inc/lib/HEForm.php');
include('inc/lib/HEDatabase.php');
include('inc/lib/DBManager.php');
include('inc/lib/Host.php');
include('inc/lib/shared.php');
$dbEvent = new Event();
$dbHandler = new DBManager();
$heDatabase = new HEDatabase();
$heForm = new HEForm();
$dbHost = new Host();

if(!isset($_GET['id'])){
	$text = 'Pick an event from the list to view its ticket information';
}
else{
	$q = $dbEvent->selectID($_GET['id']);
	$r = $dbHandler->query($q);
	$dbEvent->setValues($r);
	$arr = array();
	load($arr,$dbEvent);
	$title = ' for '.$arr['e_title'].' '.parseDate($arr['e_date']);
	//check if any buttons were pressed and act accordingly
	if($heForm->isAdd()){
		//echo '<p>Adding Musician</p>';
		$host = $heForm->getHost();
		$q = $heDatabase->addHost($host);
		$r = $dbHandler->query($q);
		header('Status: 303');
		header('Location: '.$_SERVER['PHP_SELF'].'?id='.$_GET['id']);
	}
	elseif($heForm->isUpdate()){
		$data = $heForm->getUpdateData();
		foreach($data as $row){
			$q = $heDatabase->updateHost($row);
			$r = $dbHandler->query($q);
		}
		header('Status: 303');
		header('Location: '.$_SERVER['PHP_SELF'].'?id='.$_GET['id']);
	}
	elseif($heForm->isDelete()){
		//echo '<p>delete</p>';
		$data = $heForm->getSelected();
		foreach($data as $id){
			$q = $heDatabase->deleteHost($id);
			$r = $dbHandler->query($q);
		}
		//print_r($data);
		header('Status: 303');
		header('Location: '.$_SERVER['PHP_SELF'].'?id='.$_GET['id']);
	}
	//load the musician form	
	$q = $heDatabase->selectHosts();
	$r = $dbHandler->query($q);
	$arr = $heDatabase->getData($r);
	$q = $heDatabase->selectRemainingHosts();
	$r = $dbHandler->query($q);
	$heForm->hostList = $heDatabase->getNameArray($r);
	$text = $heForm->makeHEForm($arr);
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
				<h2>Host Notes/Tickets<?php echo $title;?></h2>
				<?php echo $text;
				?>
			</div>		
		</div>
		<div id="dynamiccontent">	
		</div>
	</div>
<?php include('inc/footer.php');?>