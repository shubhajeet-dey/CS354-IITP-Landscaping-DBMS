<?php  
session_start();
if(!isset($_SESSION['request_']))
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
	<title>Requests page</title>
	<style type="text/css">
	.mytable {
		    border: 1px solid;
		    width: 70%;
		    margin: 0px auto;
		    float: none;
	}

	</style>
</head>
<body>
<?php include 'header.php'; ?>
<br>
<div class="text-center">
	<h2>Grass Cutting Requests</h2>
	<br>
	<table class="table table-hover table-sm table-bordered mytable">
		<thead>
			<tr>
				<th scope="col">Area Code</th>
				<th scope="col">Number of Requests</th>
				<th scope="col">Request Start Date</th>
				<th scope="col">Request Completed?</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$rows = mysqli_query($conn_db, "SELECT RegionCode, COUNT(*) AS CNT, MIN(RequestDate) as First_Date FROM Requests GROUP BY RegionCode ORDER BY CNT DESC, First_Date ASC") or die(mysqli_error($conn_db));
			if(mysqli_num_rows($rows) > 0)
			{
				while($row = mysqli_fetch_assoc($rows))
				{
					echo "<tr> <th scope='row'>".htmlspecialchars($row['RegionCode'])."</th> <td>".htmlspecialchars($row['CNT'])."</td> <td>".htmlspecialchars($row['First_Date'])."</td> <td><form action='requestprocess.php' method='post'><button type='submit' class='btn btn-success btn-sm' name='done' value='".htmlspecialchars($row['RegionCode'])."'>Done</button></form></td> </tr>";
				}
			}else
			{
				echo "<tr> <td>-</td> <td>-</td> <td>-</td> <td>-</td> </tr>";
			}
			?>
		</tbody>
	</table>
	<br>
	<br>
	<br>
	<br>
	<h2>Grass Cutting Requests Details by Area</h2>
	<br>
	<form method="post" action="">
	<label for="areaselect"><h3>Area:</h3></label>
	<select id="areaselect" class="form-select" name="areaselectone" onchange="this.form.submit()" style="width: 20%; margin: auto; text-align: center;">
		<option selected>--SELECT--</option>
	<?php
		$rows =  mysqli_query($conn_db, "SELECT RegionCode FROM Requests GROUP BY RegionCode ORDER BY RegionCode") or die(mysqli_error($conn_db));
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
		echo "<table class='table table-hover table-sm table-bordered mytable'>";
			echo "<thead>";
				echo "<tr>";
					echo "<th scope='col'>#</th><th scope='col'>Area Code</th><th scope='col'>Remarks</th><th scope='col'>Request Date</th>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				$areacode = $_POST['areaselectone'];
				$rows = mysqli_query($conn_db, "SELECT * FROM Requests WHERE RegionCode ='$areacode' ORDER BY RequestDate") or die(mysqli_error($conn_db));
				if(mysqli_num_rows($rows) > 0)
				{
					$cnt = 1;
					while($row = mysqli_fetch_assoc($rows))
					{
						$remark = $row['Remarks'];
						if($remark===NULL)
							{$remark = '-';}
						echo "<tr> <th scope='row'>$cnt</th> <td>".htmlspecialchars($row['RegionCode'])."</td> <td>".htmlspecialchars($remark)."</td> <td>".htmlspecialchars($row['RequestDate'])."</td> </tr>";
						$cnt = $cnt + 1;
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
	<br>
</div>
</body>
</html>