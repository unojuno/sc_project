<!DOCTYPE html>
<html lang="en">
<head>
  <title>Creation Center</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="stylesheets/proptable.css" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
</head>
<body>

<?php
  include "menu.php";
?>

<?php
	/*
	$servername;
	$username;
	$password;
	$dbName;
	
	Redacted due to sensitive information.
	*/
	$connection = new mysqli($servername, $username, $password, $dbName);
		if ($connection->connect_error) {
			die("Connection failed: " . $connection->connect_error);
		}



    if(isset($_POST['propSearch'])) {
        $propSearch = $_POST['propSearch'];
        $propSearch = preg_replace("#[^0-9a-z]#i","",$propSearch);
        $sql = "SELECT Proposal.prop_id, Proposal.prop_start, Proposal.prop_end, Proposal.cust_id, Project.proj_id, Project.proj_desc, Project.proj_cost FROM Proposal JOIN Joblist ON Proposal.prop_id = Joblist.prop_id JOIN Project ON Project.proj_id = Joblist.proj_id WHERE Proposal.prop_id LIKE '$propSearch'";

        $query = mysqli_query($connection, $sql);
        $count = mysqli_num_rows($query);
        $proposal = "";
        $customer_id = "";
        $compName = "E&amp;A Contractors";


        while($row = mysqli_fetch_array($query)) {
            $originalDate = $row["prop_start"];
            $endDate = $row["prop_end"];
            $proposal = "<b>Proposal: </b>" .$row["prop_id"];
            $customer_id = $row["cust_id"];
        }


        $sql2 = "SELECT cust_fname, cust_lname, cust_email, cust_address, cust_state, cust_city, cust_zip, cust_phone FROM Customer WHERE cust_id = '$customer_id'";
        $query2 = mysqli_query($connection, $sql2);
        $count2 = mysqli_num_rows($query2);
        $output2 = "";

        $custFname = "";
        $custLname = "";

        while($row2 = mysqli_fetch_array($query2)) {

            $custFname = $row2["cust_fname"];
            $custLname = $row2["cust_lname"];
            $custEmail = $row2["cust_email"];
            $custAddress = $row2["cust_address"];
            $custState = $row2["cust_state"];
            $custCity = $row2["cust_city"];
            $custZip = $row2["cust_zip"];
            $custPhone = $row2["cust_phone"];

            $output2 .= $custFname . " " . $custLname
                . "<br>" . $custAddress
                . "<br>" . $custCity . ", " . $custState . ", " . $custZip
                . "<br>" . $custEmail
                . "<br>" . $custPhone;
        }


        $sql3 = "SELECT Proposal.prop_id, Proposal.prop_start, Proposal.cust_id, Project.proj_id, Project.proj_desc, Project.proj_cost FROM Proposal JOIN Joblist ON Proposal.prop_id = Joblist.prop_id JOIN Project ON Project.proj_id = Joblist.proj_id WHERE Proposal.prop_id LIKE '$propSearch'";

        $query3 = mysqli_query($connection, $sql3);
        $count3 = mysqli_num_rows($query3);
        $total = 0.0;
        $outputDesCost = "";

        while($row = mysqli_fetch_array($query3)) {
            $outputDesCost .= "<tr><td width='50%'>". $row["proj_desc"]. "</td>". "<td width='50%'> $". $row["proj_cost"]. "</td></tr>";
            $total += $row["proj_cost"];

        }

        $formatTotal = number_format($total, 2, '.', ',');
        $formatTotal = "$" . $formatTotal;

        $fileName = "Proposal_". $propSearch . "_" . $custFname . $custLname;
        $newDate = date("m/d/Y", Strtotime($originalDate));
        $endDate = date("m/d/Y", Strtotime($endDate));
        $dataSaved = "";
}


