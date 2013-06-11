<?php

session_start();

include('inc/lib/shared.php');

include('inc/lib/Host.php');

include('inc/lib/Form.php');

include('inc/lib/HostForm.php');

include('inc/lib/DBManager.php');

include('inc/lib/MEForm.php');

include('inc/lib/MEDatabase.php');

include('inc/lib/HEDatabase.php');

$form = new HostForm();

$db = new DBManager();

$host = new Host();

$meForm = new MEForm();

$heDatabase = new HEDatabase();

$meDatabase = new MEDatabase();



//process the form

if($form->submitted()){

	//echo 'validating';

	$form->validate();

	if($form->errorStatus){

		//redisplay the form with errors

		$form->make();

		$errorList = $form->makeErrList();

		$text = $form->getForm();

		//echo $list;

	}

	else{//no errors!

		$arr = array();

		load($arr,$form);

		unload($arr,$host);

		$text = '<p>Successfully submitted.</p>'.getHost($arr);

		//$host->display();

		if(isset($_SESSION['update'])){

			$q = $host->update();

			$r = $db->query($q);

			$getID = $arr['h_hostID'];

			$_SESSION['result'] = '<p>Record has been updated.</p>';

			//echo $q;

			unset($_SESSION['update']);

			$dupeCheck = 0;

		}

		else{

			$q = $host->add();

			$getID = mysql_insert_id();

			$_SESSION['result'] = '<p>Record has been added.</p>';

			$r = $db->query($q);

			$dupeCheck = 1;

		}

		if($r == 1062 && $dupeCheck == 1 ){ //mysql error code for duplicate record

			$form->make();

			$_SESSION['result'] = '<p>Duplicate record.</p>'.$form->getForm();

			$text = $_SESSION['result'];

			unset($_SESSION['result']);

		}

		else{

			header('Status: 303');

			header('Location: '.$_SERVER['PHP_SELF'].'?id='.$getID);

		}

	}

}

elseif($form->delete()){

	if($form->deleteCheck()){

		$q = $host->delete($form->getID());

		$r = $db->query($q);		

		$q = $meDatabase->clearHost($form->getID());

		$r = $db->query($q);

		$q = $heDatabase->clearHost($form->getID());

		$r = $db->query($q);

		$text = 'Record deleted';

	}

	else{

		$errorList = 'You must check the box in order to delete this record';

		$form->validate(); //so the values are passed back correctly

		$form->make();

		$text = $form->getForm();

	}

}

else{//form not submitted

	//echo 'Form not submitted';

	//perform update check and set values if ncessary, otherwise just do a blank form

	if(isset($_GET['id'])){
	
		$id = $_GET['id'];//**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

		$q = $host->selectID($_GET['id']);

		$r = $db->query($q);

		$host->setValues($r);

		$arr = array();

		load($arr,$host);

		if($_GET['action'] == 'update'){

			$form->mode = 'update';

			//echo 'update<br/>';

			unload($arr,$form);

			$form->make();

			$text = $form->getForm();

			$_SESSION['update'] = 1;

		}

		else{//not updating, just displaying info with links

			//get the host's history
			//$id = '-1';//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

			$q = $meDatabase->getHostHst($arr['h_hostID']);

			$r =  $db->query($q);

			$history = $meForm->makeHostHst($meDatabase->getData($r));

			

			

			//echo 'building list<br/>';

			$text = $_SESSION['result'].getHost($arr);

			unset($_SESSION['result']);

			$editLink = $host->buildEdit();

		}	

	}

	else{//display a blank form

		//load($arr,$host); //<--????????? not sure why this is here

		//unload($arr,$form);//<--????????? but I won't touch it, it could be volatile

		//^harmless after all
		
		//$id = '-1';//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

		$arr = array();

		$form->make();

		$text = $form->getForm();

	}

}
//if no id is selected set $id to -1;
if($id == null){
			 $id= -1;
}



//make the list

$q = $host->selectNames();

$r = $db->query($q);

$list = $host->buildList($r, $id);//****~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~HERE

include('inc/head.php');

?>

<body>

<div id="wrapper">

	<div id="header">

		<img src="images/vermont.gif" alt="Vermont Symphony Orcherstra" />

		<h1>Musician Housing Program</h1>

		<div id="navbar">

			<?php include('inc/nav.php');?>

		</div>

	</div>

	<div id="main">

		<div id="content">

			<div id="leftcol">

				<?php echo $list;?>

			</div>

			<div id="rightcol">

				<h2>Host Management</h2>

				<?php echo $editLink;

					  echo $errorList;

					  echo $text;

				?>

			<div id="dynamiccontent">

				<?php echo $history;?>	

			</div>

			</div>		

		</div>

	</div>

<?php include('inc/footer.php');?>