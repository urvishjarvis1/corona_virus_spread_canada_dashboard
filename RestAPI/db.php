<?php
	
	$dbconn = mysqli_connect('localhost',"root","","coronavirusvisualization") or die('MySql connection_aborted()'.msyqli_connect_error());	


	function query($sql){
		global $dbconn;
		$result=mysqli_query($dbconn,$sql) or die(mysqli_error($dbconn));
		return $result;
	}

	function dbFetchAssoc($result){
		return mysqli_fetch_assoc($result);
	}

	function closeDB(){
		global $dbconn;
		msqli_close($dbconn);
	}
?>