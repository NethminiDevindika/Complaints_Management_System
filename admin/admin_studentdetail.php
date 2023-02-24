<?php
$con = mysqli_connect("localhost", "root", "", "cms_db");
$res=mysqli_query($con, "SELECT aa.Student_Id AS Student_Id, aa.roomno, aa.phoneno, aa.complaint_date , aa.complaint_type, aa.description, bb.staffname, aa.file
FROM complaints AS aa 
INNER JOIN staff AS bb
ON aa.complaint_type = bb.department");

if(!empty($_GET['file']))
{
	$filename = basename($_GET['file']);
	$filepath = '../student/uploads/' . $filename;
	if(!empty($filename) && file_exists($filepath)){

//Define Headers
		header("Cache-Control: public");
		header("Content-Description: FIle Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Type: application/zip");
		header("Content-Transfer-Emcoding: binary");

		readfile($filepath);
		exit;

	}
	else{
		echo "This File Does not exist.";
	}
}


?>
<!doctype html>
<html lang="en">

<head>
    <Style>
    table,
    th,
    td {
        border: 1px solid white;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 5px;
        text-align: left;
    }

    body {
        margin: 0;
        font-family: "Lato", sans-serif;
        color: #3479e0;

    }

    .sidebar {
        margin: 0;
        padding: 0;
        width: 200px;
        background-color: #cce6ff;
        position: fixed;
        height: 100%;
        overflow: auto;
        margin-top: -20px;

    }

    .sidebar a {
        display: block;
        color: black;
        padding: 16px;
        text-decoration: none;
    }

    .sidebar a.active {
        background-color: #3479e0;
        color: white;
    }

    .sidebar a:hover:not(.active) {
        background-color: #555;
        color: white;
    }

    div.content {
        margin-left: 200px;
        padding: 1px 16px;
        height: 1000px;
    }

    @media screen and (max-width: 700px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: fixed;

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

    h1,
    h4 {
        color: #3479e0;
    }

    .bottom {
        margin-top: 456px;

    }
    </Style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin-CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>
    <div class="sidebar">
        <a class="active" href="admin_studentdetail.php">Student Complaint Details</a>
        <a href="register2.php">Staff Registration</a>
        <div class="bottom"><a href="sessionA.php?logout='1'" style="color: red;">Logout</a></div>
    </div>

    <div>
        <div style="margin-top:20px; margin-left:200px;">
            <h1 style="font-weight:bold">Student Complaints Table</h1>
        </div>

        <div class="container" style="margin-top:20px; margin-left:200px;">

            <table class="table table-striped table-hover">
                <thead>
                    <tr class="table-dark">
                        <th>Students Id</th>
                        <th>Room No</th>
                        <th>Phone No</th>
                        <th>Complaint Date</th>
                        <th>Complaint Type</th>
                        <th>Description</th>
                        <th>Staff Name</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row=mysqli_fetch_assoc($res)){?>
                    <tr>
                        <td><?php echo $row['Student_Id']?></td>
                        <td><?php echo $row['roomno']?></td>
                        <td><?php echo $row['phoneno']?></td>
                        <td><?php echo $row['complaint_date']?></td>
                        <td><?php echo $row['complaint_type']?></td>
                        <td><?php echo $row['description']?></td>
                        <td><?php echo $row['staffname']?></td>
                        <td><a href="admin_studentdetail.php?file=<?php echo $row['file']?>"><?php echo $row['file']?></a></td>
                    </tr>
                    <?php } ?>
                    </thead>
            </table>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
        <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script>
        $(document).ready(function() {
            $('.table').DataTable();
        });
        </script>
    </div>

</body>

</html>