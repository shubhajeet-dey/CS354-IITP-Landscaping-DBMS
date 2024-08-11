<?php 
session_start();
if(!isset($_SESSION['roster']))
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
	<title>Duty Roster Page</title>
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
	<h2>Duty Roster by Area</h2>
	<br>
	<form method="post" action="">
	<label for="areaselect"><h4>Area:</h4></label>
	<select id="areaselect" class="form-select" name="areaselectone" onchange="this.form.submit()" style="width: 20%; margin: auto;">
		<option selected>--SELECT--</option>
	<?php
		$rows =  mysqli_query($conn_db, "SELECT RegionCode FROM Regions") or die(mysqli_error($conn_db));
		while($row = mysqli_fetch_assoc($rows))
		{
			echo "<option value ='".htmlspecialchars($row['RegionCode'])."'>".htmlspecialchars($row['RegionCode'])."</option>";
		}
	?>
	</select>
</form>
<br>
<?php 
	if(isset($_POST['areaselectone']))
	{
		echo "<div class='text-center'>";
		echo "<h3>".htmlspecialchars($_POST['areaselectone'])."</h3>" ;
		echo "<br>";
		echo "<table class='table table-hover table-sm table-bordered mytable'>";
			echo "<thead>";
				echo "<tr>";
					echo "<th scope='col'>Area Code</th><th scope='col'>Gardener ID</th><th scope='col'>Gardener Name</th><th scope='col'>Duty Date</th>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				$areacode = $_POST['areaselectone'];
				$rows = mysqli_query($conn_db, "SELECT DutyRoster.*, Name FROM Gardener, DutyRoster WHERE DutyRoster.Id = Gardener.Id AND RegionCode ='$areacode' ORDER BY dateOfWork, DutyRoster.Id") or die(mysqli_error($conn_db));
				if(mysqli_num_rows($rows) > 0)
				{
					while($row = mysqli_fetch_assoc($rows))
					{
						echo "<tr> <th scope='row'>".htmlspecialchars($row['RegionCode'])."</th> <td>".htmlspecialchars($row['Id'])."</td> <td>".htmlspecialchars($row['Name'])."</td> <td>".htmlspecialchars($row['dateOfWork'])."</td> </tr>";
					}

				}else
				{
					echo "<tr> <td>-</td> <td>-</td> <td>-</td> <td>-</td> </tr>";
				}
			echo "</tbody>";
		echo "</table>";
		echo "</div>";
	}
?>
<br>
	<form action="dutyrosterprocess.php" method="post">
		<button type="submit" class="btn btn-danger" name="clear_roster">Clear Duty Roster</button>
	</form>
<br>
<br>
<br>
<h2>Add Duties to Duty Roster</h2>
<br>
<form action="" method="post">
	<div class="form-group">
		<label for="roster_area"><h4>1. Area Code*</h4></label>
		<select id="roster_area" class="form-control" name="area_code_roster" onchange="this.form.submit()" style="width: 20%; margin: auto;">
			<option selected>--SELECT--</option>
		<?php
			$rows =  mysqli_query($conn_db, "SELECT RegionCode FROM Regions") or die(mysqli_error($conn_db));
			while($row = mysqli_fetch_assoc($rows))
			{
				echo "<option value ='".htmlspecialchars($row['RegionCode'])."'>".htmlspecialchars($row['RegionCode'])."</option>";
			}
		?>
		</select>
	</div>
</form>
<?php 
	if(isset($_POST['area_code_roster']))
	{
		unset($_SESSION['area_code_roster']);
		unset($_SESSION['id_roster']);
		unset($_SESSION['date_roster']);
		$_SESSION['area_code_roster'] = $_POST['area_code_roster']; 
	}

	if(isset($_SESSION['area_code_roster']))
	{
		echo "<br><h5 style='color:red;'>You chose Area Code: ".htmlspecialchars($_SESSION['area_code_roster'])."</h5>";
	}

