<?php 
session_start();
if(!isset($_SESSION['attend']))
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
	<title>Attendance Page</title>
	<style type="text/css">
	.mytable {
		    border: 1px solid;
		    width: 50%;
		    margin: 0px auto;
		    float: none;
	}

	</style>
</head>
<body>
<?php include 'header.php'; ?>
<br>
<div class="text-center">
	<h2>Today's Attendance List Left</h2>
	<br>
	<table class="table table-hover table-sm table-bordered mytable">
		<thead>
			<tr>
				<th scope="col">Gardener ID</th>
				<th scope="col">Present?</th>
				<th scope="col">Absent?</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$rows = mysqli_query($conn_db, "SELECT Id FROM Gardener WHERE Id NOT IN (SELECT GardenerID FROM Attendance) OR Id IN (SELECT GardenerID FROM Attendance WHERE LastAttendanceDate < CURDATE())") or die(mysqli_error($conn_db));
			if(mysqli_num_rows($rows) > 0)
			{
				while($row = mysqli_fetch_assoc($rows))
				{
					echo "<tr> <th scope='row'>".htmlspecialchars($row['Id'])."</th> <td><form action='attendanceprocess.php' method='post'><button type='submit' class='btn btn-success btn-sm' name='present' value='".htmlspecialchars($row['Id'])."'>Present</button></form></td> <td><form action='attendanceprocess.php' method='post'><button type='submit' class='btn btn-danger btn-sm' name='absent' value='".htmlspecialchars($row['Id'])."'>Absent</button></form></td> </tr>";
				}
			}else
			{
				echo "<tr> <td>-</td> <td>-</td> <td>-</td> </tr>";
			}
			?>
		</tbody>
	</table>
	<br>
	<br>
	<br>
	<br>
	<h2>This Month's Attendance List</h2>
	<br>
	<table class="table table-hover table-sm table-bordered mytable">
		<thead>
			<tr>
				<th scope="col">Gardener ID</th>
				<th scope="col">Attendance in This Month</th>
				<th scope="col">Last Date Attendance Marked</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$rows = mysqli_query($conn_db, "SELECT * FROM Attendance") or die(mysqli_error($conn_db));
			if(mysqli_num_rows($rows) > 0)
			{
				while($row = mysqli_fetch_assoc($rows))
				{
					echo "<tr> <th scope='row'>".htmlspecialchars($row['GardenerID'])."</th> <td>".htmlspecialchars($row['AttendanceInCurrMonth'])."</td> <td>".htmlspecialchars($row['LastAttendanceDate'])."</td> </tr>";
				}
			}else
			{
				echo "<tr> <td>-</td> <td>-</td> <td>-</td> </tr>";
			}
			?>
		</tbody>
	</table>
	<br>
	<form action="attendanceprocess.php" method="post">
		<button type="submit" class="btn btn-primary" name="submitmonth">Submit This Month's Attendance</button>
	</form>
	<br>
	<br>
</div>
</body>
</html>