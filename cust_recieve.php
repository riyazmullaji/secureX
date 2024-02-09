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
            <?php
$customer_id = $_SESSION['customer_Id'];
$sql = "SELECT * FROM pending_transfers_$customer_id WHERE status = 'pending' ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display the table if there are pending transactions
    echo '
    <table>
        <th>#</th>
        <th>Date</th>
        <th>Transaction Id</th>
        <th>Description</th>
        <th>Amount</th>
        <th>Action</th>';

    $Sl_no = 1;
    // Loop through each row in the result set
    while ($row = $result->fetch_assoc()) {
        // Output the data in HTML table row format
        echo '
        <tr>
            <td>' . $Sl_no++ . '</td>
            <td>' . $row['Date_added'] . '</td>
            <td>' . $row['Transaction_id'] . '</td>
            <td>' . $row['Description'] . '</td>
            <td>₹' . $row['amount'] . '</td>
            <td><button class="receive-btn" onclick="promptForSecureCode(' . $row['id'] . ', ' . $row['amount'] . ')">Receive</button></td>
        </tr>';
    }

    echo '</table>';
} else {
    // Display a message if there are no pending transactions
    echo '<p>No pending transactions at the moment.</p>';
}
?>

<script>
    function promptForSecureCode(id, amount) {
        var secureCode = prompt("Enter Secure Code for Transaction ID: " + id + "\nAmount: ₹" + amount);
        // Add logic to handle the secure code, e.g., send it to the server for verification
        if (secureCode) {
            // You can perform an AJAX request or other logic here to handle the secure code
            // Example: sendSecureCodeToServer(id, secureCode);
            alert("Secure Code entered: " + secureCode);
        }
    }
</script>



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
