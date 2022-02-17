<?php
ob_start();
include('../connect2.php');

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_sterilisasi_bulanan.xls");


$tahun = $_POST['tahun'];
$bulan = $_POST['bulan'];
$sqlitem="SELECT
  a.instrumen,
  a.ruang,
  SUBSTRING( a.created_sterilisasi_at, 1, 4 ) AS tahun,
  SUBSTRING( a.created_sterilisasi_at, 6, 2 ) AS bulan,
  f.userlevelname AS ruangnya,
  b.nama_alat,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '01' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS satu,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '02' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS dua,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '03' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS tiga,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '04' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS empat,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '05' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS lima,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '06' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS enam,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '07' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS tujuh,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '08' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS delapan,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '09' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS sembilan,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '10' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS sepuluh,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '11' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS sebelas,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '12' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duabelas,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '13' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS tigabelas,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '14' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS empatbelas,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '15' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS limabelas,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '16' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS enambelas,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '17' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS tujuhbelas,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '18' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS delapanbelas,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '19' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS sembilanbelas,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '20' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duapuluh,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '21' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duasatu,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '22' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duadua,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '23' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duatiga,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '24' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duaempat,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '25' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS dualima,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '26' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duaenam,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '27' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duatujuh,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '28' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duadelapan,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '29' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duasembilan,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '30' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS tigapuluh,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '31' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS tigasatu ,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 )
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS jumlah
FROM
  t_cssd a
  LEFT JOIN m_alat_cssd b ON b.alat_id = a.instrumen
  LEFT JOIN simrs.userlevels f ON f.userlevelid = a.ruang 
WHERE
  ( a.flag = '3' OR a.flag = '4' ) 
  AND substring( a.created_konfirmasi_at, 1, 4 ) = '".$tahun."' 
  AND substring( a.created_konfirmasi_at, 6, 2 ) = '".$bulan."' 
  AND status_sterilisasi = '2' 
GROUP BY
  a.jenis,
  a.instrumen 
ORDER BY
  f.userlevelid ASC";
$queryitem = mysql_query($sqlitem);

$sqlitemtot="SELECT
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '01' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS satutot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '02' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duatot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '03' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS tigatot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '04' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS empattot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '05' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS limatot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '06' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS enamtot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '07' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS tujuhtot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '08' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS delapantot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '09' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS sembilantot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '10' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS sepuluhtot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '11' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS sebelastot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '12' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duabelastot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '13' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS tigabelastot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '14' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS empatbelastot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '15'  
    AND t_cssd.status_sterilisasi = '2' 
  ) AS limabelastot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '16' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS enambelastot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '17' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS tujuhbelastot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '18' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS delapanbelastot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '19'
    AND t_cssd.status_sterilisasi = '2' 
  ) AS sembilanbelastot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '20' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duapuluhtot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '21' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duasatutot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '22' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duaduatot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '23' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duatigatot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '24' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duaempattot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '25' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS dualimatot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '26'
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duaenamtot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '27'
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duatujuhtot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '28' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duadelapantot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '29' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS duasembilantot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '30' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS tigapuluhtot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 9, 2 ) = '31' 
    AND t_cssd.status_sterilisasi = '2' 
  ) AS tigasatutot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = SUBSTRING( a.created_sterilisasi_at, 6, 2 )
    AND t_cssd.status_sterilisasi = '2' 
  ) AS jumlahtot
FROM
  t_cssd a
  LEFT JOIN m_alat_cssd b ON b.alat_id = a.instrumen
  LEFT JOIN simrs.userlevels f ON f.userlevelid = a.ruang 
WHERE
  ( a.flag = '3' OR a.flag = '4' ) 
  AND status_sterilisasi = '2' 
  AND substring( a.created_konfirmasi_at, 1, 4 ) = '".$tahun."' 
  AND substring( a.created_konfirmasi_at, 6, 2 ) = '".$bulan."' 
  limit 1";
