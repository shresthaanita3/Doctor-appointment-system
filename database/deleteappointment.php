<?php
require_once('conn.php');
$id = $_GET["id"] ?? null;
$sq = "SELECT * FROM appointment WHERE sn='$id'";
$result = mysqli_query($conn, $sq);
$row = mysqli_fetch_assoc($result);

// Check if $row is null before accessing its elements
if ($row) {
    $photo = $row['photo'];

    // Check if the photo file exists and $photo is not empty before attempting to delete it
    if (!empty($photo) && file_exists("payment/" . $photo)) {
        // Delete the photo file
        if (unlink("payment/".$photo)) {
            echo "Photo deleted successfully";
        } else {
            echo "Failed to delete photo";
        }
    } else {
        echo "Photo file does not exist or the photo field is empty.";
    }

    // Proceed with deletion
    $sql = "DELETE FROM appointment WHERE sn='$id'";
    $res = mysqli_query($conn, $sql);

    if (!$res) {
        // Handle the case where deletion fails
        echo "Error deleting record: " . mysqli_error($conn);
    } else {
        header("Location: ../dashboardpatient.php");
        exit; // Ensure that subsequent code is not executed after redirection
    }
} else {
    echo "No record found with ID: $id";
}

?>
