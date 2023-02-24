<?php 
	session_start();

	// variable declaration
	$id = "";
	$errors = array(); 
	$_SESSION['success'] = "";

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'cms_db');

	if (isset($_POST['login_user1'])) {
		$id = mysqli_real_escape_string($db, $_POST['id']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($id)) {
			array_push($errors, "Admin Id  is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			// $password = md5($password);
			$query = "SELECT * FROM admin WHERE id='$id' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
				$_SESSION['success'] = "You are now logged in";
				// echo '<script>alert("Welcome to Geeks for Geeks")</script>';
				header('Location:admin_studentdetail.php');
				
				
			}else {
				array_push($errors, "Wrong admin_Id/password combination");
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin-Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</head>
<body>

	<div class="header">
		<h2>Admin Login</h2>
	</div>
	
	<form method="post" action="login2.php">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Admin Id</label>
			<input type="text" name="id">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="button" name="login_user1">Login</button>
		</div>
	</form>


</body>
</html>