<?php
include_once("nav.php");

// Redirect to login if user is not logged in
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit(); // Terminate script after redirection
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bookingstyless.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> </script>
    <style>
        {

        }
       body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
       
                
        }
.contain{
    display:flex;
    justify-content:center;
    margin:20px;
}
        .contain1 {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);         
            
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        select, input[type="date"], input[type="file"], input[type="submit"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        input[type="date"] {
            height: 38px; /* Match the height of other inputs */
        }
        /* //session */
        .alert {
    display: flex; /* Use flexbox */
    justify-content: space-between; /* Space between items */
    background-color: #C5E898;
    color: white; /* White text color */
    padding: 15px; /* Padding */
    margin-bottom: 15px; /* Margin bottom */
    border: 1px solid transparent; /* Border */
    border-radius: 4px; /* Border radius */
    width:100%;
}

.alert button {
    background-color: blue; /* Transparent background for the button */
    border: none; /* No border */
    cursor: pointer; /* Cursor style */
}

.alert button i {
    color: white; /* White color for the icon */
}

.alert button:disabled i {
    color: gray; /* Gray color for the icon when disabled */
    cursor: not-allowed; /* Cursor style when disabled */
}



        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            width: 100%;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* img {
            max-width: 100%;
            height: auto;
        } */
    </style>
</head>

<body>
 
<?php


// Check if $_SESSION['insert'] is set
if(isset($_SESSION['insert'])) {
    echo "<div class='alert alert-danger'>";
    echo $_SESSION['insert'];
    echo "<div>";
    echo "<form action method='post'>";
    echo "<button type='submit' name='delete' id='deleteButton'><i class='fa-solid fa-xmark'></i></button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
}

// Check if delete button is clicke


?>




<div class="contain">
    <div class="contain1">
       <form action="database/bookinginsert.php" method="post" enctype="multipart/form-data">
       <h1>Booking Now!!!</h1>
            <div class="form-group">
             
                <label for="Dcname">Doctor Name</label>
                <select name="Dcname" id="Dcname">
               <option value='' selected>None</option>
                    <?php
                     
                            $sql = "SELECT Name FROM `doctor`";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $doctorName = $row['Name'];
                                $Dcname = $row['Name'];
                            
                                echo "<option value=\"$doctorName\"";
                                if ($Dcname == $doctorName)
                                    echo " selected";
                                echo
                                    ">$doctorName</option>";
                            }
                            ?>
                        </select>
            </div>

            <div class="form-group">
                <label for="time">Appointment Time</label>
                <select name="time" id="time">
                    <option value="None">None</option>
                    <option value="10:00-11:00">10:00-11:00</option>
                            <option value="11:00-12:00">11:00-12:00</option>
                            <option value="12:00-1:00">12:00-1:00</option>
                            <option value="2:00-3:00">2:00-3:00</option>
                            <option value="3:00-4:00">3:00-4:00</option>
                            <option value="4:00-5:00">4:00-5:00</option>
                            <option value="5:00-6:00">5:00-6:00</option>
                            <option value="6:00-7:00">6:00-7:00</option>
                </select>
            </div>
            <div class="form-group">
                <label for="apdate">Appointment Date</label>
                <input type="date" name="apdate" id="apdate" min=<?php echo date('Y-m-d');?> value="<?php echo date('Y-m-d');?>" required>
            </div>
            <div class="form-group">
                <label for="QR">QR code</label><br>
                <img src="photo/qr.jpg" alt="QR Code" width="200" height="200">
            </div>
            <div class="form-group">
                <label for="image">QR payment Photo (JPG only)</label>
                <input type="file" name="image" id="image" accept="image/jpeg" required>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Submit">
            </div>
            </div>

        </form>
        </div>
    <?php
    include_once("footer.php");
    ?>
<script>
document.getElementById('deleteButton').addEventListener('click', function() {
  <?php 
     // Unset $_SESSION['insert']
     unset($_SESSION['insert']);
    ?>
});
</script>
</body>

</html>