<?php
include("koneksi.php");

$result = mysqli_query($conn, "SELECT waktu FROM data_sensor ORDER BY waktu DESC LIMIT 10");
$listWaktu = mysqli_fetch_all($result);

// print_r($listWaktu);
// $waktu = array_reverse($listWaktu);//waktu = [["12-02-2023"],...];
//didalam array waktu terdapat array, maka untuk mengakses tanggal kita memerlukan indeks array yg akan diakses
$waktu = array();

// echo("[");
foreach($listWaktu as $row){
    $waktu[] =$row[0];
}
// echo("]");
$waktu = array_reverse($waktu);
echo json_encode($waktu);