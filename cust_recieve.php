

<html>
    <head><title>Receive</title>
    
    <link rel="stylesheet" type="text/css" href="css/receive.css" />
    <style>

#customer_profile .link6{

    background-color: rgba(5, 21, 71,0.4);
    
}

</style>
    
      <?php include 'header.php' ; ?></head>
<body>
    
	
        <?php include 'customer_profile_header.php' ?>	
		
<?php 

if($_SESSION['customer_login'] == true)
{
	


}	

	else{
   
    header('location:customer_login.php');

	}

?>
		
		
           
        <div class="cust_receive_container_head">
         <label class="heading">Receive Money</label>
         </div>
         <div class="cust_receive_container">
         <div class="cust_receive">
                
                <table>
                <th>#</th>
                <th>Date</th>
                <th>Transaction Id</th>
                <th>Description</th>
                <th>Cr</th>
                <th>Amount</th>
                <th>Receive Money</th>
                <?php

$cust_id = $_SESSION['customer_Id'];
$sql = "SELECT * FROM passbook_$cust_id WHERE Dr_amount = '0' ORDER BY Id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $Sl_no = 1; 
    // Loop through each row in the result set
    while ($row = $result->fetch_assoc()) {
        // Check if Dr_amount is equal to zero
        if ($row['Dr_amount'] == '0') {
            // Output the data in HTML table row format
            echo '
            <tr>
                <td>'.$Sl_no++.'</td>
                <td>'.$row['Transaction_date'].'</td>
                <td>'.$row['Transaction_id'].'</td>
                <td>'.$row['Description'].'</td>
                <td>'.$row['Cr_amount'].'</td>
                <td>₹'.$row['Net_Balance'].'</td>
                <td> <form method="post">
                <input type="text" name="Secure_code" placeholder="Enter SecureCode">
                <input type="submit" name="receive-btn" value="Receive">
                </form></td>
            </tr>';
        }
    }
}


?>
                </table>
    </div>

            </div>
    </div>
 <br>
    </body>
    <?php include 'footer.php' ; ?>
</html>