<?php
 require("database/conn.php"); // Include your database connection script
require_once("headerfile/doctornav.php");
 ?>
    <div class="container">
        <br>
        <h2>Doctor's Schedule List</h2>
        <table>
            <tr>
                <th style="width: 5%; ">S.N.</th>
                <th style="width: 50%;">Date</th>
                <th>Time</th>
            </tr>
            <tr>
            <?php


        // Execute SELECT query
        $result = mysqli_query($conn, "SELECT * FROM doctor where email='$user';");
        // Check if query was successful
        if ($result && mysqli_num_rows($result) > 0) {
            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td>1</td>
                    <td><?php echo $row["Date"]; ?></td>
                    <td><?php echo $row["starttime"]; ?></td>
                    <td><?php echo $row["endtime"]; ?></td>
                   <?php
            }
        }
        ?>
            </tr>
        </table><br><br>
        <!-- <button class="button add-schedule">Add</button> -->
    </div>
    <script>
    const model = document.querySelector('.model');
    const add = document.querySelector('.add-schedule');
    const close = document.querySelector('.close-schedule');
    const dialog = document.getElementById('doctor');

    function imgClicked() {
        dialog.showModal();
        model.close(); // Close the other dialog
    }

    function closedialog() {
        dialog.close();
    }

    add.addEventListener('click', () => {
        model.showModal();
        dialog.close(); // Close the other dialog
    });

    close.addEventListener('click', () => {
        model.close();
    });

    // Add event listener for the close button inside the doctor dialog
    const doctorCloseBtn = document.querySelector('.doctor button');
    doctorCloseBtn.addEventListener('click', () => {
        dialog.close();
    });
</script>

</body>

</html>