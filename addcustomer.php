<!DOCTYPE html>
<html lang="en">
<head>
  <title>Creation Center</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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


<!--<SCRIPT LANGUAGE="JavaScript">
 function addDashes(f)
    {
       f_val = f.value.replace(/\D[^\.]/g, "");
       f.value = f_val.slice(0,3)+"-"+f_val.slice(3,6)+"-"+f_val.slice(6);
    }
</SCRIPT>
!-->

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(function () {
          
            $('#phonenumber').keydown(function (e) {
                var key = e.charCode || e.keyCode || 0;
                $text = $(this);
                if (key !== 8 && key !== 9) {
                    if ($text.val().length === 3) {
                        $text.val($text.val() + '-');
                    }
                    if ($text.val().length === 7) {
                        $text.val($text.val() + '-');
                    }
                }
                return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
            })

        });
    </script>
<?php
  
  $firstname = $lastname = $street = $city = $state = $zip = $email = $phone = $date = "";
  $errorB = $errorC = $errorD = $errorE = $errorF = $errorG = $errorH = $errorI = $errorJ = "";
  $message = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if(empty($_POST["firstname"]) || !preg_match("/^[a-zA-Z ]*$/",$_POST["firstname"])) {
          $errorB = "<div style=\"color:red;\">Missing First Name*</div>";
      }
      else {
          $firstname = $_POST["firstname"];
      }

      if(empty($_POST["lastname"]) || !preg_match("/^[a-zA-Z ]*$/",$_POST["lastname"])) {
          $errorC = "<div style=\"color:red;\">Missing Last Name*</div>";
      }
      else {
          $lastname = $_POST["lastname"];
      }

      if (empty($_POST["street"])) {
          $errorD = "<div style=\"color:red;\">Missing Street Address*</div>";
      }
      else {
          $street = $_POST["street"];
      }

      if (empty($_POST["city"])) {
          $errorE = "<div style=\"color:red;\">Missing City*</div>";
      }
      else {
          $city = $_POST["city"];
      }

      if (empty($_POST["state"])) {
          $errorF = "<div style=\"color:red;\">Missing State*</div>";
      }
      else {
          $state = $_POST["state"];
      }

      if (empty($_POST["zip"])|| strlen($_POST["zip"]) < 5) {
          $errorG = "<div style=\"color:red;\">Missing Zip*</div>";
      }
      else {
          $zip = $_POST["zip"];
      }

      if (!check_email_address($_POST["email"])) {
          $errorH = "<div style=\"color:red;\">Missing Email*</div>";
      }
      else {
          $email = $_POST["email"];
      }

      if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $_POST["phonenumber"])){
          $errorI = "<div style=\"color:red;\">Missing Phone Number*</div>";
      }
      else {
          $phone = $_POST["phonenumber"];
      }

      if (empty($_POST["date"])) {
          $errorJ = "<div style=\"color:red;\">Missing Date*</div>";
      }
      else {
          $date = $_POST["date"];
      }
  

  if(!empty($_POST["firstname"]) && !empty($_POST["lastname"]) && !empty($_POST["street"]) && !empty($_POST["city"]) && !empty($_POST["zip"]) && !empty($_POST["email"]) && !empty($_POST["phonenumber"]) && !empty($_POST["date"])) {
    /*    
    $servername;
    $username;
    $password;
    $dbName;
	
	Redacted due to sensitive information.
	*/
    $conn = new mysqli($servername, $username, $password, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Customer(cust_fname, cust_lname, cust_address, cust_city, cust_state, cust_zip, cust_email, cust_phone, cust_date)
        VALUES ('$firstname', '$lastname', '$street', '$city', '$state', '$zip', '$email', '$phone', '$date')";

    if ($conn->query($sql) === TRUE) {
        $message = "Customer Added successfully.";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
  }
}

?>



<div class="container-fluid">
<br><br>
<h3><i>Add Customer</i></h3>
<hr>

<?php
  echo "<div style=\"color:green;\"><i>$message</i></div>";
?>

<div class="customInput">
<div class="container">
  
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    
    <div class="row">
      <div class="col-25">
        <label for="date">Date</label>
      </div>
      <div class="col-75">
        <input type="date" name="date"> <?php echo $errorJ;?>
      </div>
    </div>
    
    <div class="row">
      <div class="col-25">
        <label>Name</label>
      </div>
      <div class="col-75">
        <input type="text" id="firstname" name="firstname" placeholder="First Name"><?php echo $errorB;?>
      </div>
    </div>
    
    <div class="row">
      <div class="col-25">
        <div class="spacer"></div>
      </div>
      <div class="col-75">
        <input type="text" id="lastname" name="lastname" placeholder="Last Name"><?php echo $errorC;?>
      </div>
    </div>

    <div class="spacer"></div>


    <div class="row">
      <div class="col-25">
        <label for="email">Email</label>
      </div>
      <div class="col-75">
        <input type="email" id="email" name="email" placeholder="Email"><?php echo $errorH;?>
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="phone">Phone Number</label>
      </div>
      <div class="col-75">
        <input type="text" id="phonenumber" name="phonenumber" placeholder="Phone Number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"  onblur='addDashes(this)' maxlength="12">
        <br><i>(Format: 703-123-4477)</i><?php echo $errorI;?>
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="address">Address</label>
      </div>
      <div class="col-75">
        <input type="text" id="address" name="street" placeholder="Street Address"><?php echo $errorD;?>
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <div class="spacer"></div>
      </div>
      <div class="col-75">
        <input type="text" id="city" name="city" placeholder="City"><?php echo $errorE;?>
      </div>
    </div>
    
    <div class="row">
      <div class="col-25">
        <div class="spacer"></div>
      </div>
      <div class="col-75">
        <select class="classic" name="state"><?php echo $errorF;?>
          <?php
                  
            if ($file = fopen("states.txt", "r") or die("Unable to open file!")) 
            {
              while(!feof($file)) 
              {
                $line = fgets($file);
                echo "<option name=\"$line\" value=\"$line\">$line</option>";
              }
              fclose($file);
            }
          ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <div class="spacer"></div>
      </div>
      <div class="col-75">
        <input type="text" id="zip" name="zip" placeholder="Zip"><?php echo $errorG;?>
      </div>
    </div>

    <div class="spacer"></div>
    
    <!--
    <div class="row">
      <div class="col-25">
        <label for="subject">Note</label>
      </div>
      <div class="col-75">
        <textarea id="subject" name="subject" placeholder="Notes About Your Customer" style="height:100px"></textarea>
      </div>
    </div>
    -->

    <br>

    <div class="row">
      <input type="submit" name="submit" value="Submit">
    </div>
  </form>
</div>
</div>


<hr>
</div>

<?php


function check_email_address($email) {

  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    
    return false;
  }
    
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  
  for ($i = 0; $i < sizeof($local_array); $i++) {
      if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
  ↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
  $local_array[$i])) {
        return false;
      }
    }
    
    if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
      $domain_array = explode(".", $email_array[1]);
      if (sizeof($domain_array) < 2) {
          return false; 
      }
      for ($i = 0; $i < sizeof($domain_array); $i++) {
        if
  (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
  ↪([A-Za-z0-9]+))$",
  $domain_array[$i])) {
          return false;
        }
      }
    }
    return true;
}
?>



</body>
</html>