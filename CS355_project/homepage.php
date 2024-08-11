<?php 
session_start();
if(!isset($_SESSION['login']))
{
	header("Location: login.php");
	exit();
}
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="css/mycss.css">
	<title>Homepage</title>
	<style type="text/css">
	.mytable {
		    border: 1px solid;
		    width: 70%;
		    margin: 0px auto;
		    float: none;
	}
	.mytable1 {
		    border: 1px solid;
		    width: 85%;
		    margin: 0px auto;
		    float: none;
	}

	</style>
</head>
<body>
<?php include 'header.php'; ?>
<br>
<div class="text-center">
	<h2>Area Details</h2>
	<br>
	<table class="table table-hover table-sm table-bordered mytable">
		<thead>
			<tr>
				<th scope="col">Area Code</th>
				<th scope="col">Area Name</th>
				<th scope="col">Number of Trees at the Area</th>
				<th scope="col">Number of Water Pumps at the Area</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$rows = mysqli_query($conn_db, "SELECT RegionCode, RegionName, NoofTrees, NoofWaterPumps FROM Regions") or die(mysqli_error($conn_db));
			if(mysqli_num_rows($rows) > 0)
			{
				while($row = mysqli_fetch_assoc($rows))
				{
					$trees = $row['NoofTrees']; 
					if($trees===NULL)
						{$trees = '-';}
					$pumps = $row['NoofWaterPumps'];
					if($pumps===NULL)
						{$pumps = '-';}
					echo "<tr> <th scope='row'>".htmlspecialchars($row['RegionCode'])."</th> <td>".htmlspecialchars($row['RegionName'])."</td> <td>".htmlspecialchars($trees)."</td> <td>".htmlspecialchars($pumps)."</td> </tr>";
				}
			}else
			{
				echo "<tr> <td>-</td> <td>-</td> <td>-</td> <td>-</td> </tr>";
			}
			?>
		</tbody>
	</table>
</div>
<br>
<br>
<br>
<br>
<div class="text-center"><h2> Gardener Details By Area </h2>
<br>
<form method="post" action="">
	<label for="areaselect"><h3>Area:</h3></label>
	<select id="areaselect" class="form-select" name="areaselectone" onchange="this.form.submit()" style="width: 20%; margin: auto; text-align: center;">
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
</div>
<br>
<?php 
	if(isset($_POST['areaselectone']))
	{
		echo "<div class='text-center'>";
		echo "<h3>".htmlspecialchars($_POST['areaselectone'])."</h3>" ;
		echo "<br>";
		echo "<table class='table table-hover table-sm table-bordered mytable1'>";
			echo "<thead>";
				echo "<tr>";
					echo "<th scope='col'>ID</th><th scope='col'>Name</th><th scope='col'>Phone Number</th><th scope='col'>Address</th><th scope='col'>Add. Phone Number</th><th scope='col'>Aadhar Number</th><th scope='col'>Employment Type</th><th scope='col'>Date of Joining</th><th scope='col'>Start Date</th><th scope='col'>End Date</th>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				$areacode = $_POST['areaselectone'];
				$rows = mysqli_query($conn_db, "SELECT Gardener.*, StartDate, EndDate FROM Gardener, GardenerAssignment WHERE GardenerAssignment.GardenerID = Gardener.Id AND RegionCode ='$areacode' AND EndDate>CURDATE()") or die(mysqli_error($conn_db));
				if(mysqli_num_rows($rows) > 0)
				{
					while($row = mysqli_fetch_assoc($rows))
					{
						$addphone = $row['AddiPhoneNo'];
						if($addphone===NULL)
							{$addphone = '-';}
						echo "<tr> <th scope='row'>".htmlspecialchars($row['Id'])."</th> <td>".htmlspecialchars($row['Name'])."</td> <td>".htmlspecialchars($row['PhoneNo'])."</td> <td>".htmlspecialchars($row['Address'])."</td> <td>".htmlspecialchars($addphone)."</td> <td>".htmlspecialchars($row['AadharNo'])."</td> <td>".htmlspecialchars($row['EmpType'])."</td> <td>".htmlspecialchars($row['DateofJoining'])."</td> <td>".htmlspecialchars($row['StartDate'])."</td> <td>".htmlspecialchars($row['EndDate'])."</td> </tr>";
					}

				}else
				{
					echo "<tr> <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td> </tr>";
				}
			echo "</tbody>";
		echo "</table>";
		echo "</div>";
	}
?>
<br>
<br>
</body>
</html>