if(isset($_POST["create_pdf"]))
{
    $fileName = $_POST["fileName"];
    $proposalName = $_POST["proposalName"];
    $theDate = $_POST["newDate"];
    $customerInfo = $_POST["customerInfo"];
    $desCostData = $_POST["descCostData"];
    $newTotal = $_POST["total"];

    //$proposalName = "hello world";
    require('tcpdf/tcpdf.php');
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle("$fileName");
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $obj_pdf->SetDefaultMonospacedFont('helvetica');
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
    $obj_pdf->setPrintHeader(false);
    $obj_pdf->setPrintFooter(false);
    $obj_pdf->SetAutoPageBreak(TRUE, 10);
    $obj_pdf->SetFont('helvetica', '', 12);
    $obj_pdf->AddPage();
    $content = '';

    $content .= ' 
      <table border="1" cellspacing="0" cellpadding="5">  
           <tr>  
                <th width="100%"><img src="assets/eacontractors_logo_tranText.png" width="200px"></th>
           </tr> 
           <tr>
                <td width="50%"><i>'.$proposalName.'</i></td>
                <td width="50%"><b>Date: </b>'.$theDate.'</td>
           </tr> 
           <tr>
               <td width="50%">E&A Contractors<br>2645 Conquest Place
                <br>Herndon, VA 20171
                <br>ea-contractors@hotmail.com
                <br>703-476-1033
               </td>
               <td width="50%">'.$customerInfo.'</td>
           </tr>
      ';

    $content .= '<br><br> 
           <tr>  
                <th width="50%"><b>Description</b></th>
                <th width="50%"><b>Price</b></th>
           </tr> 
           '.$desCostData.'
           <tr>
               <td><b>Total: </b></td>
                <td><b>'.$newTotal.'</b>
                </td>
           </tr>
      ';

    $content .= '
    <tr>
        <td width="100%">
            <h3>Acceptance of Proposal</h3>
            <p>The above prices, specifications, and conditions are satisfactory and are hereby accepted.
                You are authorizing us to do the work as specified. Final payment is due upon completion of work. Deliverance
                guaranteed: we will work at your schedule and convenience. Any alteration from above specifications will involve
                extra costs. We accept all major credit card payments.</p><br>
        </td>
    </tr>
    ';

    $content .= '
        <tr>
                <td width="50%">Respectfully Submitted from:<br><br>
                </td>
                <td width="50%">Date Signed: <br>
                </td>
            </tr>
            <tr>
                <td width="50%">Accepted by (Sign):<br><br>

                </td>
                <td width="50%">Print Full Name:<br>
                </td>
        </tr>
    ';

    $content .= '</table>';
    $obj_pdf->writeHTML($content);

    // Clean any content of the output buffer
    ob_end_clean();
    $obj_pdf->Output($fileName.'.pdf', 'I');
}

?>


<br>
<br>

<div class="container-fluid">
    <table style="overflow:auto; border:none">
        <tr>
            <th style="float:right;border-bottom:none;">
                <form method="post" action="finishdate.php">
                    <button class="btn btn-primary" type="submit" name="submit">Finish Date</button>
                    <input type="hidden" name="custID" value="<?php echo $propSearch ?>" />
                </form>
            </th>
            <th style="float:right;border:none;">
                <form method="post" action="editproposal.php">
                    <button class="btn btn-primary" type="submit" name="submit">Edit Proposal</button>
                    <input type="hidden" name="edit" value="<?php echo $propSearch; ?>" />
                </form>

            </th>
            <th style="float:right;border:none;">
                <form method="post" action="deleteProposal.php">
                    <button class="btn btn-danger" type="submit" name="submit" onclick="return myFunction(this)">Delete Proposal</button>
                    <input type="hidden" name="deletePro" value="<?php echo $propSearch; ?>" />

                    <script>
                        function myFunction() {
                            if(confirm("Are you sure you want to delete this proposal")){
                                document.forms[0].submit();
                            }
                            else
                            {
                                return false;
                            }
                        }
                    </script>
                </form>
            </th>
            <th style="float:right;border:none;">
                <form method="post">
                    <input type="submit" name="create_pdf" class="btn btn-success" value="Render to PDF" />
                    <input type="hidden" name="fileName" value="<?php echo $fileName; ?>" />
                    <input type="hidden" name="savedData" value="<?php echo $dataSaved; ?>" />
                    <input type="hidden" name="proposalName" value="<?php echo $proposal; ?>" />
                    <input type="hidden" name="newDate" value="<?php echo $newDate; ?>" />
                    <input type="hidden" name="customerInfo" value="<?php echo $output2; ?>" />
                    <input type="hidden" name="descCostData" value="<?php echo $outputDesCost; ?>" />
                    <input type="hidden" name="total" value="<?php echo $formatTotal; ?>" />
                </form>
            </th>
        </tr>
    </table>
</div>


<br>



<div class="container-fluid">

<h3><i>  	

</i></h3><hr>

    <div id="content">

    <div class="myStyles">
    <table>
        <tr>
            <td>
                <?php

                if($proposal == "")
                {
                    echo "<i>No Proposals Entered Yet.</i>";
                }
                else
                {
                    echo "<i><h3>" . $proposal . "</h3></i>";
                }
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td><b>Start Date: </b><br>
                <?php
                    echo $newDate;
                ?>
            </td>
          <td><br><b>Finish Date: </b><br>
            <?php
                $defaultDate = "1970-01-01";
                $defaultDate = date("m/d/Y", Strtotime($defaultDate));
                if($endDate > $defaultDate)
                {
                    echo $endDate;
                }
                else{
                    echo "No End Date";
                }
            ?>
            </td>
        </tr>
        <tr>
            <td>E&A Contractors
                <br> 2645 Conquest Place
                <br> Herndon, VA 20171
                <br> ea-contractors@hotmail.com
                <br>703-476-1033
            </td>
            <td>
                <?php
                    echo $output2;
                ?>
            </td>
        </tr>
    </table>
        <br><br>
        <table>
        <tr>
            <th>Description</th>
            <th>Price</th>
        </tr>
            <?php
                echo $outputDesCost;
            ?>

            <tr>
            <td><b>Total: </b></td>
            <td><b>
                <?php
                    echo $formatTotal;
                ?>
                </b>
            </td>
            </tr>
        </table>
        <br><br>
</div>
</div>
</div>
<hr>

<br><br><br><br>
</body>
</html>