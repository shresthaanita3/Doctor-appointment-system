<?php
$host="localhost";
$user="root";
$pass="";

$conn=mysqli_connect($host,$user,$pass);
$sql="CREATE DATABASE doctoras";
if(mysqli_query($conn,$sql))
{
    echo "Connection";
}else
{
    echo "error";
}
mysqli_close($conn);

?>