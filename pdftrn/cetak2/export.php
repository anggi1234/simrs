<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=arus_stok.xls");
include 'penunjang/farmasi_arus_stok_obat.php';
?>