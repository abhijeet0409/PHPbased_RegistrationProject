<?php
session_start();
$con = mysqli_connect("localhost","root","","ioclm");

if(isset($_POST['save_datetime']))
{
    $name = $_POST['name']; 
    $purpose = $_POST['purpose'];
    $phone = $_POST['phone'];
    $type = $_POST['t'];
    $event_dt = $_POST['event_dt'];
    $eventt_dt = $_POST['eventt_dt'];

    $query = "INSERT INTO `entry`(`Name`, `Purpose`, `Phone No.`, `Type`, `Entry Time` , `Exit Time`) VALUES ('$name','$purpose','$phone','$type','$event_dt' , '$eventt_dt')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Data Inserted Successfully";
        header("Location: details_entry.php");
    }
    else
    {
        $_SESSION['status'] = "Data Not Inserted";
        header("Location: details_entry.php");
    }
}
?>