?>
<br>
<br>
<form action="" method="post">
	<div class="form-group">
		<label for="roster_id"><h4>2. Gardener Avaliable wrt chosen Area Code*</h4></label>
		<select id="roster_id" class="form-control" name="id_roster" onchange="this.form.submit()" style="width: 20%; margin: auto;">
			<option selected>--SELECT--</option>
		<?php
			if(isset($_SESSION['area_code_roster']))
			{
				$areacode = $_SESSION['area_code_roster'];
				$rows =  mysqli_query($conn_db, "SELECT GardenerID FROM GardenerAssignment WHERE GardenerAssignment.RegionCode = '$areacode' AND GardenerID NOT IN (SELECT Id FROM DutyRoster GROUP BY Id HAVING COUNT(dateOfWork)>=30)") or die(mysqli_error($conn_db));
				if(mysqli_num_rows($rows) > 0)
				{	
					while($row = mysqli_fetch_assoc($rows))
					{
						echo "<option value ='".htmlspecialchars($row['GardenerID'])."'>".htmlspecialchars($row['GardenerID'])."</option>";
					}

				}else
				{
					echo "<option selected>No Gardener Available</option>"; 
				}
			}

			if(isset($_SESSION['id_roster']))
			{
				echo "<option selected>--SELECT--</option>";
			}
		?>
		</select>
	</div>
</form>
<?php  
	if(isset($_POST['id_roster']))
	{
		unset($_SESSION['id_roster']);
		unset($_SESSION['date_roster']);
		$_SESSION['id_roster'] = $_POST['id_roster'];
	}

	if(isset($_SESSION['id_roster']))
	{
		echo "<br><h5 style='color:red;'>You chose Gardener ID: ".htmlspecialchars($_SESSION['id_roster'])."</h5>";
	}
?>
<br>
<br>
<form action="" method="post">
	<div class="form-group">
		<label for="roster_date"><h4>3. Dates Available*</h4></label>
		<select id="roster_date" class="form-control" name="date_roster" onchange="this.form.submit()" style="width: 20%; margin: auto;">
			<option selected>--SELECT--</option>
		<?php
			if(isset($_SESSION['area_code_roster']) and isset($_SESSION['id_roster']))
			{
				$areacode = $_SESSION['area_code_roster'];
				$id = $_SESSION['id_roster'];
				$result = mysqli_query($conn_db, "CALL thirty_days_from_now()") or die(mysqli_error($conn_db)); 
				$rows =  mysqli_query($conn_db, "SELECT thirty_dates FROM DATE_TEMP WHERE thirty_dates NOT IN (SELECT dateOfWork FROM DutyRoster WHERE Id = '$id')") or die(mysqli_error($conn_db));
				if(mysqli_num_rows($rows) > 0)
				{	
					while($row = mysqli_fetch_assoc($rows))
					{
						echo "<option value ='".htmlspecialchars($row['thirty_dates'])."'>".htmlspecialchars($row['thirty_dates'])."</option>";
					}

				}else
				{
					echo "<option selected>No More Dates Available</option>"; 
				}
			}

			if(isset($_SESSION['date_roster']))
			{
				echo "<option selected>--SELECT--</option>";
			}
		?>
		</select>
	</div>
</form>
<?php  
	if(isset($_POST['date_roster']))
	{
		unset($_SESSION['date_roster']);
		$_SESSION['date_roster'] = $_POST['date_roster'];
	}

	if(isset($_SESSION['date_roster']))
	{
		echo "<br><h5 style='color:red;'>You chose Date: ".htmlspecialchars($_SESSION['date_roster'])."</h5>";
	}
?>
<br>
<form action="dutyrosterprocess.php" method="post">
	<button type="submit" class="btn btn-primary btn-sm" name="clear_select">Clear Selection</button>
</form>
<br>
<br>
<form action="dutyrosterprocess.php" method="post">
	<button type="submit" class="btn btn-success" name="submit_select">Submit Selection</button>
</form>
<br>
<br>	
</div>
</body>
</html>