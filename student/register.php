<?php
session_start();

// variable declaration
$Student_Id = "";
$username = "";
$email    = "";
$errors = array();
$_SESSION['success'] = "";


// connect to database
$db = mysqli_connect('localhost', 'root', '', 'cms_db');

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $Student_Id = mysqli_real_escape_string($db, $_POST['Student_Id']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $roomno = mysqli_real_escape_string($db, $_POST['roomno']);

    // form validation: ensure that the form is correctly filled
    if (empty($Student_Id)) {
        array_push($errors, "Student_Id is required");
    }
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }

    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database
        $query = "INSERT INTO registration (Student_Id, username, email, password, roomno) 
					  VALUES('$Student_Id','$username', '$email', '$password','$roomno')";
        mysqli_query($db, $query);

        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";


        //Generate XML file

        $result1 = mysqli_query($db, "Select * from registration");
        if ($result1 > 0) {
            $xml = new DOMDocument("1.0");

            // It will format the output in xml format otherwise
            // the output will be in a single row
            $xml->formatOutput = true;
            $fitness = $xml->createElement("users");
            $xml->appendChild($fitness);
            while ($row = mysqli_fetch_array($result1)) {
                $user = $xml->createElement("student");
                $fitness->appendChild($user);

                $uid = $xml->createElement("Student_Id", $row['Student_Id']);
                $user->appendChild($uid);

                $uname = $xml->createElement("username", $row['username']);
                $user->appendChild($uname);

                $email = $xml->createElement("email", $row['email']);
                $user->appendChild($email);

                $password = $xml->createElement("password", $row['password']);
                $user->appendChild($password);

                $description = $xml->createElement("roomNumber", $row['roomno']);
                $user->appendChild($description);
            }
            // echo "<xmp>".$xml->saveXML()."</xmp>";
            $xml->save("xmlStu/report.xml");


            header('location: main.php');
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Complaints Management System</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <style>
        h1,
        h4 {
            /* color: #4CAF50; */
            text-align: center;
        }

        p {
            color: #4CAF50 !important;
        }

        body {
            background-image: url('../img/kdu-sc.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</head>

<body>

    <div class="header" style="margin-top:10px">
        <h2>Sign Up</h2>
    </div>

    <form method="post" action="register.php">

        <?php include('errors.php'); ?>

        <div class="input-group">
            <label>Student Id</label>
            <input type="text" name="Student_Id" value="<?php echo $Student_Id; ?>">
        </div>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password_1">
        </div>
        <div class="input-group">
            <label>Confirm password</label>
            <input type="password" name="password_2">
        </div>
        <div class="input-group">
            <label>Room No.</label>
            <input type="text" name="roomno">
        </div>
        <div class="input-group">
            <button type="submit" class="button" name="reg_user">Register</button>
        </div>
        <p>
            Already a member? <a href="login.php">Sign in</a>
        </p>
    </form>
</body>

</html>