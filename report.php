<?php
/*
  Housing Report
*/
session_start();
include ('inc/lib/Event.php');
include ('inc/lib/Form.php');
include ('inc/lib/MEForm.php');
include ('inc/lib/Report.php');
include ('inc/lib/MEDatabase.php');
include ('inc/lib/DBManager.php');
include ('inc/lib/html2pdf/html2pdf.class.php');

$dbEvent = new Event();
$dbHandler = new DBManager();
$meDatabase = new MEDatabase();
$meForm = new MEForm();
$report = new Report();

if (!isset($_GET['id'])) {
    $text = 'Pick an event from the list to view its report';
} else {
    $q = $meDatabase->getReportInfo();
    //echo $q;
    $r = $dbHandler->query($q);
    $data = $meDatabase->getData($r);

    if (isset($_GET['excel'])) {
        //make the list
        $q = $dbEvent->selectTitles();
        $r = $dbHandler->query($q);
        if (isset($_GET['id'])) {
            if (mysql_data_seek($r, 0)) {
                $arr = $dbEvent->getTitles($r);
                $title = array_search($_GET['id'], $arr);
            }
        }
        $text = $_GET['rtext'];
        $meForm->exportExcel($title, $text, $data);

    } else if ($_GET['pdf']) {
        //make the list
        $q = $dbEvent->selectTitles();
        $r = $dbHandler->query($q);
        if (isset($_GET['id'])) {
            if (mysql_data_seek($r, 0)) {
                $arr = $dbEvent->getTitles($r);
                $title = array_search($_GET['id'], $arr);
            }
        }

        $text = $_GET['rtext'];
        $export = $meForm->exportReport($title, $text, $data);
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->WriteHTML($export);
        $html2pdf->Output('housing-report.pdf');

    } else if ($_GET['emailaddressto'] != '' and $_GET['emailaddressfrom'] != '') {
        //make the list
        $q = $dbEvent->selectTitles();
        $r = $dbHandler->query($q);

        if (isset($_GET['id'])) {
            if (mysql_data_seek($r, 0)) {
                $arr = $dbEvent->getTitles($r);
                $title = array_search($_GET['id'], $arr);
            }
        }

        $text = $_GET['rtext'];
        $export = "<html><body>";
        $export.= $meForm->exportReport($title, $text, $data);
        $export.= "</body></html>";
        $export = str_replace('\\', '', $export);
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->WriteHTML($export);
        $report->sendToAttach($_GET['emailaddressto'], $_GET['emailaddressfrom'], "Housing Report", $export, $html2pdf->Output('', true));
        die();
    }

    if ($meForm->submitted()) {
        $textClean = $meForm->getReportClean();
        $text = $meForm->getReportText();
        $q = $dbEvent->setReport($_GET['id'], $textClean);
        $r = $dbHandler->query($q);
        $report->optionsHeader($_GET['id'], $text, "report.php");
        echo "<div id='mydiv'>";
        //echo $text;
        $export = $meForm->exportReport($_SESSION['title'], $text, $data);
        //update text
        echo str_replace('\\', '', $export);
        echo "</div>";
        unset($_SESSION['title']);
        die();

    } else {
        //load and set text
        $q = $dbEvent->getReport($_GET['id']);
        $r = $dbHandler->query($q);
        $meForm->rText = $dbEvent->report($r);
        $text = $meForm->makeReportTable($data);
        $form = $meForm->makeReportForm();
    }
}

//make the list
$q = $dbEvent->selectTitles();
$r = $dbHandler->query($q);
$list = $dbEvent->buildList($r);

if (isset($_GET['id'])) {
    if (mysql_data_seek($r, 0)) {
        $arr = $dbEvent->getTitles($r);
        $_SESSION['title'] = array_search($_GET['id'], $arr);
    } else {
        die('Error reseting data pointer');
    }
}
include ('inc/head.php');
?>
<body>
<div id="wrapper">
	<div id="header">
		<img src="images/vermont.gif" alt="Vermont Symphony Orcherstra" />
		<h1>Musician Housing Program</h1>
		<div id="navbar">
			<?php include ('inc/nav.php'); ?>
		</div>
	</div>
	<div id="main">
		<div id="content">
			<div id="leftcol">
				<?php echo $list; ?>
			</div>
			<div id="rightcol">
				<h2>Housing Report<?php echo ' for ' . $_SESSION['title']; ?></h2>
				<?php echo $form;
echo $text;
?>
			</div>		
		</div>
		<div id="dynamiccontent">	
		</div>
	</div>
<?php include ('inc/footer.php'); ?>
