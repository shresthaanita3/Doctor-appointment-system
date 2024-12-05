<?php
session_start();
require("database/conn.php");
// echo $user;
// Initialize variables
// $id = $_POST["id"] ?? null;
if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
    $sql = "SELECT * FROM patient WHERE Email='$user';";
    $result = mysqli_query($conn, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $name = $row['Name'];
        $address = $row['Address'];
        $email = $row['Email'];
        $dob = $row['DOB'];
        $contno = $row['Contactno'];
        $photo = $row['photo'];
        // echo "<pre>";
        // print_r($row);
        // echo "<pre>";
    }
}

if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['Name']);
    $address = mysqli_real_escape_string($conn, $_POST['Address']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $contno = mysqli_real_escape_string($conn, $_POST['Contno']);
    $updateSql = "UPDATE patient SET 
        Name='$name', 
        Address='$address', 
        Email='$email', 
        DOB='$dob', 
        Contactno='$contno'
        WHERE Email='$user';";

    if (mysqli_query($conn, $updateSql)) {
        //        echo "Record updated successfully.";
    }
    // else {
    //     echo "Error updating record: " . mysqli_error($conn);
//     // }
// echo $photo;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // echo "Image deleted successfully.";
        // Delete old photo
        if (!empty($photo) && file_exists("photo/" . $photo)) {
            unlink("database/photo/" . $photo);
        }
        // Upload new photo
        $file_name = $_FILES['image']['name'];
        $file_temp = $_FILES['image']['tmp_name'];

        // Specify the target directory for the uploaded file
        $target_dir = "database/photo/";
        $target_file = $target_dir . basename($file_name);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file_temp, $target_file)) {
            // Update the database with the new photo filename
            $updatePhotoSql = "UPDATE patient SET photo='$file_name' WHERE Email='$user';";
            if (mysqli_query($conn, $updatePhotoSql)) {
                // echo "Photo updated successfully.";
            }
            // else {
            //     echo "Error updating photo: " . mysqli_error($conn);
            // }
        }
        // else {
        //     echo "Sorry, there was an error uploading your file.";
        // }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment System</title>
    <link rel="stylesheet" href="css/indexstyle.css">
    <style>
        /* Style the dropdown button */
./* Style the dropdown button */
.dropbtn {
        width: 40px; /* Adjust width as needed */
        height: 40px; /* Adjust height as needed */
        background-color: #f1f1f1; /* Background color */
        border: none; /* Remove border */
        border-radius: 50%; /* Make it round */
        
        display: flex; /* Make the container a flexbox */
        justify-content: center; /* Center content horizontally */
        align-items: center; /* Center content vertically */
    }

 

    /* Assuming you're using Font Awesome for the icon */
    .dropbtn i {
        font-size: 4vh; /* Adjust icon size as needed */
        color: white; /* Icon color */
        cursor: pointer; /* Show pointer cursor on hover */
    }

/* Dropdown container */
.dropdown {
  position: relative;
  display: inline-block;

}

/* Dropdown content (hidden by default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 1px 10px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  left:-45px;

}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {
  background-color: #f1f1f1;
}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}

/* Style the dropdown menu items */
.dropdown-content p {
  margin: 0;
}

/* Style the logout icon */
.fa-sign-out {
  font-size: 10px;
}
.dropdown .dropdown-content a p{
    font-size: 15px;
}
        </style>
    <script src="https://kit.fontawesome.com/1165876da6.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        
        <div class="navbar">
            <ul>
                <li><a href="index.php" id="homeLink">Home</a></li>
                <li><a href="About.php" id="aboutLink">About</a></li>
                <li><a href="booking.php" id="bookingLink">Booking</a></li>
                <li><a href="check.php" id="checkLink">Check</a></li>
                <li><a href="doctor.php" id="doctorLink">Doctor</a></li>
                <li><a href="login.php">Login</a></li>
               <li> <a href="patientsignup.php"><p>SignUp</p></a></i></li>
               <li> <a href="logout.php"><i class="fa-solid fa-right-to-bracket"></i> Logout</a></li>
               

            </ul>
        

    </header>
    
    
</body>

</html>