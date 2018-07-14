  	<?php
            /*
			$servername;
            $username;
            $password;
            $dbName;
			
			Redacted due to sensitive information.
			*/
			
            $conn = new mysqli($servername, $username, $password, $dbName);

            // if ($conn->connect_error) {
            //     die("Connection failed: " . $conn->connect_error);
            // }
            // else echo "Connected successfully<br><br>";
        ?>

        
        <form class="example" action="customer.php" method="post" style="float:left;max-width:450px;">
            <input type="text" placeholder="Search.." name="search">
            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
        </form>
    
        
        <?php  
        	
        	// collect
        	if(isset($_POST['search'])){
        		$searchq = $_POST['search'];
        		$searchq = preg_replace("#[^0-9a-z]#i","",$searchq);
        		$sql = "SELECT * FROM Customer WHERE cust_fname LIKE '%$searchq%' OR cust_lname LIKE '%$searchq%'";
        		$query = mysqli_query($conn, $sql);
        		$count = mysqli_num_rows($query);
        		if($searchq == ""){
        			$output = "<br><br><br><br>No Search Entered";
        		}
        		else{
        			if($count == 0){
        			$output = "<br><br><br><br>No Results";
        			}
        			else{
                        $output = "<br><br><br><br>";
        				while($row = mysqli_fetch_array($query)){
        					
                            echo "<tr><td>" . $row["cust_fname"].
                              "<td>" . $row["cust_lname"]. "</td><td>" . $row["cust_email"] . "</td><td>" . 
                              "<form method=\"post\" action=\"proposals.php\">
                                <input type=\"submit\" name=\"submit\" value=\"Show\" />
                                <input type=\"hidden\" name=\"search\" value=".$row["cust_id"]."/>
                                </form>". "</td></tr>"; 
    
        				}
        			}
        		}
        	}

        ?>