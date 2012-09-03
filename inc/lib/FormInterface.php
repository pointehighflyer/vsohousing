<?php

interface FormInterface{

	//returns the html form to the caller
	function getForm();
	
	//returns the form values of the form as a string
	function getValues();
	
	//returns true if the form is submitted
	function submitted();
	
	//validates the form
	function validate();
	
	//performs input sanitation on the form
	function clean();
	
	//constructs the html form, setting all values to those specified by internal fields
	function makeForm();
	
	//builds a list of all of the form errors
	function makeErrList();


}


?>