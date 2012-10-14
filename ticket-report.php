<?php
include ('inc/lib/Event.php');
include ('inc/lib/Form.php');
include ('inc/lib/HEForm.php');
include ('inc/lib/HEDatabase.php');
include ('inc/lib/DBManager.php');
include ('inc/lib/Host.php');
include ('inc/lib/shared.php');
$dbEvent = new Event();
$dbHandler = new DBManager();
$heDatabase = new HEDatabase();
$heForm = new HEForm();
$dbHost = new Host();


if (!isset($_GET['id'])) {
    $text = 'Pick an event from the list to view its ticket report';
} else {

    $q = $dbEvent->selectID($_GET['id']);
    $r = $dbHandler->query($q);
    $dbEvent->setValues($r);
    $data = array();
    load($data, $dbEvent);
    $title =  $data['e_title'] . ' ' . parseDate($data['e_date']);
    $q = $heDatabase->selectHosts();
    $r = $dbHandler->query($q);
    $data = $heDatabase->getData($r);
    $q = $heDatabase->selectRemainingHosts();
    $r = $dbHandler->query($q);
    $heForm->hostList = $heDatabase->getNameArray($r);

    if (isset($_GET['emailaddressto']) and isset($_GET['emailaddressfrom'])) {
       $text = $_GET['rtext'];;
       $export = "<html><body>";
       $export .= $heForm->exportReport($title, $text, $data);
       $export .= "</body></html>";
       $export = str_replace('\\', '', $export);
       
       $heForm->sendTo($_GET['emailaddressto'], $_GET['emailaddressfrom'],"Ticket Report", $export);
       die();
    }

    if ($heForm->submitted()) {
        $textClean = $heForm->getReportClean();
        $text = $heForm->getReportText();
        $q = $dbEvent->setReport($_GET['id'], $textClean);
        $r = $dbHandler->query($q);
        echo '<link media="all" title="New" rel="stylesheet" type="text/css" href="css/reports.css" />';
        
        echo '<link media="print" title="New" rel="stylesheet" type="text/css" href="css/print.css" />';
        echo "<div id=\"options\"><input type=\"button\" value=\"Print\" onClick=\"window.print()\" /><br><BR>";
echo "<form name=\"input\" action=\"ticket-report.php\" method=\"get\">";
echo "<input type=\"hidden\" name='rtext' id='rtext' value=\"$text\">";
        echo "<input type=\"hidden\" name=\"id\" id=\"id\" value=\"";
echo $_GET['id'];
echo "\" />";

        echo "<table> <tr > <td>To</td> <td><input type=\"text\" name=\"emailaddressto\" /> </td></tr></div>";
        echo "<tr><td>From</td><td> <input type=\"text\" name=\"emailaddressfrom\" /></td></tr></table>";
        echo "<input type=\"submit\" value=\"Email\"></form></div>";
        echo "<div id='mydiv'>";
        $export = $heForm->exportReport($title, $text, $data);
        //update text
        echo str_replace('\\', '', $export);
        echo "</div>";
        unset($_SESSION['title']);
        die();
    } else {
        $heForm->hostList = $heDatabase->getNameArray($r);
        $text = $heForm->makeHEReportTable($data);
        $form = $heForm->makeHEReportForm();
    }
}

//make the list
$q = $dbEvent->selectTitles();
$r = $dbHandler->query($q);
$list = $dbEvent->buildList($r);
include ('inc/head.php');
echo '<link media="all" title="New" rel="stylesheet" type="text/css" href="css/reports.css" />';
        
        echo '<link media="print" title="New" rel="stylesheet" type="text/css" href="css/print.css" />';
        e
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
				<h2>Host Notes/Tickets Report for <?php echo $title; ?></h2>
				<?php echo $form;
echo $text;
?>
			</div>		
		</div>
		<div id="dynamiccontent">	
		</div>
</div>
<?php include ('inc/footer.php'); ?>
