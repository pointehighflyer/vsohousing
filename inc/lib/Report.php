<?php
class Report {
    function sendTo($to,$from, $subject, $body) {
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'To: ' . $to . "\r\n";
        $headers .= 'From: ' . $from . "\r\n";
        
        if (mail($to, $subject, $body,$headers)) {
            echo ("<p>Message successfully sent!</p>");
        } else {
            echo ("<p>Message delivery failed...</p>");
        }
    }
    
    function optionsHeader($id,$text,$report) {
        echo '<link media="all" title="New" rel="stylesheet" type="text/css" href="css/reports.css" />';
        echo '<link media="print" title="New" rel="stylesheet" type="text/css" href="css/print.css" />';
        echo "<div id=\"options\"><input type=\"button\" value=\"Print\" onClick=\"window.print()\" /><br><BR>";
	echo "<form name=\"input\" action=\"$report\" method=\"get\">";
	echo "<input type=\"hidden\" name='rtext' id='rtext' value=\"$text\">";
        echo "<input type=\"hidden\" name=\"id\" id=\"id\" value=\"";
	echo $id;
	echo "\" />";
        echo "<table> <tr > <td>To</td> <td><input type=\"text\" name=\"emailaddressto\" /> </td></tr></div>";
        echo "<tr><td>From</td><td> <input type=\"text\" name=\"emailaddressfrom\" /></td></tr></table>";
        echo "<input type=\"submit\" value=\"Email\"></form></div>";   
    }
  } 
?>
