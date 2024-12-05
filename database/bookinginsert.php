<?php
require("conn.php"); // Include your database connection script
session_start();
$user = $_SESSION['username'];

// Handle file upload
if (isset($_FILES['image'])) {
    $file_name = $_FILES['image']['name'];
    $file_temp = $_FILES['image']['tmp_name'];

    // Move uploaded file to destination directory
    move_uploaded_file($file_temp, "payment/" . $file_name);
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $doctorName = $_POST['Dcname'];
    $appointmentTime = $_POST['time'];
    $appointmentDate = $_POST['apdate'];

    // Check if appointment date is empty
    if (empty($appointmentDate)) {
        $_SESSION['insert'] = "Please select an appointment date.";
        header("location: ../booking.php");
        exit();
    }

    // Check if appointment time is empty or None
    if ($appointmentTime == 'None') {
        $_SESSION['insert'] = "Please select an appointment time.";
        header("location: ../booking.php");
        exit();
    }

    // Check if appointment with the same doctor at the same time and date exists
    $checkSql = "SELECT * FROM appointment WHERE Dname='$doctorName' AND Appointmenttime='$appointmentTime' AND AppointmentDate='$appointmentDate'";
    $checkResult = mysqli_query($conn, $checkSql);
    
    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['insert'] = "Appointment with the selected doctor at the same time already exists.";
        header("location: ../booking.php");
        exit();
    }

    // Fetch patient details
    $patientSql = "SELECT * FROM patient WHERE Email='$user'";
    $patientResult = mysqli_query($conn, $patientSql);

    if ($patientResult && mysqli_num_rows($patientResult) > 0) {
        $patientData = mysqli_fetch_assoc($patientResult);

        // Extract patient details
        $name = $patientData['Name'];
        $address = $patientData['Address'];
        $email = $patientData['Email'];
        $dob = $patientData['DOB'];
        $contno = $patientData['Contactno'];

        // Fetch doctor's email based on selected doctor's name
        $doctorEmailSql = "SELECT email FROM `doctor` WHERE Name='$doctorName'";
        $doctorEmailResult = mysqli_query($conn, $doctorEmailSql);

        if ($doctorEmailResult && mysqli_num_rows($doctorEmailResult) > 0) {
            $doctorEmailData = mysqli_fetch_assoc($doctorEmailResult);
            $dmail = $doctorEmailData['email'];

            // Construct and execute the insert query
            $sql = "INSERT INTO appointment (Name, Dname, demail, address, email, DOB, Pcontactno, Appointmenttime, AppointmentDate, photo, request) 
                    VALUES ('$name', '$doctorName', '$dmail', '$address', '$email', '$dob', '$contno', '$appointmentTime', '$appointmentDate', '$file_name', 'pending')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['insert'] = "Data inserted successfully";
                header("location: ../booking.php");
                exit();
            } else {
                $_SESSION['insert'] = "Error inserting data: " . mysqli_error($conn);
                header("location: ../booking.php");
                exit();
            }
        } else {
            $_SESSION['insert'] = "Error fetching doctor's email: " . mysqli_error($conn);
            header("location: ../booking.php");
            exit();
        }
    } else {
        $_SESSION['insert'] = "Error fetching patient details: " . mysqli_error($conn);
        header("location: ../booking.php");
        exit();
    }
} else {
    $_SESSION['insert'] = "Form submission failed.";
    header("location: ../booking.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
