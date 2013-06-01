<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Musician Housing Program</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta name="author" content="Evan Yandell"/>
		<meta name="description" content="VSO Musician Housing Program"/>
		<link media="all" title="New" rel="stylesheet" type="text/css" href="css/main.css" />
		<script type="text/javascript">
			//<!--
			
			//function to force the user to click a confirmation
			//before navigating away from a form with errors
			function forceConfirm(){
				<?php
					if($form->errorStatus){
						echo 'if(confirm("Are you sure you want to navigate away from this page? All unsaved changes will be lost.")){'."\n".
  							'return true;'."\n".'}'."\n".
  							'else{ return false;}';
					}
					else{ echo 'return true;';}
				?>
			}
			
			//Function to enable selectall on checkboxes, found here:
			//http://www.velocityreviews.com/forums/t156917-forms-check-all-checkboxes.html
			function selectAll(x) {
				for(var i=0,l=x.form.length; i<l; i++)
					if(x.form[i].type == 'checkbox' && x.form[i].name != 'sAll')
						x.form[i].checked=x.form[i].checked?false:true
			}
			//-->
		</script>
	</head>
