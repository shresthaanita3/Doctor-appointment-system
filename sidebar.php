
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/admincss/dashboardstyles.css">
    <script src="https://kit.fontawesome.com/1165876da6.js" crossorigin="anonymous"></script>
    <style>
        ul li.active a {
            background-color: #ccc; /* Change to the desired background color */
            padding: 10px; /* Change to the desired padding */
        }
    </style>
</head>
<body>
<section class="contain">
    <h1><div class="logo"> Admin</div></h1>
    <ul>
        <li><a href="dashboard.php" id="dashlink">Dashboard</a></li>
        <li><a href="doctordashboard.php" id="doctorlink">Doctor</a></li>
        <li><a href="dashboardpatient.php" id="patientlink">Patient</a></li>
        <li><a href="dashboardappointment.php" id="appointmentlink">Appointment</a></li>
        <li><a href="dashboarduser.php" id="userlink">User</a></li>
        <li><a href="logout.php" id="logoutlink">logout</a></li>
    </ul>
</section>
<div class="last">
   <section class="sidebar">
    <header>
       <h1></h1>
        <ul>
            
            <li><a href="logout.php"><button type="button">logout</button></a></li>
        </ul>
    </header>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var currentPage = window.location.href;
    var navLinks = document.querySelectorAll('.contain ul li a');

    navLinks.forEach(function(link) {
        if (link.href === currentPage) {
            link.parentElement.classList.add('active');
            console.log("Current Page URL:", currentPage);
            console.log("Matched Link:", link.href);
        }
    });
});

</script>
</body>
</html>

  