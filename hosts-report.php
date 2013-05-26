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


if (!isset($_GET['query'])) {
    echo 'Pick an event from the list to view its ticket report';
} else {

    $data = array();

if ($_GET['query']  == 1){   
    $title = 'VSO Hosts';
    $q = $dbHost->selectCity();
 
    $r = $dbHandler->query($q);
    $data = $heDatabase->getData($r);
    }
    if (isset($_GET['emailaddressto']) and isset($_GET['emailaddressfrom'])) {
       $text = $_GET['rtext'];;
       $export = "<html><body>";
       $export .= $heForm->exportReport($title, $text, $data);
       $export .= "</body></html>";
       $export = str_replace('\\', '', $export);
       
       $heForm->sendTo($_GET['emailaddressto'], $_GET['emailaddressfrom'],"Ticket Report", $export);
       die();
    }

        echo '<link media="all" title="New" rel="stylesheet" type="text/css" href="css/reports.css" />';
        
        echo '<link media="print" title="New" rel="stylesheet" type="text/css" href="css/print.css" />';
        echo "<div id=\"options\"><input SRC=\"/vsohousing/images/print_printer.png\" HEIGHT=\"60\" WIDTH=\"63\" type=\"image\" value=\"Print\" onClick=\"window.print()\" /><br><BR>";
        echo "<form name=\"input\" action=\"ticket-report.php\" method=\"get\">";
        echo "<input type=\"hidden\" name='rtext' id='rtext' value=\"$text\">";
        echo "<input type=\"hidden\" name=\"id\" id=\"id\" value=\"";
        echo "\" />";

        echo "<table> <tr > <td>To</td> <td><input type=\"text\" name=\"emailaddressto\" /> </td></tr></div>";
        echo "<tr><td>From</td><td> <input type=\"text\" name=\"emailaddressfrom\" /></td></tr></table>";
        echo "<input  SRC=\"/vsohousing/images/email_send.png\" type=\"image\"   HEIGHT=\"60\" WIDTH=\"63\" value=\"Email\"></form></div>";
        echo "<div id='mydiv'>";


  function reportTable($data) {
        $form = "\n";
        $form.= "\n" . '<table class="report">' . "\n" . '<tr>' . "\n" . '<th>Host Name</th>' . "\n" .  '</tr>' . "\n";
        //generate dynamic fields
        foreach ($data as $row) {
            $form.= '<tr>' . "\n" . '<td>' . "\n" . $row['fldFirstName'] . ' ' . $row['fldLastName'] . '</td>' . "\n"; 
        }
        $form.= '</table>' . "\n\n" . '</form>' . "\n";
        return $form;
    }

  function exportReport($title, $text, $data) {
        $html = '<div class="report">';
        $html .= '<h2 style="text-align:center;font-size:12pt;font-weight:bold;text-decoration:underline;">' . $title . '</h2>' . '<p style="font-size:12pt;margin-left:auto;margin-right:auto;width:700px;">' . '</p>' . reportTable($data);
        $html .= '<br>';
        $html .= date('m/d/Y h:i:s a', time());
        $html .= '</div>';
        return $html;
    }

        $export = exportReport($title, $text, $data);
        //update text
        echo str_replace('\\', '', $export);
        echo "</div>";
        unset($_SESSION['title']);
        die();
}

//make the list
$q = $dbEvent->selectTitles();
$r = $dbHandler->query($q);
$list = $dbEvent->buildList($r);
include ('inc/head.php');
echo '<link media="all" title="New" rel="stylesheet" type="text/css" href="css/reports.css" />';
        
        echo '<link media="print" title="New" rel="stylesheet" type="text/css" href="css/print.css" />';
        
?>
