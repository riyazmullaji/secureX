<?php
ob_start();
include 'header.php';
include 'customer_profile_header.php' ;
if($_SESSION['customer_login'] != true)
{
	header('location:customer_login.php');
	return 0;
}

$acc_no = $_SESSION['Account_No'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Receive</title>
    <link rel="stylesheet" type="text/css" href="css/receive.css"/>
    <style>
        #customer_profile .link6 {
            background-color: rgba(5, 21, 71, 0.4);
        }
        
        .cust_receive_form {
            text-align: center;
            margin-top: 20px;
            border-top-right-radius: 20px;
            border-bottom-left-radius: 20px;
            background-color: rgba(0, 0, 0, 0.2);
            width: 350px;
            padding: 20px;
            margin: 0 auto;
            box-shadow: 2px 2px 5px black;
        }

        .cust_receive_form h2 {
            font-size: 2.5vh;
        }

        .cust_receive_form form {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: white;
            border-radius: 8px;
            width: 300px;
            padding: 20px;
            box-shadow: 2px 2px 2px rgba(126, 126, 126, 0.5);
        }

        .cust_receive_form form label {
            margin-bottom: 5px;
            font-family: verdana, "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 11px;
            font-weight: bold;
            color: #4a60d0;
        }

        .cust_receive_form form input[type="text"], 
        .cust_receive_form form input[type="password"] {
            margin-bottom: 10px;
            padding: 10px;
            width: 200px;
            border: 1px solid white;
            border-bottom: 2px solid rgba(68, 68, 68, 0.3);
            border-radius: 4px;
            color: rgba(44, 44, 44, 0.9);
            font-size: 16px;
            font-weight: bold;
        }

        .cust_receive_form form .receive-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .cust_receive_form form .receive-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="cust_receive_container_head">
        <label class="heading">Receive Money</label>
    </div>
    <div class="cust_receive_container">
        <div class="cust_receive">
        <?php
            $sql = "SELECT * FROM pending_transfers_$acc_no WHERE status = 'pending' ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '
                <table>
                    <th>#</th>
                    <th>Transaction ID</th>
                    <th>Beneficiary Name</th>
                    <th>Beneficiary Ac. Number</th>
                    <th>Amount</th>
                    <th>Date</th>';

                $Sl_no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <tr>
                        <td>' . $Sl_no++ . '</td>
                        <td>' . $row['Transaction_id'] . '</td>
                        <td>' . $row['Beneficiary_name'] . '</td>
                        <td>' . $row['Beneficiary_ac_no'] . '</td>
                        <td>₹' . $row['Amount'] . '</td>
                        <td>' . $row['Date_added'] . '</td>
                    </tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No pending transactions at the moment.</p>';
            }
            ?>
        </div>

        <div class="cust_receive_form">
            <h2>Receive</h2>
            <form method="post">
                <label for="Transaction_id">Transaction ID</label>
                <input type="text" name="Transaction_id" required />
                
                <label for="beneficiary_ac_no">Beneficiary Account Number</label>
                <input type="text" name="beneficiary_ac_no" required />
                
                <label for="secure_code">Secure Code</label>
                <input type="password" name="secure_code" required />
                
                <input class="receive-btn" type="submit" name="receive-btn" value="RECEIVE" />
            </form>
        </div>
    </div>
</body>
</html>

<?php include 'cust_recieve_process.php'?>
