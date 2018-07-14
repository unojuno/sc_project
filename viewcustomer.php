<!DOCTYPE html>
<html lang="en">
<head>
    <title>Creation Center</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylesheets/proposalviews.css" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>

<?php
include "menu.php";
?>

<!-- Menu Up-->
<!-- Data-->

<?php
    /*
	$servername;
    $username;
    $password;
    $dbName;
	
	Redacted due to sensitive information.
	*/
    $id = $_POST['view'];

    $conn = new mysqli($servername, $username, $password, $dbName);
    if ($conn->connect_error){
        die("Connection failed:" . $conn->connect_error);
    }
    //echo "Connected successfully";

    $sql_select = "SELECT * FROM Customer WHERE cust_id LIKE '%$id%'";
    $select_query = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_assoc($select_query);



?>

    <div class="container-fluid">
        <br><br>
        <h3><i>View Customer</i></h3>
        <hr>

        <div class="customInput">
            <div class="container">
                <div class="row">
                    <div class="col-25">
                    </div>
                    <div class="col-75">
                    </div>
                </div>

                <?php

                    $originalDate = $row['cust_date'];
                    $newDate = date("m/d/Y", Strtotime($originalDate));
                    echo "<div class=\"row\"><div class=\"col-25\"><b>Date: </b></div><div class=\"col-75\">" . $newDate . "</div></div>";
                    echo "<div class=\"row\"><div class=\"col-25\"><b>Name: </b></div><div class=\"col-75\">" . $row['cust_fname'] . " " . $row['cust_lname'] . "</div></div>";
                    echo "<div class=\"row\"><div class=\"col-25\"><b>Email: </b></div><div class=\"col-75\">" . $row['cust_email'] . "</div></div>";
                    echo "<div class=\"row\"><div class=\"col-25\"><b>Phone Number: </b></div><div class=\"col-75\">" . $row['cust_phone'] . "</div></div>";
                    echo "<div class=\"row\"><div class=\"col-25\"><b>Address: </b></div><div class=\"col-75\">" . $row['cust_address'] . "</div></div>";
                    echo "<div class=\"row\"><div class=\"col-25\"></div><div class=\"col-75\">" . $row['cust_city'];
                    echo ", " . $row["cust_state"];
                    echo " " . $row['cust_zip'] . "</div></div>";

                ?>
            </div>
        </div>
    </div>
    <hr>
    <br><br><br><br>

</body>
</html>