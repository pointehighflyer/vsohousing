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

//make the list
$q = $dbEvent->selectTitles();
$r = $dbHandler->query($q);
$list = $dbEvent->buildList($r);
include ('inc/head.php');
echo '<link media="all" title="New" rel="stylesheet" type="text/css" href="css/reports.css" />';
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
				<h2>Hosts Reporting</h2>
<form name="input" action="hosts-report.php" method="get">
<table>
<tr>
  <td>What active hosts live in Shelburne?</td>
  <td> <input type="radio" name="query" value="1"></td>
</tr>
<tr>
  <td>What active hosts have cats?</td>
  <td> <input type="radio" name="query" value="2"></td>
</tr>
<tr>
  <td>What active hosts will house more than one musician?</td>
  <td> <input type="radio" name="query" value="3"></td>
</tr>
<tr>
  <td>What active hosts allow smoking?</td>
  <td> <input type="radio" name="query" value="4"></td>
</tr>

<tr>
  <td>What active hosts have not housed musicians in the last 18 months?</td>
  <td> <input type="radio" name="query" value="5"></td>
</tr>
<tr>
  <td></td>
  <td> <input type="submit" value="Submit"></td>
</tr>

</table>
</form>

			</div>		
		</div>
</div>
<?php include ('inc/footer.php'); ?>
