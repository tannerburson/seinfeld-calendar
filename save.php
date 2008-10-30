<?php
	if($_POST['date'] && $_POST['color']){
		$dbh = new PDO('sqlite:/home/tanner/public_zesty/tanner/seinfeld/db/seinfeld.db');
		echo "INSERT INTO VALUES ('" . $_POST['date']. "')";
		$stmt = $dbh->query("INSERT INTO dates (selected_date,color) VALUES ('" . $_POST['date']. "');");
		echo "Code: " . $dbh->errorCode() . "Message: ";
		print_r($dbh->errorInfo());
		echo "Saved";
		exit;
	}
	echo "Woah there";
?>
