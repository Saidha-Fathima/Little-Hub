<?php
$conn=mysqli_connect("localhost","root","","");
$sql="create database lithub_db";
if(mysqli_query($conn,$sql))
echo"database created successfully";
else
echo"error creating database".mysqli_error($conn);
mysqli_close($conn);
?>