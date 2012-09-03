<?php
include_once('tcpdf/config/lang/eng.php');
include_once('tcpdf/tcpdf.php');

class PDF extends TCPDF{

	function PDF(){
		parent::TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);		
		$this->SetCreator(PDF_CREATOR);
		$this->SetAuthor('VSO');
		$this->SetTitle('Housing Report');
		$this->setPrintHeader(false);
		$this->setPrintFooter(false);
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$this->SetFont('times', '', 10);
		$this->setLanguageArray($l);
		$this->AddPage();
	}
	 
	function setHTML($html){
		echo $html;
		//$this->writeHTML($html, true, false, true, false, '');

	}
	
	function out($filename){
		//$this->Output($filename, 'I');
	}
	
	
	

}
?>
