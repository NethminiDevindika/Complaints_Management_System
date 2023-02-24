<?php
session_start();

// variable declaration
$staffname = "";
$email    = "";
$errors = array();
$_SESSION['success'] = "";

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'cms_db');

// REGISTER USER
if (isset($_POST['reg2_user'])) {
    // receive all input values from the form
    $staffname = mysqli_real_escape_string($db, $_POST['staffname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone_no = mysqli_real_escape_string($db, $_POST['phone_no']);
    $reg_date = mysqli_real_escape_string($db, $_POST['reg_date']);
    $department = mysqli_real_escape_string($db, $_POST['department']);


    // form validation: ensure that the form is correctly filled
    if (empty($staffname)) {
        array_push($errors, "Staff name  is required");
    }
    if (empty($phone_no)) {
        array_push($errors, "Phone No is required");
    }
    if (empty($department)) {
        array_push($errors, "Department name is required");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $query = "INSERT INTO staff (staffname, email, phone_no, reg_date, department) 
					  VALUES('$staffname', '$email', '$phone_no','$reg_date','$department')";
        mysqli_query($db, $query);
        $_SESSION['success'] = "Staff registered successfully ";
        echo '<script>alert("Staff Added Successfully...!")</script>';
        echo '<script>
            function myFunction() {
              document.getElementById("regform").reset();
            }
            </script>';


        //Generate XML file

        $result1 = mysqli_query($db, "Select * from staff");
        if ($result1) {
            $xml = new DOMDocument("1.0");

            // It will format the output in xml format otherwise
            // the output will be in a single row
            $xml->formatOutput = true;
            $fitness = $xml->createElement("users");
            $xml->appendChild($fitness);
            while ($row = mysqli_fetch_array($result1)) {
                $user = $xml->createElement("staff");
                $fitness->appendChild($user);

                $uid = $xml->createElement("id", $row['Staff_id']);
                $user->appendChild($uid);

                $uname = $xml->createElement("name", $row['staffname']);
                $user->appendChild($uname);

                $email = $xml->createElement("email", $row['email']);
                $user->appendChild($email);

                $password = $xml->createElement("mobileNo", $row['phone_no']);
                $user->appendChild($password);

                $description = $xml->createElement("registeredDate", $row['reg_date']);
                $user->appendChild($description);

                $file = $xml->createElement("department", $row['department']);
                $user->appendChild($file);
            }
            // echo "<xmp>".$xml->saveXML()."</xmp>";
            $xml->save("xml/report.xml");



            header('Location:register2.php');
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Complaints Management System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <Style>
        table,
        th,
        td {
            border: 5px solid black;
            border-collapse: collapse;
            font-size: 100%;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            font-size: 100%;
        }



        body {
            margin: 0;
            font-family: "Lato", sans-serif;
            font-size: 100%;
            background-image: none;
        }

        .sidebar {
            margin: 0;
            padding: 0;
            width: 200px;
            background-color: #cce6ff;
            position: fixed;
            height: 100%;
            overflow: auto;
            font-size: 100%;
            margin-top: -30px;
        }

        .sidebar a {
            display: block;
            color: black;
            padding: 16px;
            text-decoration: none;
            font-size: 100%;
        }

        .sidebar a.active {
            background-color: #3479e0;
            color: white;
            font-size: 100%;
        }

        .sidebar a:hover:not(.active) {
            background-color: #555;
            color: white;
        }

        div.content {
            margin-left: 200px;
            /* padding: 1px 16px; */
            height: 1000px;
            font-size: 100%;
        }

        @media screen and (max-width: 700px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .sidebar a {
                float: left;
            }

            div.content {
                margin-left: 0;
            }
        }

        @media screen and (max-width: 400px) {
            .sidebar a {
                text-align: center;
                float: none;
            }
        }

        form {
            font-size: 120%;
        }

        h1,
        h4 {
            color: white;
            text-align: center;
            font-weight: bold;
        }

        p {
            color: #4CAF50 !important;
        }

        .bottom {
            margin-top: 456px;

        }

        .logform {
            margin-top: 30px;
            border-radius: 20px;
            padding-left: -120px;
        }

        .header {
            width: 112%;
            margin-top: -20px;
            align-items: left;
            margin-left: -20px;
            color: white;

        }
    </Style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet"> -->


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


    <div class="sidebar">
        <a href="admin_studentdetail.php">Student Complaint Details</a>
        <a class="active" href="register2.php">Staff Registration</a>
        <div class="bottom"><a href="sessionA.php?logout='1'" style="color: red;">Logout</a></div>
    </div>

    <div style="margin-left:200px;">


        <form id="regform" name="regform" class="logform" method="post" action="register2.php">
            <div class="header">
                <h1 style="font-weight:bold">Register</h1>
            </div>
            <center>
                <br>
                <?php include('errors.php'); ?>

                <div class="input-group">
                    <label>Staff Name</label>
                    <input type="text" name="staffname" value="<?php echo $staffname; ?>">
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $email; ?>">
                </div>
                <div class="input-group">
                    <label>Phone No.</label>
                    <input type="text" name="phone_no">
                </div>
                <div class="input-group">
                    <label>Registration Date</label>
                    <input type="date" name="reg_date" value="<?php echo date("Y-m-d h:i:s"); ?>">
                </div>
                <div class="input-group">
                    <label for="department">Department</label>
                    <select id="department" name="department">
                        <option value="Electricity issue">Electricity issue</option>
                        <option value="Carpentry issue">Carpentry issue</option>
                        <option value="Leakage issue">Leakage issue</option>
                        <option value="Cleaning/housekeeping issue">Cleaning/Housekeeping issue</option>
                        <option value="Mess food issue">Mess food issue</option>
                        <option value="Accommodation issue">Accommodation issue</option>
                        <option value="Classrooms issue">Classrooms issue</option>
                        <option value="Other issue">Other issue</option>
                    </select>
                    <br>
                </div>
                <br>
                <div class="input-group">
                    <button style="margin-left: 115px;" type="submit" class="button button-primary" name="reg2_user">Add
                        to List</button>
                </div>
            </center>

        </form>
    </div>

</body>

</html>