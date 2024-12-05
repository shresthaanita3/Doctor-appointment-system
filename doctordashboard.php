<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <style>
        table {
            overflow: hidden;
            width: 100%;
        }
        table, th, td {
            border: 2px solid black;
            border-collapse: collapse;
            /* Adjust font size here */
            font-size: 16px; /* or any other desired size */
            /* Adjust width to fit content */
            width: fit-content; /* or use width: auto; for automatic sizing */
            padding:15px;
            margin:0 auto;
            margin-top:30px;
        }
        
    </style> -->
    <link rel="stylesheet" href="css/admincss/doctordashstyle.css">
    <style> button{
        padding:10px;
        background-color: greenyellow;
        border:none;
        right:0;
        margin:10px;
        font-size:1.5rem;
        float:right;
    }
    button:hover{
        background-color: rgb(139, 206, 40);
        box-shadow: 2px 3px 5px black;
        cursor: pointer;
    }
        </style>
</head>
<body>
    <?php
    include_once("sidebar.php"); // Assuming sidebar.php contains relevant content
    ?>
        <div class="outertable">
        <div class="innertable">
    <table>
        <a href="database/adddoctor.php"><button>Add</buttom> </a> <tr>
            <th>SN</th>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Mobile No</th>
            <th>Specialization</th>
            <th>Fee</th>
            <th>Photo</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th colspan="4">Alter</th>
        </tr>
        <tr>
        <?php
        require("database/conn.php"); // Include your database connection script

        // Execute SELECT query
        $result = mysqli_query($conn, "SELECT * FROM doctor");

        // Check if query was successful
        if ($result && mysqli_num_rows($result) > 0) {
            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row["sn"]; ?></td>
                    <td><?php echo $row["Name"]; ?></td>
                    <td><?php echo $row["Address"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><?php echo $row["Contactno"]; ?></td>
                    <td><?php echo $row["Specialization"]; ?></td>
                    <td><?php echo $row["Fee"]; ?></td>
                    <td><a href="database/doctor/<?php echo $row["Photo"]; ?>"><img src="database/doctor/<?php echo $row["Photo"]; ?>" alt="Payment Screenshot" width="100" height="100"></a></td>
                    <!-- Assuming you store photo path in the database -->
                    <td><?php echo $row["starttime"]; ?></td>
                    <td><?php echo $row["endtime"]; ?></td>
                    <td><form action="database/updatedoctor.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row["sn"];?>">
                        <input type="submit" value="update" class="buttom" name="submit"/>
            </form></td>
                    <td ><form action="database/deletedoctor.php" method="get" onsubmit="return confirm('Are you sure to delete?')">
                        <input type="hidden" name="id" value="<?php echo $row["sn"];?>">
                        <input type="submit" value="Delete" class="buttom" name="submit"/>
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
    </div>
    </div>
</body>
</html>
