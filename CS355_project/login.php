<?php
include_once 'db.php';
session_start();
if (isset($_SESSION['ID']))
{
    session_destroy();
}

if (isset($_POST['submit']))
{
    $id = mysqli_real_escape_string($conn_db,$_POST['id']);
    $passwd = mysqli_real_escape_string($conn_db,$_POST['passwd']);

    $row = mysqli_query($conn_db, "SELECT EmpType FROM LoginDetails WHERE Id = '$id' AND Passwd = SHA2('$passwd',256)") or die(mysqli_error($conn_db));
    
    if (mysqli_num_rows($row) == 1)
    {
        if (isset($_SESSION['ID']))
        {
            session_unset();
        }
        $_SESSION['ID'] = $id;
        $empType = mysqli_fetch_assoc($row);
        if($empType['EmpType'] == "Supervisor")
        {
        	$_SESSION['login'] = 1;
        	header("Location: homepage.php");
        	exit();
        } 
    }
    else
    {
        echo "<center><h3><script>alert('Incorrect ID or Password');</script></h3></center>";
        header("refresh:0;url=login.php");
    }
}
?>



<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Login Page</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
            
	</head>

	<body>
	<nav id="navbar_top" class="navbar sticky-top navbar-dark bg-primary">
 <div class="container">
 	 <a class="navbar-brand" href="#">Landscaping Login Page</a>
</div>
	</nav>
	<section class="vh-100">
			<div class="container-fluid h-custom">
			<div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="images/login_photo.png" class="img-fluid"
          alt="Sample image">
      </div>
	  <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
							<form method="post" action="login.php" enctype="multipart/form-data">
							<h3 style="font-family: serif; color:grey; text-align:center;">Login</h3>
								<div class="form-group">
									<h5 style="font-family: serif;  font-size: 16px;"><label class="form-label">Employee ID:</label></h5>
									<div class="form-outline mb-4">
									<input type="text" name="id" placeholder="EmployeeID" class="form-control form-control-lg">
</div>
								</div>
								<div class="form-group">
								<h5 style="font-family: serif;  font-size: 16px;"><label class="form-label">Password:
									</label></h5>
									<input type="password" name="passwd" placeholder="Password" class="form-control form-control-lg">
								</div>
								<div class="form-group">
								<div class="text-center text-lg-start mt-4 pt-2">
									<button type="submit" class="btn btn-primary btn-md" style="padding-left: 1.5rem; padding-right: 1.5rem; font-weight: bold; font-size:16px; font-family:Sans-serif, Verdana;" name="submit">Login</button>
									</div>
								</div>

							</form>
						</div>
                    </div>
</div>
		</section>

<script src="bootstrap/js/bootstrap.bundle.min.js" type="text/javascript"></script>
	</body>
</html>
