<?php
include("koneksi.php");


$result = mysqli_query($conn, "SELECT temperature FROM data_sensor ORDER BY waktu DESC LIMIT 10");
$listhumi = mysqli_fetch_all($result);

// print_r($listhumi);
$humi = array();
// echo("[");
foreach($listhumi as $row){
    $humi[] = $row[0];
}
// echo("]");
$humi = array_reverse($humi);
echo json_encode($humi);