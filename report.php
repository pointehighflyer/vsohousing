<?php
session_start();
include('inc/lib/Event.php');
include('inc/lib/Form.php');
include('inc/lib/MEForm.php');
include('inc/lib/MEDatabase.php');
include('inc/lib/DBManager.php');
include('inc/lib/PDF.php');

$dbEvent = new Event();
$dbHandler = new DBManager();
$meDatabase = new MEDatabase();
$meForm = new MEForm();

if(!isset($_GET['id'])){
	$text = 'Pick an event from the list to view its report';
}
else{
	$q = $meDatabase->getReportInfo();
	//echo $q;
	$r = $dbHandler->query($q);
	$data = $meDatabase->getData($r);
	//if form submitted
	//maybe have a save button
	if($meForm->submitted()){
		$textClean = $meForm->getReportClean();
		$text  = $meForm->getReportText();
		//echo $text;
		$q = $dbEvent->setReport($_GET['id'],$textClean);
		$r = $dbHandler->query($q);
		$export = $meForm->exportReport($_SESSION['title'],$text,$data);
		//update text
		echo str_replace('\\','',$export);
		unset($_SESSION['title']);
		die();
	}
	else{
		//load and set text
		$q = $dbEvent->getReport($_GET['id']);
		$r = $dbHandler->query($q);
		$meForm->rText = $dbEvent->report($r);
		$text = $meForm->makeReportTable($data);
		$form = $meForm->makeReportForm();
	}
		
	//$dlLink = '<a href="report.php?id='.$_GET['id'].'&amp;export=1">Export</a>';
	//export table here
	//if($_GET['export'] == 1){
		//$text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
		//$pdf = new PDF();
		//$pdf->setHTML($meForm->exportReport('Housing Report',$text,$data));
		//$pdf->out('test.pdf');
		/*# filename for download 
		$filename = "website_data_" . date('Ymd') . ".xls"; 
		header("Content-Disposition: attachment; filename=\"$filename\""); 
		header("Content-Type: application/vnd.ms-excel"); 
		$flag = false; 
		foreach($data as $row) { 
			if(!$flag) { 
				# display field/column names as first row echo 
				echo implode("\t", array_keys($row)) . "\n"; 
				$flag = true; 
			}
			echo implode("\t", array_values($row)) . "\n"; 
		}*/
}
//make the list
$q = $dbEvent->selectTitles();
$r = $dbHandler->query($q);
$list = $dbEvent->buildList($r);
if(isset($_GET['id'])){
	if(mysql_data_seek($r,0)){
		$arr = $dbEvent->getTitles($r);
		//echo mysql_num_rows($r);
		//print_r($arr);
		$_SESSION['title'] = array_search($_GET['id'],$arr);
		//echo $_SESSION['title'];
	}
	else{
		die('Error reseting data pointer');
	}
}


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
				<h2>Housing Report<?php echo ' for '. $_SESSION['title'];?></h2>
				<?php echo $form; 
					echo $text;
				?>
			</div>		
		</div>
		<div id="dynamiccontent">	
		</div>
	</div>
<?php include('inc/footer.php');?>