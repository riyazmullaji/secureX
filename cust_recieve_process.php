<?php
ob_start();
include 'db_connect.php';


if ($_SESSION['customer_login'] != true) {
    header('location:customer_login.php');
    return 0;
}

if (isset($_POST['receive-btn'])) {
    if (empty($_POST['Transaction_id']) || empty($_POST['beneficiary_ac_no']) || empty($_POST['secure_code'])) {
        echo '<script>alert("All fields are required.")</script>';
    } else {
        $transaction_id = $_POST['Transaction_id'];
        $beneficiary_ac_no = $_POST['beneficiary_ac_no'];
        $secure_code = $_POST['secure_code'];

    
    // Get account number
    $ac_no = $_SESSION['Account_No'];
    
    // Query to find the beneficiary details from the sender's account
    $sql = "SELECT * FROM beneficiary_$beneficiary_ac_no WHERE Beneficiary_ac_no = '$ac_no' AND secure_code = '$secure_code'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Correct secure code
        
        $sql = "SELECT * FROM pending_transfers_$ac_no WHERE Transaction_id = '$transaction_id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $trnsf_amount = $row['Amount'];
        
            $sql = "SELECT * FROM bank_customers WHERE Account_no = '$ac_no'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $receiver_ac_no = $row['Account_no'];
            $receiver_custmr_id = $row['Customer_ID'];
            $receiver_name = $row['Username'];
            $receiver_ifsc = $row['IFSC_Code'];
            $receiver_mob = $row['Mobile_no'];
            $receiver_netbal = $row['Current_Balance'] + $trnsf_amount;
            $receiver_passbk = "passbook_".$receiver_custmr_id;
            
            // Senders Details required for transaction 
            $sql = "SELECT * FROM bank_customers WHERE Account_no = '$beneficiary_ac_no'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $sender_custmr_id = $row['Customer_ID'];
            $sender_name = $row['Username'];
            $sender_ifsc = $row['IFSC_Code'];
            $sender_mob = $row['Mobile_no'];
            $sender_ac_no = $row['Account_no'];
            $sender_netbal = $row['Current_Balance'] - $trnsf_amount;
            $sender_passbk = "passbook_".$sender_custmr_id;
            
            $conn->autocommit(FALSE);

            $sql1 = "UPDATE bank_customers SET Current_Balance = '$receiver_netbal' WHERE bank_customers.Account_no = '$receiver_ac_no'";
            $sql2 = "UPDATE bank_customers SET Current_Balance ='$sender_netbal' WHERE bank_customers.Account_no = '$sender_ac_no'";
            $sql3 = "DELETE FROM pending_transfers_$ac_no WHERE Transaction_id = '$transaction_id'";
            
            // Sender's Transaction Description
            $Transac_description = $receiver_name ."/".$receiver_ac_no."/".$receiver_ifsc;
            
            // Insert Statement into Sender Passbook
            $sql4 = "INSERT INTO $sender_passbk (Transaction_id, Transaction_date, Description, Cr_amount, Dr_amount, Net_Balance, Remark)
                     VALUES ('$transaction_id', NOW(), '$Transac_description', '0', '$trnsf_amount', '$sender_netbal', 'Transferred')";
            
            // Receiver's Transaction Description
            $Transac_description = $sender_name."/".$sender_ac_no."/".$sender_ifsc;
            
            // Insert Statement into Receiver Passbook
            $sql5 = "INSERT INTO $receiver_passbk (Transaction_id, Transaction_date, Description, Cr_amount, Dr_amount, Net_Balance, Remark)
                     VALUES ('$transaction_id', NOW(), '$Transac_description', '$trnsf_amount', '0', '$receiver_netbal', 'Received')";

            if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE && $conn->query($sql4) === TRUE && $conn->query($sql5) === TRUE) {
                $conn->commit();
                echo '<script>alert("Transaction Successful!"); location="cust_recieve.php";</script>';
            } else {
                echo "Transaction failed!\nPlease contact bank<br>".$conn->error;
                $conn->rollback();
            }
        } else {
            echo '<script>alert("Invalid Transaction ID.")</script>';
        }
    } else {
        echo '<script>alert("Incorrect Secure Code. Please try again.")</script>';
    }
} else {
    echo '<script>alert("All fields are required.")</script>';
}

$conn->close();

?>
