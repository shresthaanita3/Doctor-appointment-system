
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}

h2 {
    text-align: center;
    margin-top: 30px;
}

form {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
input[type="number"],
input[type="file"],
input[type="time"],input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #4caf50;
    color: white;
    padding: 15px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Optional: Style for error messages */
.error-message {
    color: red;
    font-size: 14px;
    margin-top: 5px;
}

        </style>
</head>
<body>
    <?php
    require("conn.php");

    // Initialize variables
    $id = $_POST["id"] ?? null;
    if ($id) {
        $sql = "SELECT * FROM doctor WHERE sn='$id'";
        $result = mysqli_query($conn, $sql);
    
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $name = $row['Name'];
            $address = $row['Address'];
            $contno = $row['Contactno'];
            $Specialization = $row['Specialization'];
            $email = $row['email'];
            $Fee = $row['Fee'];
            $photo = $row['Photo'];
            $starttime = $row['starttime'];
            $endtime = $row['endtime'];
        }
    }
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
       `starttime`='$start',`endtime`='$end' WHERE sn='$id';";
    
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
                $updatePhotoSql = "UPDATE doctor SET Photo='$file_name' WHERE sn='$id'";
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
    <h2>Update Doctor</h2>
    <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $name?>" required><br>
        
        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address"value="<?php echo $address?>" required><br>
        
        <label for="mobile">Mobile No:</label><br>
        <input type="text" id="mobile" name="mobile" value="<?php echo $contno?>"required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $email?>"required><br>
        
        <label for="specialization">Specialization:</label><br>
        <input type="text" id="specialization" name="specialization"value="<?php echo $Specialization?>" required><br>
        
        <label for="fee">Fee:</label><br>
        <input type="number" id="fee" name="fee" value="<?php echo $Fee?>"required><br>
        
        <label for="photo">Photo:</label><br>
        <input type="file" id="image" name="image" accept="image/*"><br>
        
        <label for="start">Start Time:</label><br>
        <input type="time" id="start" name="start" value="<?php echo $starttime;?>"required><br>
        
        <label for="end">End Time:</label><br>
        <input type="time" id="end" name="end"value="<?php echo $endtime; ?>" required><br>
        
        <input type="submit" value="Update"  name="update">
    </form>
</body>
</html>
