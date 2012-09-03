<?php
include_once('tcpdf/config/lang/eng.php');
include_once('tcpdf/tcpdf.php');

class PDF extends TCPDF{

	function PDF(){
		$this->SetCreator(PDF_CREATOR);
		$this->SetAuthor('VSO');
		$this->SetTitle('Housing Report');
		$this->setPrintHeader(false);
		$this->setPrintFooter(false);
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$this->SetFont('times', '', 20);
		$this->AddPage();
	}
	 
	function writeHTML($html){
		$this->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
	}
	
	function out($filename){
		$this->Output($filename, 'I');
	}
	
	
	

}
?>
