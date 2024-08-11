<?php 
session_start();
if(isset($_POST['present']))
{
	include 'db.php';
	$id = mysqli_real_escape_string($conn_db, $_POST['present']);
	$result = mysqli_query($conn_db, "CALL mark_attendance('$id',1)") or die(mysqli_error($conn_db));
	header('Location: attendance.php');

}else if(isset($_POST['absent']))
{
	include 'db.php';
	$id = mysqli_real_escape_string($conn_db, $_POST['absent']);
	$result = mysqli_query($conn_db, "CALL mark_attendance('$id',0)") or die(mysqli_error($conn_db));
	header('Location: attendance.php');

}else if(isset($_POST['submitmonth']))
{
	include 'db.php';
	$result = mysqli_query($conn_db, "CALL submit_attendance()") or die(mysqli_error($conn_db));
	echo "<center><h3><script>alert('Attendance submitted for this Month in Log, next Month Cycle starts now!');</script></h3></center>";
	header("refresh:0;url=attendance.php");

}else
{
	header('Location: attendance.php');
}

?>