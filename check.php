<?php
include_once("nav.php");
require_once("database/conn.php"); // Ensure database connection is included

// Redirect to login if user is not logged in
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit(); // Terminate script after redirection
}

// Assuming that the user's email is stored in the session
$user = $_SESSION['username']; // Adjust this if necessary to get the correct user

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check</title>
    <link rel="stylesheet" href="css/admincss/indexstyle.css">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        .outertable {
            margin: 0 auto;
            margin: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            text-align: center;
        }

        .innertable {
            overflow: auto;
            width: 100%;
        }

        /* Table header cells */
        th {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            padding: 8px;
        }

        /* Table data cells */
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        /* Alternating row colors */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Hover effect on rows */
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>

    <div class="outertable">
        <div class="innertable">

            <table>
                <tr>
                    <th>SN</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>P_Address</th>
                    <th>P_email</th>
                    <th>DOB</th>
                    <th>Contact no</th>
                    <th>Appointment Time</th>
                    <th>Appointment Date</th>
                    <th>Payment Screenshot</th>
                    <th>Request</th>
                </tr>
                <?php
                // Execute SELECT query
                $result = mysqli_query($conn, "SELECT * FROM appointment WHERE email='$user';");

                // Check if query was successful
                if ($result && mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sn = $row['sn'];
                        $photoPath = "database/payment/" . $row['photo'];
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($sn); ?></td>
                            <td><?php echo htmlspecialchars($row['Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Dname']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['DOB']); ?></td>
                            <td><?php echo htmlspecialchars($row['Pcontactno']); ?></td>
                            <td><?php echo htmlspecialchars($row['Appointmenttime']); ?></td>
                            <td><?php echo htmlspecialchars($row['AppointmentDate']); ?></td>
                            <td>
                                <?php if (!empty($row['photo']) && file_exists($photoPath)): ?>
                                    <a href="<?php echo $photoPath; ?>">
                                        <img src="<?php echo $photoPath; ?>" alt="Payment Screenshot" width="100" height="100">
                                    </a>
                                <?php else: ?>
                                    No Screenshot
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['request']); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='11'>No records found</td></tr>";
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
    <br><br><br><br><br><br>
    <?php include_once("footer.php"); ?>
</body>
</html>