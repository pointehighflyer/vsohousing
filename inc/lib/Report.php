<?php

include('pjmail/pjmail.class.php');

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

    function sendToAttach($to,$from, $subject, $body,$content_PDF) {
       $mail = new PJmail(); 
       $mail->setAllFrom($from, "VSO Housing"); 
       $mail->addrecipient($to); 
       $mail->addsubject($subject); 
       $mail->text = "Please see attached housing report"; 
       $mail->addbinattachement("housing-report.pdf.pdf", $content_PDF); 
       $res = $mail->sendmail();    
       echo ("<p>Message successfully sent! <a href='report.php'>Back</a> </p>");
 
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
        echo "<table> <tr> <td>To</td> <td><input type=\"text\" name=\"emailaddressto\" /> </td></tr>";
        echo "<tr><td>From</td><td> <input type=\"text\" name=\"emailaddressfrom\" /></td></tr></table>";
        echo "<table><tr><td><input type=\"submit\" value=\"Email\"> </form></td></tr>";   
    
	echo "<tr><td></br><form name=\"input\" action=\"$report\" method=\"get\">";
       
       
	echo "<input type=\"hidden\" name='options' id='options' value='excel'>";
	echo "<input type=\"hidden\" name='rtext' id='rtext' value=\"$text\">";
 echo "<input type=\"hidden\" name=\"id\" id=\"id\" value=\"";
	echo $id;
	echo "\" />";
        echo "<input type=\"submit\" value=\"Excel\" name='excel'> </form>";   
        echo "<input type=\"submit\" value=\"PDF\" name='pdf'> </form>";   

	echo "</td></tr></table></div>";
    }

  } 
?>
