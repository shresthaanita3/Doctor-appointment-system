<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/doctorstyle.css">
</head>
<body>
    <?php
    require("nav.php");

    ?>
    <div class="main">
<?php
    require("database/conn.php"); // Include your database connection script

    // Execute SELECT query
    $result = mysqli_query($conn, "SELECT * FROM doctor");

    // Check if query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
?>
        <div class="first">
            <img src="database/doctor/<?php echo $row["Photo"]; ?>" width="100" height="100" alt="" />
            <h4>Dr.<?php echo $row["Name"]; ?></h4>
            <p>Address:<?php echo $row["Address"]; ?></p>
            <p>Specialization: <?php echo $row["Specialization"]; ?></p>
            <p>Contact No: <?php echo $row["Contactno"]; ?></p>
            <p> Fee: <?php echo $row["Fee"]; ?></p>
            <p>Start Time :<?php echo $row["starttime"]; ?></p>
            <p>End Time:<?php echo $row["endtime"]; ?></p>

        </div>
        <?php
        }
    }
        ?>
    </div>
    <?php
    require("footer.php");
    ?>
</body>
</html>