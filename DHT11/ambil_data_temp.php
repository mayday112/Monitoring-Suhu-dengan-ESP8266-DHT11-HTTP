<?php
include("koneksi.php");
$query = ("SELECT temperature FROM data_sensor ORDER BY waktu DESC LIMIT 1");

$result = mysqli_query($conn, $query);

echo mysqli_fetch_assoc($result)['temperature'];