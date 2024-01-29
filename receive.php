

<html>
    <head><title>Statement</title>
    
    <link rel="stylesheet" type="text/css" href="css/cust_statement.css" />
    <style>

#customer_profile .link5{

    background-color: rgba(5, 21, 71,0.4);
    
}



<?php 
session_start();
if($_SESSION['customer_login'] != true) {
    header('location:customer_login.php');
}

include 'db_connect.php';

$customer_id=$_SESSION['customer_Id'];
$sql="SELECT * FROM bank_customers WHERE Customer_ID='$customer_id'";
$result=$conn->query($sql);
if($result->num_rows > 0)
    $row = $result->fetch_assoc();
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/customer_profile_header.css" />
        <style>
            #home, #logout, #submit {
                background-color:rgba(5, 21, 71,0.9);
                border:none;
                padding:5px;
                width:70px;
                color:white;
                cursor:pointer;
                box-shadow:2px 2px 6px rgba(5, 21, 71,0.9);
                transition-duration: 0.6s;
            }

            #home:hover, #logout:hover, #submit:hover {
                padding:10px;
            }
            .link6 {
                text-decoration: none;
                color: blue;
            }
        </style>
    </head>

    <body id="customer_profile">
        <div class="head">
            <div class="customer_details">
                <!-- User details here -->
            </div>
        </div>

        <div class="receive_money_form">
            <form action="receive_money.php" method="post">
                <label for="passkey">Enter your passkey: </label>
                <input type="password" id="passkey" name="passkey" required>
                <button type="submit" id="submit">Submit</button>
            </form>
        </div>

        <div class="links">
            <a href="#" class="link6">Link 1</a>
            <!-- Other links here -->
        </div>
    </body>
</html>
