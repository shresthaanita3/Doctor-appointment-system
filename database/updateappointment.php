<?php
require("conn.php");
session_start();
if(isset($_SESSION['doctor'])){
    $d = $_SESSION['doctor'];
}
// else{
//     $d = $_SESSION['admin'];  
// }


// Fetch appointment details for the form
$id = $_POST["id"] ?? null;

if ($id !== null) {
    $result = mysqli_query($conn, "SELECT * FROM appointment WHERE sn='$id'");
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $name = $row["Name"];
        $Dcname = $row["Dname"];
        $address = $row["address"];
        $email = $row["email"];
        $DOB = $row["DOB"];
        $Pcontactno = $row["Pcontactno"];
        $Appointmenttime = $row["Appointmenttime"];
        $AppointmentDate = $row["AppointmentDate"];
        $request = $row['request'];
        $photo = $row['photo'];
    }
}

if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['Name']);
    $address = mysqli_real_escape_string($conn, $_POST['Address']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $contno = mysqli_real_escape_string($conn, $_POST['Contno']);
    $dcname = mysqli_real_escape_string($conn, $_POST['Dcname']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $res = mysqli_real_escape_string($conn, $_POST['res']);
    $apdate = mysqli_real_escape_string($conn, $_POST['apdate']);

    $updateSql = "UPDATE appointment SET 
        Name='$name', 
        address='$address', 
        email='$email', 
        DOB='$dob', 
        Pcontactno='$contno', 
        Dname='$dcname', 
        Appointmenttime='$time', 
        request='$res', 
        AppointmentDate='$apdate' 
        WHERE sn='$id'";

    if(mysqli_query($conn, $updateSql)) {
     // Set session variable for alert message
    $_SESSION['update_message'] = "Appointment updated successfully.";

    // Handle file upload (if any)
    // ...

    // Redirect to viewpatient.php after processing
    header('Location: ../viewpatient.php');
    exit();
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        echo "Image deleted successfully.";
        // Delete old photo
        unlink("payment/" . $photo);

        // Upload new photo
        $file_name = $_FILES['image']['name'];
        $file_temp = $_FILES['image']['tmp_name'];

        // Specify the target directory for the uploaded file
        $target_dir = "payment/";
        $target_file = $target_dir . basename($file_name);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file_temp, $target_file)) {
            // Update the database with the new photo filename
            $updatePhotoSql = "UPDATE appointment SET photo='$file_name' WHERE sn='$id'";
            if (mysqli_query($conn, $updatePhotoSql)) {
                echo "Photo updated successfully.";
            } else {
                echo "Error updating photo: " . mysqli_error($conn);
            }
            header('Location: ../viewpatient.php');
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="Address"],
input[type="email"],
input[type="date"],
input[type="time"],
input[type="number"],
select {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="file"] {
    margin-top: 10px;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>UPDATE Now!!!</h1>
        <div class="background">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <label for="Name">Name</label>
                <input type="text" name="Name" id="Name" value="<?php echo $name; ?>" required>

                <label for="Address">Address</label>
                <input type="text" name="Address" id="Address" value="<?php echo $address; ?>" required>

                <label for="Email">Email</label>
                <input type="email" name="Email" id="Email" value="<?php echo $email; ?>" required>

                <label for="dob">Date of birth</label>
                <input type="date" name="dob" id="dob" value="<?php echo $DOB; ?>" required>

                <label for="Contno">Contact no</label>
                <input type="number" name="Contno" id="Contno" value="<?php echo $Pcontactno; ?>" required>

                <label for="Dcname">Doctor Name</label>
                <select name="Dcname" id="Dcname">
                    <option value="">None</option>
                    <?php   
                    $sql = "SELECT Name FROM `doctor`";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $doctorName = $row['Name'];
                        echo "<option value=\"$doctorName\"";
                        if ($Dcname == $doctorName) echo " selected";
                        echo ">$doctorName</option>";
                    }
                    ?>
                </select>

                <label for="time">Appointment Time</label>
                <select name="time" id="time">
                    <option value="">None</option>
                    <option value="10:00-11:00" <?php if($Appointmenttime == "10:00-11:00") echo "selected"; ?>>10:00-11:00</option>
                    <option value="11:00-12:00" <?php if($Appointmenttime == "11:00-12:00") echo "selected"; ?>>11:00-12:00</option>
                    <option value="12:00-1:00" <?php if($Appointmenttime == "12:00-1:00") echo "selected"; ?>>12:00-1:00</option>
                    <option value="2:00-3:00" <?php if($Appointmenttime == "2:00-3:00") echo "selected"; ?>>2:00-3:00</option>
                    <option value="3:00-4:00" <?php if($Appointmenttime == "3:00-4:00") echo "selected"; ?>>3:00-4:00</option>
                    <option value="4:00-5:00" <?php if($Appointmenttime == "4:00-5:00") echo "selected"; ?>>4:00-5:00</option>
                    <option value="5:00-6:00" <?php if($Appointmenttime == "5:00-6:00") echo "selected"; ?>>5:00-6:00</option>
                    <option value="6:00-7:00" <?php if($Appointmenttime == "6:00-7:00") echo "selected"; ?>>6:00-7:00</option>
                </select>

                <label for="res">Request</label>
                <select name="res" id="res">
                    <option value="pending" <?php if($request == "pending") echo "selected"; ?>>Pending</option>
                    <option value="Approved" <?php if($request == "Approved") echo "selected"; ?>>Approved</option>
                    <option value="cancelled" <?php if($request == "cancelled") echo "selected"; ?>>cancelled</option>
                    <!-- Include other options -->
                </select>

                <label for="appdate">Appointment Date</label>
                <input type="date" name="apdate" id="apdate" value="<?php echo $AppointmentDate; ?>" required>

                <label for="image">QR payment Photo (JPG only)</label>
                <img src="payment/<?php echo $photo; ?>" alt="payment" width="100" height="100">
                <input type="file" name="image" id="image" accept="image/jpeg">

                <input type="submit" name="update" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>
