<?php 
session_start();
if(isset($_POST['repaired']))
{
	include 'db.php';
	$id = mysqli_real_escape_string($conn_db, $_POST['repaired']);
	$result = mysqli_query($conn_db, "DELETE FROM Repairs WHERE Repairs.EquipmentId = '$id'") or die(mysqli_error($conn_db));
	header('Location: equipmentpage.php');

}else if(isset($_POST['new_repair']))
{
	include 'db.php';
	$id = mysqli_real_escape_string($conn_db, $_POST['id']);

	if (isset($_POST['disp_date']) and !empty($_POST['disp_date']))
	{
		$disp_date = mysqli_real_escape_string($conn_db, $_POST['disp_date']);
		$disp_date = date('Y-m-d', strtotime($disp_date));
	}else
	{
		$disp_date = NULL;
	}

	if (isset($_POST['remarks']) and !empty($_POST['remarks']))
	{
		$remark = mysqli_real_escape_string($conn_db, $_POST['remarks']);
		if($disp_date === NULL)
		{
			$result = mysqli_query($conn_db, "INSERT INTO Repairs(EquipmentId, DateIssued, Remarks) VALUES ('$id',CURDATE(),'$remark')") or die(mysqli_error($conn_db));

		}else
		{
			$result = mysqli_query($conn_db, "INSERT INTO Repairs VALUES ('$id',CURDATE(),'$disp_date','$remark')") or die(mysqli_error($conn_db));
		}
	}else
	{
		if($disp_date === NULL)
		{
			$result = mysqli_query($conn_db, "INSERT INTO Repairs(EquipmentId, DateIssued) VALUES ('$id',CURDATE())") or die(mysqli_error($conn_db));

		}else
		{
			$result = mysqli_query($conn_db, "INSERT INTO Repairs(EquipmentId, DateIssued, DispatchDate) VALUES ('$id',CURDATE(),'$disp_date')") or die(mysqli_error($conn_db));
		}
	}

	header('Location: equipmentpage.php');	
}else
{
	header('Location: equipmentpage.php');
}

?>