<?php
        
session_start();
require("database/conn.php");

// Redirect to login if user is not logged in
if (!isset($_SESSION['doctor'])) {
    header('location: login.php');
    exit(); // Terminate script after redirection
}
if (isset($_SESSION['doctor'])){
$user = $_SESSION['doctor'];
}
else{
    $user=" ";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule</title>
    <link rel="stylesheet" href="css/doctor/doctorscchedules.css">
    <style>
        ul li.active a {
            background-color: #ccc; /* Change to the desired background color */
            padding: 10px; /* Change to the desired padding */
        }
       /* Style for the dialog container */
       #doctor {
    width:50%;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

#doctor form {
    margin-bottom: 10px;
}

#doctor label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

#doctor input[type="text"],
#doctor input[type="number"],
#doctor input[type="time"],
#doctor input[type="file"] {
    width: calc(100% - 22px);
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
} 

#doctor input[type="submit"] {
    width: 100%;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px;
    cursor: pointer;
}

#doctor button {
    width: 100%;
    background-color: #dc3545;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px;
    cursor: pointer;
    margin-top: 10px;
}

#doctor input[type="submit"]:hover,
#doctor button:hover {
    opacity: 0.8;
}


        </style>
</head>
<script>
       document.addEventListener("DOMContentLoaded", function() {
            var currentPage = window.location.href;
            var navLinks = document.querySelectorAll('.navbar_container ul li a');

            navLinks.forEach(function(link) {
                if (link.href === currentPage) {
                    link.parentElement.classList.add('active');
                }
            });
        });
    </script>
<body>
    <?php
    // echo $user;
    // Initialize variables
    // $id = $_POST["id"] ?? null;
    if (isset($_SESSION['doctor'])) {
        $sql = "SELECT * FROM doctor WHERE email='$user';";
        $result = mysqli_query($conn, $sql);
    
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $name = $row['Name'];
            $address = $row['Address'];
            $email = $row['email'];
            $contno = $row['Contactno'];
            $Specialization = $row['Specialization'];
            $fee=$row['Fee'];
            $photo = $row['Photo'];
            $start = $row['starttime'];
            $end = $row['endtime'];
            $date = $row['Date'];
        }
    }
    
    if (isset($_POST['update'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
            // Process the form submission
            $name = $_POST['name'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $contno = $_POST['mobile'];
            $Specialization = $_POST['specialization'];
            $fee = $_POST['fee'];
            $start = $_POST['start'];
            $end = $_POST['end'];
            
            // You should validate and sanitize user input before using it in your SQL query to prevent SQL injection
        
            // Perform the update query
            $sql = "UPDATE doctor SET Name='$name', Address='$address',email='$email', Contactno='$contno', Specialization='$Specialization', Fee='$fee', starttime='$start', endtime='$end' WHERE email='$email'";
        
            if (mysqli_query($conn, $sql)) {
                // echo "Record updated successfully";
            } 
        //     else {
        //         echo "Error updating record: " . mysqli_error($conn);
        //     }
        // }
      
        // else {
        //     echo "Error updating record: " . mysqli_error($conn);
    //     // }
    //echo $photo;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            // echo "Image deleted successfully.";
            // // Delete old photo
            // echo $photo;
            if (!empty($photo) && file_exists("database/doctor/" . $photo)) {
                // echo "Photo deleted successfully.";
                unlink("database/doctor/" . $photo);
            }
            // Upload new photo
            $file_name = $_FILES['image']['name'];
            $file_temp = $_FILES['image']['tmp_name'];
    
            // Specify the target directory for the uploaded file
            $target_dir = "database/doctor/";
            $target_file = $target_dir . basename($file_name);
    
            // Move the uploaded file to the target directory
            if (move_uploaded_file($file_temp, $target_file)) {
                // Update the database with the new photo filename
                $updatePhotoSql = "UPDATE doctor SET photo='$file_name' WHERE email='$user';";
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
}
    ?>
    <div class="navbar">
        <div class="title">
          <h1></h1>
        </div>
        <div class="navbar_container">
        
            <ul>
                <li><a href="doctorschedule.php">Schedule</a></li>
                <li><a href="viewpatient.php">Patient</a></li>
            </ul>
            <div class="login">
          
                <p><?php echo $name;?> </p>
                <?php

                ?>
                <img src="database/doctor/<?php echo $photo?>" alt="" height="40" width="40" onclick="imgClicked()" style="border-radius: 50%;">
               <a href="logout.php"> <button class="logout">Logout</button></a>
            </div>
        </div>
    </div>
    <dialog class="doctor" id="doctor">
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $name;?> " required><br>
        
        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address"value="<?php echo $address;?>" required><br>
        <label for="address">Email:</label><br>
        <input type="email" id="email" name="email"value="<?php echo $email;?>" required><br>
        
        <label for="mobile">Mobile No:</label><br>
        <input type="text" id="mobile" name="mobile" value="<?php echo $contno;?>"required><br>
        
        <label for="specialization">Specialization:</label><br>
        <input type="text" id="specialization" name="specialization"value="<?php echo $Specialization;?>" required><br>
        
        <label for="fee">Fee:</label><br>
        <input type="number" id="fee" name="fee" value="<?php echo $fee;?>"required><br>
        
        <label for="photo">Photo:</label><br>
        <input type="file" id="image" name="image" accept="image/*"><br>
        
        <label for="start">Start Time:</label><br>
        <input type="time" id="start" name="start" value="<?php echo $start;?>"required><br>
        
        <label for="end">End Time:</label><br>
        <input type="time" id="end" name="end"value="<?php echo $end;?>" required><br>
        
        <input type="submit" value="Update"  name="update">
        <button onclick="closedialog()">close</button>
    </form>

    </dialog>