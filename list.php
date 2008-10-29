<?php
	$dbh = new PDO('sqlite:/home/tanner/public_zesty/tanner/seinfeld/db/seinfeld.db');
	$array = array();
	foreach($dbh->query('SELECT * from dates') as $row){
		$array[] = $row;
	}
	echo json_encode($array);
?>
