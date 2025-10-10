<?php
include('dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $log_id = $_POST['log_id'];
    $vehicle_ = $_POST['vehicle_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $distance_km = $_POST['distance_km'];
    $fuel_consumed = $_POST['fuel_consumed'];
    $customer_id = $_POST['costumer_id'];
     $report_id = $_POST['report_id'];
      $generated_by = $_POST['generated_by'];
    $query = mysqli_query($con, "INSERT INTO (user_id,username,password,confirm password) VALUES ('$user_id,$username,$password,$confirm password')");

    if ($query) {
        echo "<script>alert('Successfully created record');</script>";
        echo "<script>window.location.href='view.php';</script>";
    } else {
        echo "<script>alert('There was an error');</script>";
    }
}
?>