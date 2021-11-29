<?php
	// Initialize the session
	session_start();
	 
	// Unset all of the session variables
	$_SESSION = array();
	$_POST = array();
	 
	// Destroy the session.
	session_destroy();
	 
	// Redirect to index page
	header("location: ../Index.php");
exit;
