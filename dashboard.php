<?php
require_once("database/conn.php");
include_once("sidebar.php");

// Assuming you have a database connection established

// Query to count records in the `doctor` table
$result_doctor = mysqli_query($conn, "SELECT COUNT(*) AS doctor_count FROM `doctor`");
$row_doctor = mysqli_fetch_assoc($result_doctor);
$doctor_count = $row_doctor['doctor_count'];

// Query to count records in the `patient` table
$result_patient = mysqli_query($conn, "SELECT COUNT(*) AS patient_count FROM `patient`");
$row_patient = mysqli_fetch_assoc($result_patient);
$patient_count = $row_patient['patient_count'];

// Query to count records in the `appointment` table
$result_appointment = mysqli_query($conn, "SELECT COUNT(*) AS appointment_count FROM `appointment`");
$row_appointment = mysqli_fetch_assoc($result_appointment);
$appointment_count = $row_appointment['appointment_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="css/admincss/dashboardstyles.css">
    <script src="https://kit.fontawesome.com/1165876da6.js" crossorigin="anonymous"></script> -->
</head>
<body>
   <div class="details">
    <ul>
        <li><i class="fa-solid fa-user-doctor"></i></i><p>Doctor:<span><?php echo $doctor_count; ?></span></p></li>
        <li><i class="fa-solid fa-person"></i><p>Patients:<span><?php echo $patient_count; ?></span></p></li>
        <li><i class="fa-solid fa-calendar-check"></i><p>Appointment:<span><?php echo $appointment_count; ?></span></p></li>
    </ul>
</div>
</body>
</html>
