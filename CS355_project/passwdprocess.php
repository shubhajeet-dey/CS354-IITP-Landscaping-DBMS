<?php  
session_start();
if(isset($_POST['passchange']))
{
	if($_POST['newpassone'] == $_POST['newpasstwo'])
	{
		include 'db.php';
		$id = mysqli_real_escape_string($conn_db, $_SESSION['ID']);
		$currpass = mysqli_real_escape_string($conn_db, $_POST['currpass']);
		$newpass = mysqli_real_escape_string($conn_db, $_POST['newpassone']);

		$result = mysqli_query($conn_db, "SELECT * FROM LoginDetails WHERE Id = '$id' AND Passwd = SHA2('$currpass',256)") or die(mysqli_error($conn_db));
		if(mysqli_num_rows($result) == 1)
		{
			$result = mysqli_query($conn_db, "UPDATE LoginDetails SET Passwd = SHA2('$newpass',256) WHERE Id = '$id'") or die(mysqli_error($conn_db));
			echo "<center><h3><script>alert('Password Updated Successfully!');</script></h3></center>";
			header("refresh:0;url=homepage.php");	
		}else
		{
			echo "<center><h3><script>alert('Current Password does not match!');</script></h3></center>";
			header("refresh:0;url=changepassword.php");	
		}


	}else{

		echo "<center><h3><script>alert('New Password and Confirm New Password do not match!');</script></h3></center>";
		header("refresh:0;url=changepassword.php");
	}
}
else
{
	header("Location: homepage.php");
}
?>