<?php 
session_start();
if(!isset($_SESSION['equip']))
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
	<title>Equipment Page</title>
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
	<script type="text/javascript">
	    function checkDispDate() {
	        var datevalue = document.getElementById('disp_date').value;
	        var givendate = new Date(datevalue);
	        var today = new Date();
	        today.setDate(today.getDate()-1);
	        if ( givendate < today ) { 
	            alert("You cannot enter a date less than today's date");
	            return false;
	        }
	        return true;
	    }
	</script>
</head>
<body>
<?php include 'header.php'; ?>
<br>
<div class="text-center">
	<h2>Equipments under Repair</h2>
	<br>
	<table class="table table-hover table-sm table-bordered mytable">
		<thead>
			<tr>
				<th scope="col">Equipment ID</th>
				<th scope="col">Date Issued</th>
				<th scope="col">Approx Dispatch Date</th>
				<th scope="col">Remarks</th>
				<th scope="col">Repair Done?</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$rows = mysqli_query($conn_db, "SELECT EquipmentId, DateIssued, DispatchDate, Remarks FROM Repairs") or die(mysqli_error($conn_db));
			if(mysqli_num_rows($rows) > 0)
			{
				while($row = mysqli_fetch_assoc($rows))
				{
					$remark = $row['Remarks'];
					if($remark===NULL)
						{$remark = '-';}
					$dispatch_date = $row['DispatchDate'];
					if($dispatch_date===NULL)
						{$dispatch_date = '-';}
					echo "<tr> <th scope='row'>".htmlspecialchars($row['EquipmentId'])."</th> <td>".htmlspecialchars($row['DateIssued'])."</td> <td>".htmlspecialchars($dispatch_date)."</td> <td>".htmlspecialchars($remark)."</td> <td><form action='equiprepairprocess.php' method='post'><button type='submit' class='btn btn-success btn-sm' name='repaired' value='".htmlspecialchars($row['EquipmentId'])."'>Repaired</button></form></td> </tr>";
				}
			}else
			{
				echo "<tr> <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td> </tr>";
			}
			?>
		</tbody>
	</table>
	<br>
	<br>
	<br>
	<br>
	<h2>Equipments in Stock</h2>
	<br>
	<table class="table table-hover table-sm table-bordered mytable1">
		<thead>
			<tr>
				<th scope="col">Equipment ID</th>
				<th scope="col">Equipment Name</th>
				<th scope="col">Fuel Tank Capacity</th>
				<th scope="col">Buying Date</th>
				<th scope="col">Warranty Till Date</th>
				<th scope="col">Previous Maintenance Date</th>
				<th scope="col">Upcoming Maintenance Date</th>
				<th scope="col">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$rows = mysqli_query($conn_db, "SELECT * FROM Equipment") or die(mysqli_error($conn_db));
			if(mysqli_num_rows($rows) > 0)
			{
				while($row = mysqli_fetch_assoc($rows))
				{
					$fuel = $row['FuelTankCapacity'];
					if($fuel===NULL)
						{$fuel = '-';}
					$warranty = $row['WarrantyTillDate'];
					if($warranty===NULL)
						{$warranty = '-';}
					$lastmain = $row['LastMaintenance'];
					if($lastmain===NULL)
						{$lastmain = '-';}
					$nextmain = $row['NextMaintenance'];
					if($nextmain===NULL)
						{$nextmain = '-';}
					echo "<tr> <th scope='row'>".htmlspecialchars($row['EquipmentId'])."</th> <td>".htmlspecialchars($row['EquipmentName'])."</td> <td>".htmlspecialchars($fuel)."</td> <td>".htmlspecialchars($row['BuyingDate'])."</td> <td>".htmlspecialchars($warranty)."</td> <td>".htmlspecialchars($lastmain)."</td> <td>".htmlspecialchars($nextmain)."</td> <td>";
					
					$eqp_status = $row['Status'];
					if($eqp_status == "INUSE")
					{
						echo "<button type='button' class='btn btn-outline-primary btn-sm'>IN USE</button>";
					
					}else if($eqp_status == "INREPAIR")
					{
						echo "<button type='button' class='btn btn-outline-danger btn-sm'>IN REPAIR</button>";
					}
					
					echo "</td> </tr>";
				}
			}else
			{
				echo "<tr> <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td> </tr>";
			}
			?>
		</tbody>
	</table>
	<br>
	<br>
	<br>
	<br>
	<h2>Submit Details for Equipments under Repair</h2>
	<br>
	<form action="equiprepairprocess.php" method="post">
		<div class="form-group">
		<label for="eqp_select"><h4>Equipment ID:*</h4></label>
		<select id="eqp_select" class="form-control" name="id" style="width: 20%; margin: auto;" required>
		<?php
			$rows =  mysqli_query($conn_db, "SELECT EquipmentId FROM Equipment WHERE Status = 'INUSE'") or die(mysqli_error($conn_db));
			while($row = mysqli_fetch_assoc($rows))
			{
				echo "<option value ='".htmlspecialchars($row['EquipmentId'])."'>".htmlspecialchars($row['EquipmentId'])."</option>";
			}
		?>
		</select>
		</div>
		<br>
		<div class="form-group">
		<label for="disp_date"><h4>Approx. Dispatch Date:(Not Mandatory)</h4></label>
		<input type="date" id="disp_date" class="form-control" name="disp_date" onchange="return checkDispDate();" style="width: 20%; margin: auto;">
		</div>
		<br>
		<div class="form-group">
		<label for="remarks"><h4>Remarks:(Not Mandatory)</h4></label>
		<input type="text" id="remarks" class="form-control" name="remarks" style="width: 20%; margin: auto;" maxlength="149">
		</div>
		<br>
		<button type="submit" class="btn btn-success" name="new_repair">Submit</button>
	</form>
	<br>
	<br>
</div>
</body>
</html>