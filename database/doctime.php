<?php
require("conn.php");
session_start();

$user=$_SESSION['username'];
echo $user;
if (isset($_POST['update'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $fee = mysqli_real_escape_string($conn, $_POST['fee']);
        $contno = mysqli_real_escape_string($conn, $_POST['mobile']);;
        $start = mysqli_real_escape_string($conn, $_POST['start']);
        $end = mysqli_real_escape_string($conn, $_POST['end']);
        $Specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
        $updateSql="UPDATE `doctor` SET `Name`='$name',
        `Address`='$address',`email`='$email',`Contactno`='$contno',`Specialization`='$Specialization',`Fee`='$fee`',
       `starttime`='$start',`endtime`='$end' WHERE email='$user';";
    
        if(mysqli_query($conn, $updateSql)) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            echo "Image deleted successfully.";
            if (!empty($photo) && file_exists("doctor/" . $photo)) {
            // Delete old photo
            unlink("payment/" . $photo);
            }
            // Upload new photo
            $file_name = $_FILES['image']['name'];
            $file_temp = $_FILES['image']['tmp_name'];
    
            // Specify the target directory for the uploaded file
            $target_dir = "doctor/";
            $target_file = $target_dir . basename($file_name);
    
            // Move the uploaded file to the target directory
            if (move_uploaded_file($file_temp, $target_file)) {
                // Update the database with the new photo filename
                $updatePhotoSql = "UPDATE doctor SET Photo='$file_name' WHERE email='$user'";
                if (mysqli_query($conn, $updatePhotoSql)) {
                    echo "Photo updated successfully.";
                } else {
                    echo "Error updating photo: " . mysqli_error($conn);
                }
         
            } 
            else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
                // Redirect to the doctor dashboard
                header("Location:../doctordashboard.php");
                exit();
    }
    ?>