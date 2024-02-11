<html>
	<head><title>OTP Verification</title>
	<link rel="stylesheet" type="text/css" href="css/fund_transfer_otp.css">
	</head>
<body>
	<?php include 'header.php' ; 
			include 'customer_profile_header.php'; 
			$sender_mob = $_SESSION['sender_mob'];
			$hidden_mob_no = substr($sender_mob, 0, 3)."XXXX".substr($sender_mob, 7, 10);
			$ref_no = $_SESSION['ref_no'];
	
	?>
	<label class="OTP_msg">OTP with Ref no.<?php echo $ref_no." sent to <b>".$hidden_mob_no."</b> please verify to complete your transaction <br><br> *OTP :".$_SESSION['fund_trnsfer_otp']."" ; ?></label>

		<div class="fund_transfer_otp_container">
		<form method="post">
		<input type="text" name="otpcode" placeholder="OTP Code">
		<input type="submit" name="verify-btn" value="Verify">
		</form>
		</div>
	<?php include 'footer.php' ;  ?>
</body>
</html>

<?php 
	
?>


<?php
echo $_SESSION['fund_trnsfer_otp'];
if (isset($_POST['verify-btn'])) {

    $otpcode = $_POST['otpcode'];

    if ($otpcode == $_SESSION['fund_trnsfer_otp']) {

        $sender_ac_no = $_SESSION['Account_No'];    // Sender's Account_No     //SESSION2

        $trnsf_amount = $_SESSION['trnsf_amount'];  // Transfer Amount        //SESSION3

        // Receiver's details required for transaction
        $beneficiary_ac_no = $_SESSION['beneficiary_ac_no'];                   //SESSION4

        include 'db_connect.php';

        // Fetch Receiver's details
        $sql_receiver = "SELECT * FROM bank_customers WHERE Account_no = '$beneficiary_ac_no'";
        $result_receiver = $conn->query($sql_receiver);

        if ($result_receiver->num_rows > 0) {
            $row_receiver = $result_receiver->fetch_assoc();
            $receiver_custmr_id = $row_receiver['Customer_ID'];
            $receiver_name = $row_receiver['Username'];
            $receiver_ifsc = $row_receiver['IFSC_Code'];
            $receiver_mob = $row_receiver['Mobile_no'];
            $receiver_netbal = $row_receiver['Current_Balance'] + $trnsf_amount;
            $receiver_passbk = "passbook_" . $receiver_custmr_id;

            // Fetch Sender's details
            $sql_sender = "SELECT * FROM bank_customers WHERE Account_no = '$sender_ac_no'";
            $result_sender = $conn->query($sql_sender);

            if ($result_sender->num_rows > 0) {
                $row_sender = $result_sender->fetch_assoc();
                $sender_custmr_id = $row_sender['Customer_ID'];
                $sender_name = $row_sender['Username'];
                $sender_ifsc = $row_sender['IFSC_Code'];
                $sender_mob = $row_sender['Mobile_no'];
                $sender_ac_no = $row_sender['Account_no'];
                $sender_netbal = $row_sender['Current_Balance'] - $trnsf_amount;
                $sender_passbk = "passbook_" . $sender_custmr_id;

                // Set autocommit to off
                $conn->autocommit(FALSE);

                // Insert into pending_transactions_.$receiver_custmr_id
                $sql_pending = "INSERT INTO pending_transfers_" . $receiver_custmr_id . "
                                    (Beneficiary_name, Beneficiary_ac_no, IFSC_code, Account_type, amount, status, Date_added)
                                VALUES
                                    ('$sender_name', '$sender_ac_no', '$sender_ifsc', 'pending', '$trnsf_amount', 'pending', NOW())";

                if ($conn->query($sql_pending) === TRUE) {

                    // Commit the transaction
                    $conn->commit();

                    // Notify user about successful transaction
					echo '<script>alert("Transaction initiated successfully!\nPlease wait for the receiver to verify the transaction code.")</script>';

                    header("Location: fund_transfer.php");
                } else {
                    // Rollback the transaction if any error occurs
                    $conn->rollback();
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Sender details not found";
            }
        } else {
            echo "Receiver details not found";
        }
    } else {
        echo '<script>alert("Incorrect OTP\n\nPlease try again")</script>';
    }
}


?>
