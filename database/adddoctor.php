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
input[type="time"] {
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
require("conn.php"); // Include your database connection script

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $address = $_POST["address"];
    $contno = $_POST["mobile"];
    $specialization = $_POST["specialization"];
    $fee = $_POST["fee"];
    $photo = $_FILES["photo"]["name"];
    $starttime = $_POST["start"];
    $endtime = $_POST["end"];
    if (isset($_FILES['photo'])) {
        $file_name = $_FILES['photo']['name'];
        $file_temp = $_FILES['photo']['tmp_name'];
    
        // Move uploaded file to destination directory
        move_uploaded_file($file_temp, "doctor/" . $file_name);
    }
    // Insert doctor information into the database
    $sql = "INSERT INTO doctor (Name, Address, Contactno, Specialization, Fee, Photo, starttime, endtime) 
            VALUES ('$name', '$address', '$contno', '$specialization', '$fee', '$photo', '$starttime', '$endtime')";
    
    if (mysqli_query($conn, $sql)) {
        echo "New doctor record created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>

    <h2>Add Doctor</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"  required><br>
        
        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address"required><br>
        
        <label for="mobile">Mobile No:</label><br>
        <input type="text" id="mobile" name="mobile" required><br>
        
        <label for="specialization">Specialization:</label><br>
        <input type="text" id="specialization" name="specialization" required><br>
        
        <label for="fee">Fee:</label><br>
        <input type="number" id="fee" name="fee" equired><br>
        
        <label for="photo">Photo:</label><br>
        <input type="file" id="photo" name="photo" accept="image/*" required><br>
        
        <label for="start">Start Time:</label><br>
        <input type="time" id="start" name="start" required><br>
        
        <label for="end">End Time:</label><br>
        <input type="time" id="end" name="end" required><br>
        
        <input type="submit" name="submit" value="save">
    </form>
</body>
</html>
