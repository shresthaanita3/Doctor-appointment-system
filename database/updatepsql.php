<?php
require("conn.php");

if(isset($_GET['update'])) {
    // Retrieve form data
    $id = $_GET['id']; // Assuming you have retrieved the ID
    $name = $_GET['Name'];
    $address = $_GET['Address'];
    $email = $_GET['Email'];
    $dob = $_GET['dob'];
    $contno = $_GET['Contno'];
    $dcname = $_GET['Dcname'];
    $time = $_GET['time'];
    $apdate = $_GET['apdate'];
echo "<pre>";
print_r($_GET);
echo "</pre>";
die();
    // Construct the SQL update query
    $updateSql = "UPDATE patient SET 
                    Name='$name', 
                    Address='$address', 
                    Email='$email', 
                    DOB='$dob', 
                    Contactno='$contno', 
                    DoctorName='$dcname', 
                    Appointmenttime='$time', 
                    Appointmentdate='$apdate' 
                  WHERE sn='$id'";

    // Execute the update query
    if(mysqli_query($conn, $updateSql)) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>