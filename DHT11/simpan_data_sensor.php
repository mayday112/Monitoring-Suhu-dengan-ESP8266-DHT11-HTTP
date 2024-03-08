<?php
include("koneksi.php");

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $temperature = $_GET['temperature'];
    $humidity = $_GET['humidity'];

    $query = "INSERT INTO data_sensor VALUES(null, {$temperature}, {$humidity}, CURRENT_DATE(), CURRENT_TIME())";

    $sql = mysqli_query($conn, $query);

    if($sql) echo "sukses kirim data";
    else die();
}