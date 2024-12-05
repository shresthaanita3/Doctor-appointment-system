<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="password"],
        button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
 <?php
// Establishing a connection to the database. Replace these variables with your actual database credentials.
require("database/conn.php");

// Initialize message variable
$message = '';

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $name = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $cpassword = $conn->real_escape_string($_POST['confirm_password']);
    $password = $conn->real_escape_string($_POST['password']);
    $request = "patient";

    // Check if the email already exists in the database
    $sql = "SELECT * FROM `userdata` WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    if ($count == 0) { // If email doesn't exist
        if ($password == $cpassword) {
            // Hashing the password using MD5
            $pass = md5($password);
            // Inserting data into the 'patient' table
            $sql_patient = "INSERT INTO `patient`(`Name`, `Address`, `Email`, `DOB`, `Contactno`)
                            VALUES ('$name', '$address', '$email', '$dob', '$contact')";
            // Inserting data into the 'userdata' table
            $sql_userdata = "INSERT INTO `userdata`(`username`, `email`, `password`, `role`)
                             VALUES ('$name', '$email', '$pass', '$request')";

            // Executing the queries
            if (mysqli_query($conn, $sql_patient) && mysqli_query($conn, $sql_userdata)) {
                // Redirect to the same page with a success message
                $message = 'Registered Successfully';
                echo "<script type='text/javascript'>alert('$message'); window.location.href = 'login.php';</script>";
                exit; // Stop further execution after redirection
            } else {
                $message = 'Error: ' . mysqli_error($conn);
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        } else {
            $message = 'Passwords do not match';
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    } else {
        $message = 'Email already exists';
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
// Close the connection
$conn->close();
?>

<body>
<div class="container">
        <h2>Registration Form</h2>
        <form action="" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <div id="name-error" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <div id="email-error" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact Number:</label>
                <input type="tel" id="contact" name="contact" pattern="[0-9]{10}" required>
                <div id="contact-error" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" minlength="8" required>
                <div id="password-error" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" minlength="8" required>
                <div id="confirm-password-error" class="error-message"></div>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        function validateForm() {
            var isValid = true;

            // Clear previous error messages
            clearErrors();

            // Name validation
            var nameInput = document.getElementById('name');
            var nameValue = nameInput.value.trim();
            if (!/^[A-Z][a-z]+ [A-Z][a-zA-Z]*$/.test(nameValue)) {
                displayError('name-error', 'Name must start with a capital letter and contain only alphabets.');
                isValid = false;
            }

            // Contact number validation
            var contactInput = document.getElementById('contact');
            var contactValue = contactInput.value.trim();
            if (!/^(97|98)\d{8}$/.test(contactValue)) {
                displayError('contact-error', 'Contact number must start with 97 or 98 and have exactly 10 digits.');
                isValid = false;
            }

            // Email validation (checking for @gmail.com)
            var emailInput = document.getElementById('email');
            var emailValue = emailInput.value.trim();
            if (!emailValue.endsWith('@gmail.com')) {
                displayError('email-error', 'Email must be a valid Gmail address.');
                isValid = false;
            }

            // Password strength validation (at least one uppercase, one lowercase, and one special character)
            var passwordInput = document.getElementById('password');
            var passwordValue = passwordInput.value;
            if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\W)/.test(passwordValue)) {
                displayError('password-error', 'Password must contain at least one uppercase letter, one lowercase letter, and one special character.');
                isValid = false;
            }

            // Password match validation
            var confirmPasswordInput = document.getElementById('confirm_password');
            var confirmPasswordValue = confirmPasswordInput.value;
            if (passwordValue !== confirmPasswordValue) {
                displayError('confirm-password-error', 'Passwords do not match.');
                isValid = false;
            }

            return isValid;
        }

        function displayError(id, errorMessage) {
            var errorElement = document.getElementById(id);
            errorElement.textContent = errorMessage;
        }

        function clearErrors() {
            var errorElements = document.querySelectorAll('.error-message');
            errorElements.forEach(function(element) {
                element.textContent = '';
            });
        }
    </script>
</body>
</html>