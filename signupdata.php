<?php
$con = mysqli_connect("localhost", "root", "", "doctor_appointment_system");

$username = $_POST['username'];
$psword = md5($_POST['password']);
$cpassword = md5($_POST['confirm_password']);
$email = $_POST['email'];
$role = "patient";

$sql = "Select * from user where username='$username'";
$result = mysqli_query($con, $sql);
$num = mysqli_num_rows($result);

if($num == 0) { 
    if(($password == $cpassword) && $exists==false) { 
        $hash= password_hash($psword, PASSWORD_DEFAULT);
//inserting the values
            $insert = "INSERT INTO user VALUES('','$username', '$email','$hash', '$role')";
            mysqli_query($con, $insert);
    }}
if($num>0)  
    { 
       $exists="Username not available";  
    }  
?>