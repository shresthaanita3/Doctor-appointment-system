<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
         body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

h2 {
    text-align: center;
    margin-top: 20px;
}

form {
    width: 50%;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"],
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>
    <h2>Update User</h2>
    <?php
    // Include your database connection script
    require("database/conn.php");
    
    // Check if user ID is provided via GET parameter
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        
        // Fetch user data from database
        $sql = "SELECT * FROM userdata WHERE sn = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        // Display form with user data
        if ($row) {
            ?>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $row['sn'];?>" >
                <label for="username">User Name:</label>
                <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>" required><br><br>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $row['password']; ?>" required><br><br>
                
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="admin" <?php if($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="doctor" <?php if($row['role'] == 'doctor') echo 'selected'; ?>>Doctor</option>
                    <option value="patient" <?php if($row['role'] == 'patient') echo 'selected'; ?>>patient</option>
                </select><br><br>
                
                <input type="submit" value="Update User">
            </form>
            <?php
        } else {
            echo "User not found.";
        }
    } else {
        echo "User ID not provided.";
    }
    
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $id = $_POST["id"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = md5($_POST["password"]);
        $role = $_POST["role"];
    
        // Update data in the database
        $sql = "UPDATE userdata SET username='$username', email='$email', password='$password', role='$role' WHERE sn='$id'";
        if (mysqli_query($conn, $sql)) {
          header("Location:dashboarduser.php");
          exit();
        } else {
            echo "Error: Unable to update user. " . mysqli_error($conn);
        }
    }
    if (isset($_GET['delete']) && isset($_GET['id'])) {
        $id = $_GET['id'];
        // Delete user from the database
        $sql = "DELETE FROM userdata WHERE sn='$id'";
        if (mysqli_query($conn, $sql)) {
            header("Location: dashboarduser.php");
            exit();
        } else {
            echo "Error: Unable to delete user. " . mysqli_error($conn);
        }
    }
?>
</body>
</html>
