<?php
include("koneksi.php");


$result = mysqli_query($conn, "SELECT temperature FROM data_sensor ORDER BY waktu DESC LIMIT 10");
$listSuhu = mysqli_fetch_all($result);

$suhu = array();
// print_r($listSuhu);
// $suhu = array_reverse($listSuhu);
// echo("[");
foreach($listSuhu as $row){
    $suhu[] = $row[0];
}
// echo("]");
$suhu = array_reverse($suhu);
echo json_encode($suhu);