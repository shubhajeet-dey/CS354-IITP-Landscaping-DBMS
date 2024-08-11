<?php
session_start(); 
if(isset($_POST['clear_roster']))
{
	include 'db.php';
	$result = mysqli_query($conn_db, "DELETE FROM DutyRoster") or die(mysqli_error($conn_db));
	echo "<center><h3><script>alert('The Duty Roster is now Empty!');</script></h3></center>";
	unset($_SESSION['area_code_roster']);
	unset($_SESSION['id_roster']);
	unset($_SESSION['date_roster']);
	header("refresh:0;url=dutyroster.php");

}else if(isset($_POST['clear_select']))
	{
		unset($_SESSION['area_code_roster']);
		unset($_SESSION['id_roster']);
		unset($_SESSION['date_roster']);
		header('Location: dutyroster.php');
	}
else if(isset($_POST['submit_select']))
	{
		if(isset($_SESSION['area_code_roster']) and isset($_SESSION['id_roster']) and isset($_SESSION['date_roster']))
		{	
			include 'db.php';
			$areacode = mysqli_real_escape_string($conn_db, $_SESSION['area_code_roster']);
			$id = mysqli_real_escape_string($conn_db, $_SESSION['id_roster']);
			$date_roster = mysqli_real_escape_string($conn_db, $_SESSION['date_roster']);
			unset($_SESSION['area_code_roster']);
			unset($_SESSION['id_roster']);
			unset($_SESSION['date_roster']);

			$result = mysqli_query($conn_db, "INSERT INTO DutyRoster VALUES ('$id','$areacode','$date_roster')") or die(mysqli_error($conn_db));

			header('Location: dutyroster.php');
		}else
		{
			echo "<center><h3><script>alert('Please enter all the Details Before Submitting!');</script></h3></center>";
			header("refresh:0;url=dutyroster.php");
		}

	}
else
{
	header('Location: dutyroster.php');
}

?>