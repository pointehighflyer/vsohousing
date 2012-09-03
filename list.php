<?php

include('inc/lib/shared.php');
include('inc/lib/Host.php');
include('inc/lib/Event.php');
include('inc/lib/Musician.php');
include('inc/lib/HostEvent.php');
include('inc/lib/MusicianEvent.php');
include('inc/lib/Form.php');
include('inc/lib/HostForm.php');
include('inc/lib/DBManager.php');


$host = new Host();
$db = new DBManager();
$q = $host->selectNames();
$r = $db->query($q);
$list = $host->buildList($r);
echo $list;




?>