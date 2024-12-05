<!-- <link rel="stylesheet" href="css/admincss/doctordashstyle.css"> -->
<style>
       /*  */
        table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    text-align: center;
}
input[type='submit']{
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    /* margin: 4px 2px; */
    cursor: pointer;
    border-radius: 5px;
   left: 0;
}
.innertable{
    overflow: auto;
    width: 100%;
}
input[type='submit']:hover {
    background-color: #45a049; /* Darker green */
}

/* Active state */
.button:active {
    background-color: #3e8e41;
}
/* Table header cells */
th {
    background-color: #f2f2f2;
    border: 1px solid #ddd;
    padding: 8px;
    /* text-align: left; */
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
    /* cursor: pointer; */
    background-color: #ddd;
 
}
    </style>
<?php
require_once("headerfile/doctornav.php");
// echo $user;
?>
    <div class="container">
        <br>
        <h2>Patient's Appointment List</h2>
        <div class="outertable">
        <div class="innertable">

     
       <table>
        <tr>
            <th>SN</th>
            <th> Paitent Name</th>
            <th>P_Address</th>
            <th>P_email</th>
            <th>DOB</th>
            <th>Contact no</th>
            <th>Appointment Time</th>
            <th>Appointment Date</th>
            <th>Payment screeshot</th>
            <th>Request</th>
            <th colspan="4">Alter</th>
        </tr>
        <tr>
        <?php
   
   

   
        // Execute SELECT query
        $result = mysqli_query($conn, "SELECT * FROM appointment where demail='$user';");

        // Check if query was successful
        if ($result && mysqli_num_rows($result) > 0) {
            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row["sn"]; ?></td>
                    <td><?php echo $row["Name"]; ?></td>
                    <td><?php echo $row["address"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><?php echo $row["DOB"]; ?></td>
                    <td><?php echo $row["Pcontactno"]; ?></td>
                    <td><?php echo $row["Appointmenttime"]; ?></td>
                    <td><?php echo $row["AppointmentDate"]; ?></td>
                    <td><a href="database/payment/<?php echo $row["photo"]; ?>"><img src="database/payment/<?php echo $row["photo"]; ?>" alt="Payment Screenshot" width="100" height="100"></a></td>
                    <td><?php echo $row["request"]; ?></td>
                    <!-- Assuming you store photo path in the database -->
                    <td><form action="database/updateappointment.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row["sn"];?>">
                        <input type="submit" value="update" class="buttom" name="submit"/>
            </form></td>
                    <td ><form action="database/deletedoctop.php" method="get" onsubmit="return confirm('Are you sure to delete?')">
                        <input type="hidden" name="id" value="<?php echo $row["sn"];?>">
                        <input type="submit" value="Delete" class="buttom" name="delete"/>
            </form></td> <!-- Assuming you'll add functionality here -->
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='11'>No records found</td></tr>";
        }

        // Close the database connection
        // mysqli_close($conn);
        ?> 
</tr>
    </table>
    </div>
    </div>
</body>


    <script>
    // Get reference to the dialog element
    const dialog = document.getElementById('doctor');

    // Function to open the dialog
    function imgClicked() {
        dialog.showModal();
    }

    // Function to close the dialog
    function closedialog() {
        dialog.close();
    }
</script>


</html>