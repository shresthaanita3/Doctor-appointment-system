<?php
require("conn.php");
   $id = $_GET['id'] ?? null;

if (isset($_GET['delete']) && isset($_GET['id'])) {
    // Get the appointment ID
 

    if ($id) {
        // Fetch the appointment record from the database
        $query = "SELECT * FROM appointment WHERE sn='$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        // Check if the appointment record exists
        if ($row) {
            // Extract the photo filename from the record
            $photo = $row['photo'];

            // Check if the photo exists and delete it
            if (!empty($photo) && file_exists("payment/" . $photo)) {
                if (unlink("payment/" . $photo)) {
                    echo "Photo deleted successfully";
                } else {
                    echo "Failed to delete photo";
                }
            } else {
                echo "Photo file does not exist or the photo field is empty.";
            }

            // Proceed with deleting the appointment record
            $sql = "DELETE FROM appointment WHERE sn='$id'";
            $res = mysqli_query($conn, $sql);

            if ($res) {
                // Redirect to the dashboard after successful deletion
                header("Location: ../viewpatient.php");
                exit; // Ensure that subsequent code is not executed after redirection
            } else {
                // Handle the case where deletion fails
                echo "Error deleting record: " . mysqli_error($conn);
            }
        } else {
            echo "No record found with ID: $id";
        }
    } else {
        echo "Invalid ID";
    }
}
?>