$queryitemtot = mysql_query($sqlitemtot);

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>REKAP STERILISASI HARIAN</title>
</head>

<body>
  <table width="100%" style="border:0;" cellpadding="0">
                    <tbody>
                        <tr>
                            <td width="100%" align="center"><span class="header"><strong><b>REKAP STERILISASI HARIAN,  BULAN : <?php echo $bulan; ?> TAHUN : <?php echo $tahun; ?>
                                        <br>CSSD RSUD AJIBARANG
                                    </b></strong></span></td>
                        </tr>
                        <tr>
                            <td height="20">&nbsp;</td>
                            <td style="text-align:left;" vtext-align="top"></td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>




                    </table>

<table width="100%" cellspacing="0" border="1"  class="penulisan">
  <tbody>
    <tr>
      <td rowspan="2"  width="3%" align="center">NO</td>
      <td rowspan="2" align="center">Ruang</td>
      <td rowspan="2" align="center">Nama INSTRUMEN (SET)</td>
      <td colspan="31" align="center">TANGGAL</td>
      <td rowspan="2" width="5%" align="center">JUMLAH</td>
    </tr>
 
    <tr>
      <td width="2%" align="center">1</td>
      <td width="2%" align="center">2</td>
      <td width="2%" align="center">3</td>
      <td width="2%" align="center">4</td>
      <td width="2%" align="center">5</td>
      <td width="2%" align="center">6</td>
      <td width="2%" align="center">7</td>
      <td width="2%" align="center">8</td>
      <td width="2%" align="center">9</td>
      <td width="2%" align="center">10</td>
      <td width="2%" align="center">11</td>
      <td width="2%" align="center">12</td>
      <td width="2%" align="center">13</td>
      <td width="2%" align="center">14</td>
      <td width="2%" align="center">15</td>
      <td width="2%" align="center">16</td>
      <td width="2%" align="center">17</td>
      <td width="2%" align="center">18</td>
      <td width="2%" align="center">19</td>
      <td width="2%" align="center">20</td>
      <td width="2%" align="center">21</td>
      <td width="2%" align="center">22</td>
      <td width="2%" align="center">23</td>
      <td width="2%" align="center">24</td>
      <td width="2%" align="center">25</td>
      <td width="2%" align="center">26</td>
      <td width="2%" align="center">27</td>
      <td width="2%" align="center">28</td>
      <td width="2%" align="center">29</td>
      <td width="2%" align="center">30</td>
      <td width="2%" align="center">31</td>
    </tr>
    
    <?php 
      $no = 1;
      while($data=mysql_fetch_assoc($queryitem)){
      echo '<tr>';
      echo '<td>'.$no++.'</td>';
       echo '<td>'.$data['ruangnya'].'</td>';
       echo '<td>'.$data['nama_alat'].'</td>';
      echo '<td align="right">'.$data['satu'].'</td>';
      echo '<td align="right">'.$data['dua'].'</td>';
      echo '<td align="right">'.$data['tiga'].'</td>';
      echo '<td align="right">'.$data['empat'].'</td>';
      echo '<td align="right">'.$data['lima'].'</td>';
      echo '<td align="right">'.$data['enam'].'</td>';
      echo '<td align="right">'.$data['tujuh'].'</td>';
      echo '<td align="right">'.$data['delapan'].'</td>';
      echo '<td align="right">'.$data['sembilan'].'</td>';
      echo '<td align="right">'.$data['sepuluh'].'</td>';
      echo '<td align="right">'.$data['sebelas'].'</td>';
      echo '<td align="right">'.$data['duabelas'].'</td>';
      echo '<td align="right">'.$data['tigabelas'].'</td>';
      echo '<td align="right">'.$data['empatbelas'].'</td>';
      echo '<td align="right">'.$data['limabelas'].'</td>';
      echo '<td align="right">'.$data['enambelas'].'</td>';
      echo '<td align="right">'.$data['tujuhbelas'].'</td>';
      echo '<td align="right">'.$data['delapanbelas'].'</td>';
      echo '<td align="right">'.$data['sembilanbelas'].'</td>';
      echo '<td align="right">'.$data['duapuluh'].'</td>';
      echo '<td align="right">'.$data['duasatu'].'</td>';
      echo '<td align="right">'.$data['duadua'].'</td>';
      echo '<td align="right">'.$data['duatiga'].'</td>';
      echo '<td align="right">'.$data['duaempat'].'</td>';
      echo '<td align="right">'.$data['dualima'].'</td>';
      echo '<td align="right">'.$data['duaenam'].'</td>';
      echo '<td align="right">'.$data['duatujuh'].'</td>';
      echo '<td align="right">'.$data['duadelapan'].'</td>';
      echo '<td align="right">'.$data['duasembilan'].'</td>';
      echo '<td align="right">'.$data['tigapuluh'].'</td>';
      echo '<td align="right">'.$data['tigasatu'].'</td>';
      echo '<td align="right">'.$data['jumlah'].'</td>';      
      echo '</tr>';

    }
      ?>

    <?php 
      while($datanya=mysql_fetch_assoc($queryitemtot)){
      echo '<tr>';
      echo '<td></td>';
       echo '<td colspan="2">Jumlah Total</td>';
      echo '<td align="right">'.$datanya['satutot'].'</td>';
      echo '<td align="right">'.$datanya['duatot'].'</td>';
      echo '<td align="right">'.$datanya['tigatot'].'</td>';
      echo '<td align="right">'.$datanya['empattot'].'</td>';
      echo '<td align="right">'.$datanya['limatot'].'</td>';
      echo '<td align="right">'.$datanya['enamtot'].'</td>';
      echo '<td align="right">'.$datanya['tujuhtot'].'</td>';
      echo '<td align="right">'.$datanya['delapantot'].'</td>';
      echo '<td align="right">'.$datanya['sembilantot'].'</td>';
      echo '<td align="right">'.$datanya['sepuluhtot'].'</td>';
      echo '<td align="right">'.$datanya['sebelastot'].'</td>';
      echo '<td align="right">'.$datanya['duabelastot'].'</td>';
      echo '<td align="right">'.$datanya['tigabelastot'].'</td>';
      echo '<td align="right">'.$datanya['empatbelastot'].'</td>';
      echo '<td align="right">'.$datanya['limabelastot'].'</td>';
      echo '<td align="right">'.$datanya['enambelastot'].'</td>';
      echo '<td align="right">'.$datanya['tujuhbelastot'].'</td>';
      echo '<td align="right">'.$datanya['delapanbelastot'].'</td>';
      echo '<td align="right">'.$datanya['sembilanbelastot'].'</td>';
      echo '<td align="right">'.$datanya['duapuluhtot'].'</td>';
      echo '<td align="right">'.$datanya['duasatutot'].'</td>';
      echo '<td align="right">'.$datanya['duaduatot'].'</td>';
      echo '<td align="right">'.$datanya['duatigatot'].'</td>';
      echo '<td align="right">'.$datanya['duaempattot'].'</td>';
      echo '<td align="right">'.$datanya['dualimatot'].'</td>';
      echo '<td align="right">'.$datanya['duaenamtot'].'</td>';
      echo '<td align="right">'.$datanya['duatujuhtot'].'</td>';
      echo '<td align="right">'.$datanya['duadelapantot'].'</td>';
      echo '<td align="right">'.$datanya['duasembilantot'].'</td>';
      echo '<td align="right">'.$datanya['tigapuluhtot'].'</td>';
      echo '<td align="right">'.$datanya['tigasatutot'].'</td>';
      echo '<td align="right">'.$datanya['jumlahtot'].'</td>';      
      echo '</tr>';
    }
      ?>
  </tbody>
</table>
</body>
</html>