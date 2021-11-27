<?php 

	// Attempt to connect to MySQL database 
	$link = new mysqli("database-4353.ctkzz4wlfaku.us-east-2.rds.amazonaws.com",
		"admin",
		"COSC4353",
		"fuelQuote_schema");

	// Check connection
	if ($link -> connect_errno) {
		//If failed
	  	echo "Failed to connect to MySQL database: " . $link -> connect_error;
	  	exit();
	}
?>