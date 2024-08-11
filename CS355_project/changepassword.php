<?php 
session_start();
if(!isset($_SESSION['change']))
{
	header("Location: homepage.php");
}
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="css/mycss.css">
	<title>Change Password Page</title>
</head>
<body>
<?php include 'header.php'; ?>
<br>
<div class="text-center">
	<h2>Change Password</h2>
	<br>
	<br>
	<form action="passwdprocess.php" method="post">
		<div class="form-group">
			<label for="currpass"><h4>Current Password:*</h4></label>
			<input type="password" class="form-control" name="currpass" id="currpass" style="width: 20%; margin: auto;" required>
		</div>
		<br>
		<div class="form-group">
			<label for="newpassone"><h4>New Password:*</h4></label>
			<input type="password" class="form-control" name="newpassone" id="newpassone" style="width: 20%; margin: auto;" required>
		</div>
		<br>
		<div class="form-group">
			<label for="newpasstwo"><h4>Confirm New Password:*</h4></label>
			<input type="password" class="form-control" name="newpasstwo" id="newpasstwo" style="width: 20%; margin: auto;" required>
		</div>
		<br>
		<br>
		<button type="submit" class="btn btn-success" name="passchange">Submit</button>
	</form>
	<br>
	<br>
</div>
</body>
</html>