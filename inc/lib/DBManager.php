<?php
//Class to handle the connection to the MySQL database
//based on the code found here:
//http://stackoverflow.com/questions/1580738/how-do-you-manage-database-connections-in-php 
class DBManager{

	var $dbHost = 'localhost';
	var $dbUser = 'username';
	var $dbPass = 'Password';
	//var $dbPass = '';
	var $dbName = 'housingdb';
	var $connection;
	
	//Constructor automatically opens a connection when invoked
	
	function DBManager(){
		$this->connection = mysql_connect($this->dbHost,$this->dbUser,$this->dbPass) or die(mysql_error());
		mysql_select_db($this->dbName,$this->connection);
	}
	
	//performs specified query on the database
	//@param $q: query string
	//returns $r: resource object w/ results of the query error # if query fails 
	function query($q){
		//echo '<p>',$q,'</p>';
		$r = mysql_query($q, $this->connection);
		if($r != false){
			return $r;   //only in PHP is this mixed type shenanigans allowed
		}
		else{
			//echo mysql_errno($this->connection);
			return mysql_errno($this->connection);
		}
	}

}

?>
