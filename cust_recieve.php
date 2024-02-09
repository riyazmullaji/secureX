<html>
    <head>
        <title>Receive</title>
        <link rel="stylesheet" type="text/css" href="css/receive.css" />
        <style>
            #customer_profile .link6 {
                background-color: rgba(5, 21, 71, 0.4);
            }
        </style>
        <?php include 'header.php'; ?>
    </head>
    <body>
        <?php include 'customer_profile_header.php'; ?>
        <?php
        if ($_SESSION['customer_login'] == true) {

        } else {
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
$sql = "SELECT * FROM passbook_$cust_id WHERE Dr_amount = '0' AND Description NOT LIKE 'Cash Deposit%' AND Description != 'Account Opening' ORDER BY Id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $Sl_no = 1;
    // Loop through each row in the result set
    while ($row = $result->fetch_assoc()) {
        // Check if Dr_amount is equal to zero and exclude certain descriptions
        if ($row['Dr_amount'] == '0' && strpos($row['Description'], 'Cash Deposit') !== 0 && $row['Description'] != 'Account Opening') {
            // Output the data in HTML table row format
            echo '
            <tr>
                <td>' . $Sl_no++ . '</td>
                <td>' . $row['Transaction_date'] . '</td>
                <td>' . $row['Transaction_id'] . '</td>
                <td>' . $row['Description'] . '</td>
                <td>' . $row['Cr_amount'] . '</td>
                <td>₹' . $row['Net_Balance'] . '</td>
                <td><button class="receive-btn" onclick="promptForSecureCode(' . $row['Transaction_id'] . ')">Receive</button></td>
            </tr>';
        }
    }
}
?>

                </table>
            </div>
        </div>
        <script>
            function promptForSecureCode(transactionId) {
                var secureCode = prompt("Enter SecureCode:");
                if (secureCode !== null) {
                    // Perform further processing or submit the form with secureCode and transactionId
                    // You can use AJAX to submit the form data to the server for verification
                    // For simplicity, let's just log the values for now
                    console.log("Transaction ID:", transactionId);
                    console.log("SecureCode:", secureCode);
                }
            }
        </script>
        <?php include 'footer.php'; ?>
    </body>
</html>
