<?php
require("conn.php");

// Initialize variables
$id = $_POST["id"] ?? null;

if ($id) {
    $sql = "SELECT * FROM patient WHERE sn='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $name = $row['Name'];
        $address = $row['Address'];
        $email = $row['Email'];
        $dob = $row['DOB'];
        $contno = $row['Contactno'];
        $photo = $row['photo'];
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
        WHERE sn='$id'";

    if(mysqli_query($conn, $updateSql)) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
    if (isset($_FILES['image'])) {
        echo "Image deleted successfully.";
        // Delete old photo
        unlink("photo/" . $photo);

        // Upload new photo
        $file_name = $_FILES['image']['name'];
        $file_temp = $_FILES['image']['tmp_name'];

        // Specify the target directory for the uploaded file
        $target_dir = "photo/";
        $target_file = $target_dir . basename($file_name);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file_temp, $target_file)) {
            // Update the database with the new photo filename
            $updatePhotoSql = "UPDATE patient SET photo='$file_name' WHERE sn='$id'";
            if (mysqli_query($conn, $updatePhotoSql)) {
                echo "Photo updated successfully.";
            } else {
                echo "Error updating photo: " . mysqli_error($conn);
            }
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
    <title>Update Patient</title>
    <style>
    /* Style for the body */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
}

/* Style for the container */
.check {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Style for the form container */
.background {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Style for the form elements */
table {
    width: 100%;
}

label {
    font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="date"],
input[type="time"],
input[type="number"],
input[type="file"],
input[type="Address"] {
    width: calc(100% - 10px);
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Responsive styling */
@media screen and (max-width: 600px) {
    .background {
        width: 90%;
    }
}
</style>
</head>
<body>
    <div class="check">
        <div class="background">
            <form action="" method="post" enctype="multipart/form-data">
                <table>
                    <caption><h1>Update Patient Information</h1></caption>
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <tr>
                        <td><label for="Name">Name</label></td>
                        <td><input type="text" name="Name" id="Name" value="<?php echo $name; ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="Address">Address</label></td>
                        <td><input type="text" name="Address" id="Address" value="<?php echo $address; ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="Email">Email</label></td>
                        <td><input type="email" name="Email" id="Email" value="<?php echo $email; ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="Dob">Date of Birth</label></td>
                        <td><input type="date" name="dob" id="dob" value="<?php echo $dob; ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="Contno">Contact Number</label></td>
                        <td><input type="text" name="Contno" id="Contno" value="<?php echo $contno; ?>" required></td>
                    </tr>

                        <td><label for="image">QR Payment Photo (JPG only)</label></td>
                        <td><a href="photo/<?php echo $photo; ?>"><img src="payment/qr<?php echo $photo; ?>" alt="QR Payment" width="100" height="100"></a></td>
                    </tr>
                    <tr>
                        <td><input type="file" name="image" id="image"  accept="image/jpeg"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="update" value="Update"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>

