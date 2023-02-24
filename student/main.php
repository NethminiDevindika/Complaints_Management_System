<?php
session_start();

// variable declaration
$Student_Id = "";
$roomno = "";
$errors = array();
$_SESSION['success'] = "";

// connect to database
$db1 = mysqli_connect('localhost', 'root', '', 'cms_db');

// REGISTER USER
if (isset($_POST['sub_user'])) {
    // receive all input values from the form
    $complaint_date = mysqli_real_escape_string($db1, $_POST['complaint_date']);
    $Student_Id = mysqli_real_escape_string($db1, $_POST['Student_Id']);
    $phoneno = mysqli_real_escape_string($db1, $_POST['phoneno']);
    $roomno = mysqli_real_escape_string($db1, $_POST['roomno']);
    $complaint_type = mysqli_real_escape_string($db1, $_POST['complaint_type']);
    $description = mysqli_real_escape_string($db1, $_POST['description']);

    // form validation: ensure that the form is correctly filled
    if (empty($Student_Id)) {
        array_push($errors, "Student_Id is required");
    }
    if (empty($complaint_type)) {
        array_push($errors, "complaint_type is required");
    }
    if (empty($roomno)) {
        array_push($errors, "Email is required");
    }
    if (empty($complaint_date)) {
        array_push($errors, "date is required");
    }

    $location = "uploads/";
    $file_new_name = date("dmy") . time() . $_FILES["file"]["name"]; // New and unique name of uploaded file
    $file_name = $_FILES["file"]["name"]; // Get uploaded file name
    $file_temp = $_FILES["file"]["tmp_name"]; // Get uploaded file temp
    $file_size = $_FILES["file"]["size"]; // Get uploaded file size

    if ($file_size > 10485760) { // Check file size 10mb or not
        echo "<script>alert('Woops! File is too big. Maximum file size allowed for upload 10 MB.')</script>";
    } else {

        // register user if there are no errors in the form
        if (count($errors) == 0) {
            $query1 = "INSERT INTO complaints (complaint_date, Student_Id, phoneno, roomno, complaint_type, description, file) 
					  VALUES ('$complaint_date','$Student_Id','$phoneno', '$roomno', '$complaint_type','$description', '$file_name')";
                      
            $results1 = mysqli_query($db1, $query1);
            if ($results1) {
                move_uploaded_file($file_temp, $location . $file_name);    

                
              
                $_SESSION['success'] = "Your complaint is registered";
                echo "<script>alert('User Registration Completed.')</script>";
                header("location:../problem.php");
            } else {
                array_push($errors, "Wrong input");
            }
        } else {
            array_push($errors, "Wrong input");
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
<style>
body {
  background-image: url('../img/kdu-sc.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
</style> 
    <title>Complaint</title>
    
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
    
        <div class="header" style="margin-top:10px">
            <h3>Student Complaints Page</h3>
        </div>

        <form method="post" action="main.php" enctype="multipart/form-data">


            <?php include('errors.php'); ?>

            <label for="complaint_date">Date of Complaint:</label>
            <input type="date" id="complaint_date" name="complaint_date">

            <div class="input-group">
                <label>Student Id</label>
                <input type="text" name="Student_Id" value="<?php echo $Student_Id; ?>">
            </div>
            <div class="input-group">
                <label>Phone No.</label>
                <input type="text" name="phoneno">
            </div>
            <div class="input-group">
                <label>Room No.</label>
                <input type="text" name="roomno">
            </div>
            <div class="input-group">
                <label for="complaint_type">Complaint Type</label>
                <select id="complaint_type" name="complaint_type">
                    <option value="Electricity issue">Electricity issue</option>
                    <option value="Carpentry issue">Carpentry issue</option>
                    <option value="leakage issue">leakage issue</option>
                    <option value="Cleaning/housekeeping issue">Cleaning/housekeeping issue</option>
                    <option value="Mess food issue">Mess food issue</option>
                    <option value="Accommodation issue">Accommodation issue</option>
                    <option value="Classrooms issue">Classrooms issue</option>
                    <option value="Other issue">Other issue</option>
                </select>
            </div>
            <div class="input-group">
                <label for="description">Problem Description</label>
                <textarea id="description" name="description" placeholder="Write something.." rows="5"
                    cols="43"></textarea>
            </div>

            <div class="row">
                <div class="">
                    <div class="form-group">
                        Please attached your complaint
                        <input type="file" name="file" id="file">
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <button type="submit" class="button button-primary" name="sub_user">Submit</button>
                        </div>
                    </div>

                    <div class="col" style="margin-top: 15px; margin-left: 155px;">
                        <p> <a href="session.php?logout='1'" style="color: red;">Logout</a> </p>
                    </div>
                </div>
            </div>


        </form>
    

</body>

</html>