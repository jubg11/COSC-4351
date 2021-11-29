<?php

// Attempt to connect to MySQL database 
$link = new mysqli(
	"database-4351.ctkzz4wlfaku.us-east-2.rds.amazonaws.com",
	"admin",
	"cosc4351",
	"COSC4351"
);

// Check connection
if ($link->connect_errno) {
	//If failed
	echo "Failed to connect to MySQL database: " . $link->connect_error;
	exit();
}
