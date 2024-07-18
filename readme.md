### Securexx

## Overview
The Securexx is a web-based application designed to streamline banking operations. It features functionalities such as customer registration, fund transfers, beneficiary management, and secure transactions. One of its standout features is the ability for users to securely receive money with a two-step verification process. This ensures enhanced security by requiring the recipient to enter a secure code set by the sender.

## Distinct Features
- **Receiving Money**: Unique feature allowing customers to receive money through a secure process. The sender initializes the payment, and the receiver must enter a secure code set by the sender to complete the transaction.
-**Two-Step Verification** for Payments: Enhanced security for fund transfers, requiring both OTP (One-Time Password) and secure code validation.

## Other Features
- **Customer and Staff Management**: Secure login for customers and staff members.
- **Account Management**: Register new customers, manage profiles, and handle account approvals.
- **Fund Transfer**: Transfer funds between accounts securely.
- **Beneficiary Management**: Add, view, and delete beneficiaries for quick fund transfers.
- **Password Management**: Allow customers to change passwords and recover forgotten passwords securely.


## How to Run Locally in XAMPP

### Prerequisites
- Install [XAMPP](https://www.apachefriends.org/index.html) on your system.

### Installation Steps
1. **Start XAMPP**:
   - Open XAMPP Control Panel.
   - Start `Apache` and `MySQL` services.

2. **Database Setup**:
   - Open your web browser and go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
   - Create a new database named `bnkms`.
   - Import the database file `bnkms.sql` located in the `DATABASE FILE` directory.

3. **Deploy the Application**:
   - Clone or download the project into the `htdocs` directory of your XAMPP installation (usually located at `C:\xampp\htdocs\`).
   - Ensure the project folder is named appropriately for your setup.

4. **Configure Database Connection**:
   - Navigate to the `db_connect.php` file in the project.
   - Modify the database connection settings if necessary:
     ```php
     $servername = "localhost";
     $username = "root"; // Default XAMPP username
     $password = ""; // Default XAMPP password is empty
     $dbname = "bnkms";
     ```

5. **Access the Application**:
   - Open your web browser and enter the URL `http://localhost/{your_project_folder_name}`.
   - You should see the login page of the Banking Management System.

## Usage
- **Customer**: Log in with customer credentials to access account details, perform fund transfers, manage beneficiaries, and more.
- **Staff**: Log in with staff credentials to manage customer accounts, approve registrations, and handle other administrative tasks.

This README provides an overview of the Banking Management System, its features, and instructions on how to set it up locally using XAMPP.
