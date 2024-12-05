<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/admincss/doctordashstyle.css">
    <style>
      .bt a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
}

.bt a:hover {
    background-color: #0056b3;
}
        </style>

</head>
<body>
    <?php
    include_once("sidebar.php");
    ?>
        <table>
            <div class="bt">
            <a href="adminadd.php">Add</a>
            </div>
        <tr>
            <th>SN</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Role</th>
            <th colspan="4">Alter</th>
        </tr>
        <tr>
        <?php
        require("database/conn.php"); // Include your database connection script

        // Execute SELECT query
        $result = mysqli_query($conn, "SELECT * FROM userdata");

        // Check if query was successful
        if ($result && mysqli_num_rows($result) > 0) {
            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row["sn"]; ?></td>
                    <td><?php echo $row["username"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><?php echo $row["password"]; ?></td>
                    <td><?php echo $row["role"]; ?></td>
              
                    <td><form action="userupdate.php" method="get">
                        <input type="hidden" name="id" value="<?php echo $row["sn"];?>">
                        <input type="submit" value="update" class="buttom" name="update"/>
            </form></td>
                    <td ><form action="userupdate.php" method="get" onsubmit="return confirm('Are you sure to delete?')">
                        <input type="hidden" name="id" value="<?php echo $row["sn"];?>">
                        <input type="submit" value="Delete" class="buttom" name="delete"/>
            </form></td> <!-- Assuming you'll add functionality here -->
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='10'>No records found</td></tr>";
        }
    
        // Close the database connection
        mysqli_close($conn);
        ?>   
        </tr>
        <!-- Add more rows as needed -->
    </table>
    <?php

    ?>
</body>
</html>