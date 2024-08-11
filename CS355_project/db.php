<?php

	$hostname = 'localhost';
	$username = 'land_admin';
	$password = 'landpassword';
	$database = 'project';
	$conn_db = mysqli_connect($hostname,$username,$password,$database);
	if(!$conn_db)
	{
		die(mysqli_error($conn_db));
	}

?>