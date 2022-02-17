<?php
ob_start();
include('../connect2.php');

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_sterilisasi_tahunan.xls");


$tahun = $_POST['tahun'];
$sqlitem="SELECT
  a.instrumen,
  a.ruang,
  SUBSTRING( a.created_sterilisasi_at, 1, 4 ) AS tahun,
  f.userlevelname AS ruangnya,
  b.nama_alat,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '01' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
  AND status_sterilisasi = '2') AS januari,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '02' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
  AND status_sterilisasi = '2') AS februari,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '03' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
  AND status_sterilisasi = '2') AS maret,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '04' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
  AND status_sterilisasi = '2') AS april,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '05' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
  AND status_sterilisasi = '2') AS mei,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '06' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
  AND status_sterilisasi = '2') AS juni,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '07' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
  AND status_sterilisasi = '2') AS juli,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '08' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
  AND status_sterilisasi = '2') AS agustus,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '09' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
  AND status_sterilisasi = '2') AS september,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '10' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
  AND status_sterilisasi = '2') AS oktober,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '11' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
  AND status_sterilisasi = '2') AS november,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '12' 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
  AND status_sterilisasi = '2') AS desember,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND instrumen = a.instrumen 
    AND ruang = a.ruang 
   AND status_sterilisasi = '2'
  ) AS jumlah 
FROM
  t_cssd a
  LEFT JOIN m_alat_cssd b ON b.alat_id = a.instrumen
  LEFT JOIN simrs.userlevels f ON f.userlevelid = a.ruang 
WHERE
  ( a.flag = '3' OR a.flag = '4' ) 
  AND substring( a.created_konfirmasi_at, 1, 4 ) = '".$tahun."' 
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
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '01'
    AND status_sterilisasi = '2'
  ) AS januaritot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '02'
    AND status_sterilisasi = '2'
  ) AS februaritot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '03'
    AND status_sterilisasi = '2'
  ) AS marettot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '04'
    AND status_sterilisasi = '2'
  ) AS apriltot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '05'
    AND status_sterilisasi = '2'
  ) AS meitot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '06'
    AND status_sterilisasi = '2'
  ) AS junitot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '07'
    AND status_sterilisasi = '2'
  ) AS julitot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '08'
    AND status_sterilisasi = '2'
  ) AS agustustot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '09'
    AND status_sterilisasi = '2'
  ) AS septembertot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '10'
    AND status_sterilisasi = '2'
  ) AS oktobertot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '11'
    AND status_sterilisasi = '2'
  ) AS novembertot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 6, 2 ) = '12'
    AND status_sterilisasi = '2'
  ) AS desembertot,
  (
  SELECT COALESCE
    ( sum( jumlah ), 0 ) AS jumlah 
  FROM
    t_cssd 
  WHERE
    ( t_cssd.flag = '3' OR t_cssd.flag = '4' ) 
    AND SUBSTRING( t_cssd.created_sterilisasi_at, 1, 4 ) = SUBSTRING( a.created_sterilisasi_at, 1, 4 ) 
    AND status_sterilisasi = '2'
  ) AS jumlahtot
FROM
  t_cssd a
  LEFT JOIN m_alat_cssd b ON b.alat_id = a.instrumen
  LEFT JOIN simrs.userlevels f ON f.userlevelid = a.ruang 
WHERE
  ( a.flag = '3' OR a.flag = '4' ) 
  AND status_sterilisasi = '2' 
  AND substring( a.created_konfirmasi_at, 1, 4 ) = '".$tahun."' 
  limit 1";
$queryitemtot = mysql_query($sqlitemtot);

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>REKAP DEKONTAMINASI HARIAN</title>
</head>

<body>
  <table width="100%" style="border:0;" cellpadding="0">
                    <tbody>
                        <tr>
                            <td width="100%" align="center"><span class="header"><strong><b>REKAP STERILISASI TAHUNAN TAHUN : <?php echo $tahun; ?>
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
      <td colspan="12" align="center">Bulan</td>
      <td rowspan="2" width="5%" align="center">Jumlah</td>
    </tr>
 
    <tr>
      <td width="5%" align="center">Januari</td>
      <td width="5%" align="center">Februari</td>
      <td width="5%" align="center">Maret</td>
      <td width="5%" align="center">April</td>
      <td width="5%" align="center">Mei</td>
      <td width="5%" align="center">Juni</td>
      <td width="5%" align="center">Juli</td>
      <td width="5%" align="center">Agustus</td>
      <td width="5%" align="center">September</td>
      <td width="5%" align="center">Oktober</td>
      <td width="5%" align="center">November</td>
      <td width="5%" align="center">Desember</td>
    </tr>
    
    <?php 
      $no = 1;
      while($data=mysql_fetch_assoc($queryitem)){
      echo '<tr>';
      echo '<td>'.$no++.'</td>';
       echo '<td>'.$data['ruangnya'].'</td>';
       echo '<td>'.$data['nama_alat'].'</td>';
      echo '<td align="right">'.$data['januari'].'</td>';
      echo '<td align="right">'.$data['februari'].'</td>';
      echo '<td align="right">'.$data['maret'].'</td>';
      echo '<td align="right">'.$data['april'].'</td>';
      echo '<td align="right">'.$data['mei'].'</td>';
      echo '<td align="right">'.$data['juni'].'</td>';
      echo '<td align="right">'.$data['juli'].'</td>';
      echo '<td align="right">'.$data['agustus'].'</td>';
      echo '<td align="right">'.$data['september'].'</td>';
      echo '<td align="right">'.$data['oktober'].'</td>';
      echo '<td align="right">'.$data['november'].'</td>';
      echo '<td align="right">'.$data['desember'].'</td>';
      echo '<td align="right">'.$data['jumlah'].'</td>';      
      echo '</tr>';

    }
      ?>

  <?php 
      while($datanya=mysql_fetch_assoc($queryitemtot)){
      echo '<tr>';
      echo '<td></td>';
       echo '<td colspan="2">Jumlah Total</td>';
      echo '<td align="right">'.$datanya['januaritot'].'</td>';
      echo '<td align="right">'.$datanya['februaritot'].'</td>';
      echo '<td align="right">'.$datanya['marettot'].'</td>';
      echo '<td align="right">'.$datanya['apriltot'].'</td>';
      echo '<td align="right">'.$datanya['meitot'].'</td>';
      echo '<td align="right">'.$datanya['junitot'].'</td>';
      echo '<td align="right">'.$datanya['julitot'].'</td>';
      echo '<td align="right">'.$datanya['agustustot'].'</td>';
      echo '<td align="right">'.$datanya['septembertot'].'</td>';
      echo '<td align="right">'.$datanya['oktobertot'].'</td>';
      echo '<td align="right">'.$datanya['novembertot'].'</td>';
      echo '<td align="right">'.$datanya['desembertot'].'</td>';
      echo '<td align="right">'.$datanya['jumlahtot'].'</td>';      
      echo '</tr>';
    }
      ?>
  </tbody>
</table>
</body>
</html>