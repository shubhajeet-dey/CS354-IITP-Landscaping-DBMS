<?php  
session_start();
if(isset($_POST['done']))
{
	include 'db.php';
	$regioncode = mysqli_real_escape_string($conn_db, $_POST['done']);
	$result = mysqli_query($conn_db, "DELETE FROM Requests WHERE RegionCode = '$regioncode'") or die(mysqli_error($conn_db));
	header('Location: requestpage.php');
}
else
{
	header('Location: requestpage.php');
}
?>